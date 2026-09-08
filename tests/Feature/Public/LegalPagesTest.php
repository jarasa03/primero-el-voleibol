<?php

it('shows the legal pages', function (string $uri, string $title) {
    $this->get($uri)
        ->assertSuccessful()
        ->assertSeeText($title);
})->with([
    ['/aviso-legal', 'Aviso legal'],
    ['/politica-de-privacidad', 'Política de Privacidad'],
    ['/politica-de-cookies', 'Politica de cookies'],
]);

it('uses the legal navigation state and responsible details', function (): void {
    foreach (['/aviso-legal', '/politica-de-privacidad', '/politica-de-cookies'] as $uri) {
        $response = $this->get($uri);

        $response->assertSeeHtml('<body class="antialiased page-legal" data-nav-scrolled="true">');
    }

    $this->get('/aviso-legal')
        ->assertSee('Francisco Javier Arruabarrena Sabroso')
        ->assertSee('02821905Q')
        ->assertSee('Calle Sangenjo, 6, 2.º D, 28034 Madrid, España')
        ->assertSee('El titular del sitio web de Primero el Voleibol es')
        ->assertSee(route('legal.politica-de-privacidad'), false)
        ->assertSee(route('legal.politica-de-cookies'), false);

    $this->get('/politica-de-privacidad')
        ->assertSee('Francisco Javier Arruabarrena Sabroso')
        ->assertSee('02821905Q')
        ->assertSee('javier.arrua@primeroelvoleibol.es');
});
