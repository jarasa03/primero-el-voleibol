<?php

use App\Models\ParticipationIdea;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the participate page with the form', function (): void {
    $response = $this->get(route('participa'));

    $response->assertSuccessful();
    $response->assertSee('¿Quieres reflejar la propuesta de forma privada?');
    $response->assertSee('Enviar idea');
    $response->assertSee('Tu idea');
});

it('stores a participation idea with contact details', function (): void {
    $response = $this->post(route('participa.store'), [
        'response_preference' => 'public',
        'name' => 'Javier Pérez',
        'email' => 'javier@example.com',
        'club_or_role' => 'Entrenador',
        'topic' => 'formacion',
        'idea' => 'Necesitamos una formación anual más clara para unificar criterios entre todas las categorías.',
        'consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('participa'));

    $this->assertDatabaseHas('participation_ideas', [
        'name' => 'Javier Pérez',
        'email' => 'javier@example.com',
        'is_anonymous' => false,
        'club_or_role' => 'Entrenador',
        'topic' => 'formacion',
        'idea' => 'Necesitamos una formación anual más clara para unificar criterios entre todas las categorías.',
        'source' => 'participa-page',
    ]);

    expect(ParticipationIdea::query()->count())->toBe(1);
});

it('stores a private participation idea without identity fields', function (): void {
    $response = $this->post(route('participa.store'), [
        'response_preference' => 'private',
        'name' => '',
        'email' => '',
        'club_or_role' => '',
        'topic' => 'otro',
        'idea' => 'Quiero aportar una mejora concreta sobre cómo se comunican los cambios de horario en las competiciones.',
        'consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('participa'));

    $this->assertDatabaseHas('participation_ideas', [
        'name' => null,
        'email' => null,
        'is_anonymous' => true,
        'topic' => 'otro',
        'source' => 'participa-page',
    ]);
});

it('rejects spam submissions caught by the honeypot', function (): void {
    $response = $this->from(route('participa'))->post(route('participa.store'), [
        'response_preference' => 'public',
        'name' => 'Spam Bot',
        'email' => 'spam@example.com',
        'club_or_role' => '',
        'topic' => 'otro',
        'idea' => 'Esta es una propuesta lo bastante larga para pasar otros controles.',
        'consent' => '1',
        'website' => 'https://spam.example',
    ]);

    $response->assertRedirect(route('participa'));
    $response->assertSessionHasErrors('website');

    $this->assertDatabaseCount('participation_ideas', 0);
});
