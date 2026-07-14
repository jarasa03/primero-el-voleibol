<?php

test('the homepage loads and shows the public brand', function () {
    $this->get('/')
        ->assertSuccessful()
        ->assertSeeText('Primero el Voleibol')
        ->assertSeeText('Poner el voleibol')
        ->assertSeeText('Participa');
});
