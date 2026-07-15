<?php

it('renders the home page', function (): void {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Primero el voleibol');
});
