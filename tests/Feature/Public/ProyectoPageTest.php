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
    preg_match_all('/<h2[^>]*>\s*(.*?)\s*<\/h2>/s', $response->getContent(), $headingMatches);
    $renderedHeadings = collect($headingMatches[1])
        ->map(fn (string $heading): string => trim(strip_tags($heading)))
        ->all();

    expect($renderedHeadings)->toContain('Árbitros que suman');
    expect($renderedHeadings)->toContain('Entrenadores que suman');
    expect($renderedHeadings)->toContain('Jugadores que suman');
    expect($renderedHeadings)->toContain('Clubes que suman');
    expect($renderedHeadings)->not->toContain('Árbitros colaboradores');
    expect($renderedHeadings)->not->toContain('Entrenadores colaboradores');
    expect($renderedHeadings)->not->toContain('Jugadores colaboradores');
    expect($renderedHeadings)->not->toContain('Clubes colaboradores');
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

it('hides proposed sections when their visibility is disabled', function (): void {
    Project::factory()->create([
        'show_proposed_clubs_section' => false,
        'show_proposed_referees_section' => false,
        'show_proposed_coaches_section' => false,
        'show_proposed_players_section' => false,
    ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    $response->assertDontSee('Clubes propuestos para la asamblea');
    $response->assertDontSee('Árbitros propuestos para la asamblea');
    $response->assertDontSee('Entrenadores propuestos para la asamblea');
    $response->assertDontSee('Jugadores propuestos para la asamblea');
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
