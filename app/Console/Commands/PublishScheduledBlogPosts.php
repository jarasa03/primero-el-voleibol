<?php

namespace App\Console\Commands;

use App\Enums\BlogPostStatus;
use App\Models\BlogPost;
use Illuminate\Console\Command;

class PublishScheduledBlogPosts extends Command
{
    protected $signature = 'blog-posts:publish-scheduled';

    protected $description = 'Publish blog posts whose scheduled date has arrived.';

    public function handle(): int
    {
        $publishedCount = 0;

        BlogPost::query()
            ->where('status', BlogPostStatus::Scheduled->value)
            ->whereNotNull('scheduled_for')
            ->where('scheduled_for', '<=', now())
            ->orderBy('scheduled_for')
            ->chunkById(50, function ($blogPosts) use (&$publishedCount): void {
                foreach ($blogPosts as $blogPost) {
                    $blogPost->publishNow();
                    $publishedCount++;
                }
            });

        $this->info(sprintf('Published %d scheduled blog posts.', $publishedCount));

        return self::SUCCESS;
    }
}
