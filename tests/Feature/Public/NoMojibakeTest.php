<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('does not render mojibake on public pages', function (string $routeName): void {
    $response = $this->get(route($routeName));

    $response->assertSuccessful();

    $content = $response->getContent();

    expect($content)->not->toContain('Ã');
    expect($content)->not->toContain('Â');
    expect($content)->not->toContain('�');
})->with([
    'home',
    'proyecto',
    'principios',
    'programa',
    'blog',
    'participa',
    'contacto',
    'legal.aviso-legal',
    'legal.politica-de-privacidad',
    'legal.politica-de-cookies',
]);
