<?php

it('shows the legal pages', function (string $uri, string $title) {
    $this->get($uri)
        ->assertSuccessful()
        ->assertSeeText($title);
})->with([
    ['/aviso-legal', 'Aviso legal'],
    ['/politica-de-privacidad', 'Politica de privacidad'],
    ['/politica-de-cookies', 'Politica de cookies'],
]);
