<?php

use App\Enums\BlogPostStatus;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('publishes scheduled posts when the command runs', function (): void {
    $duePost = BlogPost::factory()->scheduled()->create([
        'title' => 'Artículo programado',
        'scheduled_for' => now()->subMinute(),
    ]);

    $futurePost = BlogPost::factory()->scheduled()->create([
        'title' => 'Artículo futuro',
        'scheduled_for' => now()->addDay(),
    ]);

    $this->artisan('blog-posts:publish-scheduled')
        ->assertSuccessful();

    $duePost->refresh();
    $futurePost->refresh();

    expect($duePost->status)->toBe(BlogPostStatus::Published)
        ->and($duePost->published_at)->not->toBeNull()
        ->and($duePost->scheduled_for)->toBeNull()
        ->and($futurePost->status)->toBe(BlogPostStatus::Scheduled)
        ->and($futurePost->published_at)->toBeNull();
});

it('resets publication dates when a post is unpublished', function (): void {
    $blogPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Artículo publicado',
    ]);

    $originalPublishedAt = $blogPost->published_at;

    $blogPost->unpublish();
    $blogPost->refresh();

    expect($blogPost->status)->toBe(BlogPostStatus::Draft)
        ->and($blogPost->published_at)->toBeNull()
        ->and($blogPost->scheduled_for)->toBeNull();

    Carbon::setTestNow($originalPublishedAt->copy()->addMinute());

    try {
        $blogPost->status = BlogPostStatus::Published;
        $blogPost->save();
        $blogPost->refresh();

        expect($blogPost->status)->toBe(BlogPostStatus::Published)
            ->and($blogPost->published_at)->not->toBeNull()
            ->and($blogPost->published_at)->not->toEqual($originalPublishedAt);
    } finally {
        Carbon::setTestNow();
    }
});
