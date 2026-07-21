<?php

namespace App\Models;

use App\Enums\BlogPostStatus;
use DOMDocument;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected array $removedAttachments = [];

    protected $fillable = [
        'title',
        'slug',
        'featured_image_path',
        'content',
        'attachments',
        'status',
        'published_at',
        'scheduled_for',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'status' => BlogPostStatus::class,
            'published_at' => 'datetime',
            'scheduled_for' => 'datetime',
            'is_featured' => 'boolean',
            'attachments' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (BlogPost $blogPost): void {
            if (blank($blogPost->slug)) {
                $blogPost->slug = static::generateUniqueSlug($blogPost->title);
            }
        });

        static::saving(function (BlogPost $blogPost): void {
            $blogPost->removedAttachments = [];
            $blogPost->content = static::normalizeContent((string) $blogPost->content);

            $originalAttachments = static::normalizeAttachments(
                json_decode((string) $blogPost->getRawOriginal('attachments'), true)
            );
            $currentAttachments = static::normalizeAttachments($blogPost->attachments);

            $blogPost->attachments = static::normalizeAttachments($blogPost->attachments);
            $blogPost->removedAttachments = array_values(array_diff($originalAttachments, $currentAttachments));

            if ($blogPost->removedAttachments !== []) {
                Log::debug('Blog post attachments marked for deletion.', [
                    'blog_post_id' => $blogPost->getKey(),
                    'removed_attachments' => $blogPost->removedAttachments,
                    'current_attachments' => $currentAttachments,
                ]);
            }

            if ($blogPost->status === BlogPostStatus::Published) {
                if ($blogPost->isDirty('status') || $blogPost->published_at === null) {
                    $blogPost->published_at = now();
                }

                $blogPost->scheduled_for = null;
            }

            if ($blogPost->status === BlogPostStatus::Scheduled) {
                $blogPost->published_at = null;
            }

            if ($blogPost->status === BlogPostStatus::Draft) {
                $blogPost->published_at = null;
                $blogPost->scheduled_for = null;
            }
        });

        static::saved(function (BlogPost $blogPost): void {
            $blogPost->deleteRemovedAttachments();
        });

        static::deleted(function (BlogPost $blogPost): void {
            $blogPost->deleteAttachments($blogPost->normalizedAttachmentPaths());
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', BlogPostStatus::Published->value);
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', BlogPostStatus::Scheduled->value);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function excerpt(int $limit = 180): string
    {
        $content = static::normalizeContent((string) $this->content);
        $content = preg_replace('/<\s*br\s*\/?>/i', ' ', $content) ?? $content;
        $content = preg_replace('/<\/\s*(p|div|li|h[1-6])\s*>/i', ' ', $content) ?? $content;
        $content = strip_tags($content);
        $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $content = preg_replace('/\s+/u', ' ', $content) ?? $content;

        return (string) Str::of($content)->trim()->limit($limit);
    }

    /**
     * @return array<int, array{name: string, url: string, extension: string}>
     */
    public function attachmentItems(): array
    {
        $attachments = [];
        $seenUrls = [];

        foreach ($this->normalizedAttachmentPaths() as $path) {
            $url = Storage::disk('public')->url($path);

            if (in_array($url, $seenUrls, true)) {
                continue;
            }

            $attachments[] = [
                'name' => pathinfo(basename($path), PATHINFO_FILENAME),
                'url' => $url,
                'extension' => strtolower(pathinfo($path, PATHINFO_EXTENSION)) ?: 'file',
            ];

            $seenUrls[] = $url;
        }

        $content = static::normalizeContent((string) $this->content);

        if ($content === '') {
            return $attachments;
        }

        $document = new DOMDocument;
        $previousErrorState = libxml_use_internal_errors(true);

        try {
            $document->loadHTML(
                '<?xml encoding="utf-8" ?>'.$content,
                LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            );
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrorState);
        }

        $imageExtensions = ['avif', 'gif', 'jpeg', 'jpg', 'png', 'svg', 'webp'];

        foreach ($document->getElementsByTagName('a') as $link) {
            $href = trim((string) $link->getAttribute('href'));

            if ($href === '') {
                continue;
            }

            $path = parse_url($href, PHP_URL_PATH) ?: $href;

            if (! Str::startsWith($path, '/storage/')) {
                continue;
            }

            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            if ($extension !== '' && in_array($extension, $imageExtensions, true)) {
                continue;
            }

            if (in_array($href, $seenUrls, true)) {
                continue;
            }

            $seenUrls[] = $href;

            $label = trim($link->textContent) !== '' ? trim($link->textContent) : basename($path);

            $attachments[] = [
                'name' => $label,
                'url' => $href,
                'extension' => $extension !== '' ? $extension : 'file',
            ];
        }

        return $attachments;
    }

    public function renderedContent(): string
    {
        return static::normalizeContent((string) $this->content);
    }

    public function featuredImageUrl(): string
    {
        return Storage::disk('public')->url((string) $this->featured_image_path);
    }

    public function isPublished(): bool
    {
        return $this->status === BlogPostStatus::Published;
    }

    public function isNew(): bool
    {
        return filled($this->published_at) && $this->published_at->greaterThan(now()->subDays(3));
    }

    public function publishNow(): void
    {
        $this->status = BlogPostStatus::Published;
        $this->scheduled_for = null;
        $this->save();
    }

    public function unpublish(): void
    {
        $this->status = BlogPostStatus::Draft;
        $this->save();
    }

    private static function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title) ?: 'articulo';
        $slug = $baseSlug;
        $suffix = 2;

        while (static::query()->where('slug', $slug)->exists()) {
            $slug = sprintf('%s-%d', $baseSlug, $suffix);
            $suffix++;
        }

        return $slug;
    }

    private static function normalizeContent(string $content): string
    {
        $content = trim($content);

        if ($content === '') {
            return '';
        }

        $content = preg_replace(
            '/^(?:(?:<p>|<div>)(?:\s|&nbsp;|<br\s*\/?>)*(?:<\/p>|<\/div>)|<br\s*\/?>|\s|&nbsp;)+/i',
            '',
            $content
        ) ?? $content;

        return trim($content);
    }

    /**
     * @param  array<int, mixed>|null  $attachments
     * @return array<int, string>
     */
    private static function normalizeAttachments(?array $attachments): array
    {
        return collect($attachments ?? [])
            ->map(fn (mixed $attachment): string => trim((string) $attachment))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @return array<int, string>
     */
    private function normalizedAttachmentPaths(): array
    {
        return static::normalizeAttachments($this->attachments);
    }

    /**
     * @param  array<int, string>  $paths
     */
    private function deleteAttachments(array $paths): void
    {
        foreach ($paths as $path) {
            $this->deleteAttachment($path);
        }
    }

    private function deleteRemovedAttachments(): void
    {
        if ($this->removedAttachments === []) {
            return;
        }

        $this->deleteAttachments($this->removedAttachments);

        Log::debug('Blog post removed attachments deleted from disk.', [
            'blog_post_id' => $this->getKey(),
            'removed_attachments' => $this->removedAttachments,
        ]);

        $this->removedAttachments = [];
    }

    private function deleteAttachment(string $path): void
    {
        if ($path === '') {
            return;
        }

        static::deleteAttachmentFiles($path);
    }

    public static function deleteAttachmentFiles(string $path): void
    {
        if ($path === '') {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
