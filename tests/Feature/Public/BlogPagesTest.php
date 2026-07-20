<?php

use App\Enums\BlogPostStatus;
use App\Models\BlogPost;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('loads blog posts nine at a time and fetches more through ajax', function (): void {
    collect(range(1, 12))->each(function (int $number): void {
        $blogPost = BlogPost::factory()->published()->create([
            'title' => sprintf('Articulo %d', $number),
            'content' => sprintf('<p>Contenido del articulo %d.</p>', $number),
        ]);

        $blogPost->forceFill([
            'published_at' => now()->subDays($number),
        ])->saveQuietly();
    });

    $nextUrl = null;

    $response = $this->get(route('blog'));

    $response->assertSuccessful()
        ->assertViewHas('posts', function (CursorPaginator $posts) use (&$nextUrl): bool {
            $nextUrl = $posts->nextPageUrl();

            return $posts->count() === 9 && $posts->hasMorePages();
        })
        ->assertSeeText('seguir dando forma al proyecto.')
        ->assertSeeText('Articulo 1')
        ->assertSeeText('Articulo 9')
        ->assertDontSeeText('Articulo 10')
        ->assertDontSeeText('Articulo 12');

    expect($nextUrl)->not->toBeNull();

    parse_str(parse_url($nextUrl, PHP_URL_QUERY) ?? '', $query);

    $payload = $this->get(route('blog', $query), ['X-Requested-With' => 'XMLHttpRequest', 'Accept' => 'application/json'])
        ->assertSuccessful()
        ->json();

    expect($payload)
        ->toBeArray()
        ->and($payload)->toHaveKey('html')
        ->and($payload['next_url'])->toBeNull()
        ->and($payload['html'])
        ->toContain('Articulo 10')
        ->toContain('Articulo 12')
        ->not->toContain('Articulo 9');
});

it('renders the blog index with published entries, featured content and new badges', function (): void {
    $featuredPost = BlogPost::factory()->published(now()->subDays(2))->featured()->create([
        'title' => 'Articulo destacado',
        'content' => '<p>Resumen destacado con</p><p>saltos de linea.</p>',
    ]);

    $newPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Nuevo articulo',
        'content' => '<p>Contenido con <strong>negrita</strong>.</p>',
    ]);

    BlogPost::factory()->published(now()->subDays(10))->create([
        'title' => 'Articulo antiguo',
        'content' => '<p>Contenido mas antiguo.</p>',
    ]);

    BlogPost::factory()->draft()->create([
        'title' => 'Borrador oculto',
    ]);

    BlogPost::factory()->scheduled()->create([
        'title' => 'Programado oculto',
    ]);

    $this->get(route('blog'))
        ->assertSuccessful()
        ->assertViewHas('featuredPost', fn (BlogPost $blogPost): bool => $blogPost->is($featuredPost))
        ->assertSeeText('Destacado')
        ->assertSeeText('Resumen destacado con saltos de linea.')
        ->assertSeeText('Nuevo articulo')
        ->assertSeeText('Articulo antiguo')
        ->assertSeeText('Nuevo!')
        ->assertSeeText('seguir dando forma al proyecto.')
        ->assertDontSeeText('Borrador oculto')
        ->assertDontSeeText('Programado oculto');

    expect($featuredPost->excerpt())->toBe('Resumen destacado con saltos de linea.');
    expect($newPost->isNew())->toBeTrue();
});

it('shows the empty featured state when no post is marked as featured', function (): void {
    BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Articulo normal',
        'content' => '<p>Contenido normal.</p>',
    ]);

    $this->get(route('blog'))
        ->assertSuccessful()
        ->assertDontSeeText('Destacado')
        ->assertDontSeeText('Leer destacado');
});

it('shows a published blog post', function (): void {
    $blogPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Articulo visible',
        'content' => '<p>Texto con <strong>formato</strong> y un <a href="https://example.com">enlace</a>.</p>',
    ]);

    $this->get(route('blog.show', $blogPost))
        ->assertSuccessful()
        ->assertSeeText('Articulo visible')
        ->assertSeeText('Texto con formato y un enlace.')
        ->assertDontSeeText('Autor');
});

it('normalizes leading blank blocks in blog content', function (): void {
    $blogPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Articulo con salto inicial',
        'content' => "<p><br></p>\n<p>Primer parrafo visible.</p>",
    ]);

    expect($blogPost->content)->toBe('<p>Primer parrafo visible.</p>');
    expect($blogPost->renderedContent())->toBe('<p>Primer parrafo visible.</p>');

    $this->get(route('blog.show', $blogPost))
        ->assertSuccessful()
        ->assertSeeText('Primer parrafo visible.')
        ->assertDontSee('<p><br></p>', false);
});

it('shows attached files for a blog post', function (): void {
    Storage::fake('public');

    Storage::disk('public')->put('blog/content/guia-voluntarios.pdf', 'fake pdf content');

    $blogPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Articulo con adjunto',
        'content' => '<p>Descarga el <a href="/storage/blog/content/guia-voluntarios.pdf">PDF de la guia</a>.</p>',
        'featured_image_path' => 'blog/featured/adjunto.jpg',
    ]);

    $this->get(route('blog.show', $blogPost))
        ->assertSuccessful()
        ->assertSeeText('Adjuntos')
        ->assertSeeText('PDF de la guia')
        ->assertSee('/storage/blog/content/guia-voluntarios.pdf', false)
        ->assertSeeText('Abrir');
});

it('shows uploaded attachments for a blog post', function (): void {
    Storage::fake('public');

    Storage::disk('public')->put('blog/attachments/Mi informe 2026.pdf', 'fake pdf content');

    $blogPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Articulo con adjunto subido',
        'attachments' => ['blog/attachments/Mi informe 2026.pdf'],
        'content' => '<p>Contenido del articulo con adjunto.</p>',
        'featured_image_path' => 'blog/featured/adjunto.jpg',
    ]);

    $this->get(route('blog.show', $blogPost))
        ->assertSuccessful()
        ->assertSeeText('Adjuntos')
        ->assertSeeText('Mi informe 2026')
        ->assertDontSeeText('Mi informe 2026.pdf')
        ->assertSee('/storage/blog/attachments/Mi informe 2026.pdf', false)
        ->assertSeeText('Abrir');
});

it('returns a not found response for unpublished blog posts', function (string $status): void {
    $blogPost = BlogPost::factory()->state(fn (): array => [
        'status' => $status === BlogPostStatus::Scheduled->value ? BlogPostStatus::Scheduled : BlogPostStatus::Draft,
        'published_at' => null,
        'scheduled_for' => $status === BlogPostStatus::Scheduled->value ? now()->addHour() : null,
    ])->create([
        'title' => 'Articulo no publico',
    ]);

    $this->get(route('blog.show', $blogPost))
        ->assertNotFound();
})->with([
    BlogPostStatus::Draft->value,
    BlogPostStatus::Scheduled->value,
]);
