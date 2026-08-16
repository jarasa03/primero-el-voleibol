<?php

use App\Models\Club;
use App\Models\Coach;
use App\Models\Player;
use App\Models\Project;
use App\Models\Referee;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the project page with the catalog carousels', function (): void {
    Club::factory()->create([
        'name' => 'Club Visible',
        'description' => 'Club visible en el carrusel',
        'logo_path' => 'clubs/visible.png',
        'show_as_collaborator' => true,
        'show_as_proposed_for_assembly' => true,
    ]);

    Referee::factory()->create([
        'name' => 'Árbitro Visible',
        'description' => 'Árbitro visible en el carrusel',
        'logo_path' => 'referees/visible.png',
        'show_as_collaborator' => true,
        'show_as_proposed_for_assembly' => true,
    ]);

    Coach::factory()->create([
        'name' => 'Entrenador Visible',
        'description' => 'Entrenador visible en el carrusel',
        'logo_path' => 'coaches/visible.png',
        'show_as_collaborator' => true,
        'show_as_proposed_for_assembly' => true,
    ]);

    Player::factory()->create([
        'name' => 'Jugador Visible',
        'description' => 'Jugador visible en el carrusel',
        'logo_path' => 'players/visible.png',
        'show_as_collaborator' => true,
        'show_as_proposed_for_assembly' => true,
    ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    $response->assertSee('Clubes colaboradores');
    $response->assertSee('Árbitros colaboradores');
    $response->assertSee('Entrenadores colaboradores');
    $response->assertSee('Jugadores colaboradores');
    $response->assertSee('Clubes propuestos para la asamblea');
    $response->assertSee('Árbitros propuestos para la asamblea');
    $response->assertSee('Entrenadores propuestos para la asamblea');
    $response->assertSee('Jugadores propuestos para la asamblea');
    $response->assertSee('Club Visible');
    $response->assertSee('Árbitro Visible');
    $response->assertSee('Entrenador Visible');
    $response->assertSee('Jugador Visible');
    expect(substr_count($response->getContent(), 'Aún por definir'))->toBe(53);
});

it('hides the leadership section when disabled', function (): void {
    Project::factory()->create([
        'show_leader_section' => false,
    ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    expect($response->getContent())->not->toContain('Quién lidera el proyecto');
});

it('uses the latest project record for the public page', function (): void {
    Project::factory()->create([
        'show_leader_section' => true,
    ]);

    Project::factory()->create([
        'show_leader_section' => false,
    ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    expect($response->getContent())->not->toContain('Quién lidera el proyecto');
});

it('pads proposed sections up to the configured fixed counts', function (): void {
    Club::factory()->create([
        'name' => 'Club Propuesto',
        'description' => 'Club propuesto visible',
        'logo_path' => 'clubs/proposed.png',
        'show_as_proposed_for_assembly' => true,
    ]);

    Referee::factory()->create([
        'name' => 'Árbitro Propuesto',
        'description' => 'Árbitro propuesto visible',
        'logo_path' => 'referees/proposed.png',
        'show_as_proposed_for_assembly' => true,
    ]);

    Coach::factory()->create([
        'name' => 'Entrenador Propuesto',
        'description' => 'Entrenador propuesto visible',
        'logo_path' => 'coaches/proposed.png',
        'show_as_proposed_for_assembly' => true,
    ]);

    Player::factory()->create([
        'name' => 'Jugador Propuesto',
        'description' => 'Jugador propuesto visible',
        'logo_path' => 'players/proposed.png',
        'show_as_proposed_for_assembly' => true,
    ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    expect($response->getContent())->toContain('Club Propuesto');
    expect($response->getContent())->toContain('Árbitro Propuesto');
    expect($response->getContent())->toContain('Entrenador Propuesto');
    expect($response->getContent())->toContain('Jugador Propuesto');
    expect(substr_count($response->getContent(), 'Aún por definir'))->toBe(53);
});
