<?php

namespace Database\Factories;

use App\Enums\BlogPostStatus;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = Str::limit(fake()->sentence(4), 90, '');

        return [
            'title' => $title,
            'featured_image_path' => 'blog/featured/'.fake()->uuid().'.jpg',
            'content' => '<p>'.fake()->paragraph().'</p><p><strong>'.fake()->sentence(6).'</strong></p>',
            'status' => BlogPostStatus::Published,
            'published_at' => Carbon::now()->subDay(),
            'scheduled_for' => null,
            'is_featured' => false,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => [
            'status' => BlogPostStatus::Draft,
            'published_at' => null,
            'scheduled_for' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (): array => [
            'status' => BlogPostStatus::Scheduled,
            'published_at' => null,
            'scheduled_for' => Carbon::now()->addDay(),
        ]);
    }

    public function published(?Carbon $publishedAt = null): static
    {
        return $this->state(fn (): array => [
            'status' => BlogPostStatus::Published,
            'published_at' => $publishedAt ?? Carbon::now()->subDay(),
            'scheduled_for' => null,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (): array => [
            'is_featured' => true,
        ]);
    }
}
