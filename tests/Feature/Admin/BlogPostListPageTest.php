<?php

use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the create button on the blog posts list page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);
    $this->withoutMiddleware(Authenticate::class);

    $response = $this->get(route('filament.admin.resources.blog-posts.index'));

    $response->assertSuccessful();
    $response->assertSee('Crear artículo');
});

it('loads the blog post create page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);
    $this->withoutMiddleware(Authenticate::class);

    $response = $this->get(route('filament.admin.resources.blog-posts.create'));

    $response->assertSuccessful();
    $response->assertSee('Imagen destacada');
    $response->assertSee('Destacado');
    $response->assertSee('Contenido');
});
