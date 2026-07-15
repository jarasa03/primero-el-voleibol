<?php

test('the homepage loads and shows the public brand', function () {
    $this->get('/')
        ->assertSuccessful()
        ->assertSeeText('Primero el Voleibol')
        ->assertSeeText('Poner el voleibol')
        ->assertSeeText('Participa')
        ->assertSeeText('Un cierre claro para seguir abriendo conversacion')
        ->assertSeeText('Aviso legal')
        ->assertSeeText('Politica de privacidad')
        ->assertSeeText('Politica de cookies');
});
