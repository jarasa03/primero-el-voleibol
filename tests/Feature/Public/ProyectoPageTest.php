<?php

use App\Enums\ProjectProposedPersonType;
use App\Enums\ProjectSupporterType;
use App\Models\Club;
use App\Models\Project;
use App\Models\ProjectClubSupporter;
use App\Models\ProjectProposedPerson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('renders the project page with the support carousels', function (): void {
    $response = $this->get(route('proyecto'));

    $response->assertOk();
    $response->assertSee('Francisco Sabroso');
    $response->assertSee('Clubes colaboradores');
    $response->assertSee('Árbitros colaboradores');
    $response->assertSee('Entrenadores colaboradores');
    $response->assertSee('Jugadores colaboradores');
    $response->assertSee('Árbitros propuestos para la asamblea');
    $response->assertSee('Entrenadores propuestos para la asamblea');
    $response->assertSee('Jugadores propuestos para la asamblea');
    expect(substr_count($response->getContent(), 'data-leader-carousel-interval="5000"'))->toBe(1);
    expect(substr_count($response->getContent(), 'data-marquee-mode="logos"'))->toBe(4);
    expect(substr_count($response->getContent(), 'data-marquee-mode="cards"'))->toBe(0);
    expect(substr_count($response->getContent(), 'data-marquee-direction="right"'))->toBe(2);
    expect(substr_count($response->getContent(), 'data-marquee-direction="left"'))->toBe(2);
});

it('hides the leadership section when disabled', function (): void {
    Project::factory()->create([
        'show_leader_section' => false,
    ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    expect($response->getContent())->not->toContain('Quién lidera el proyecto');
});

it('hides proposed sections when disabled', function (): void {
    Project::factory()->create([
        'show_proposed_referees_section' => false,
        'show_proposed_coaches_section' => false,
        'show_proposed_players_section' => false,
    ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    expect($response->getContent())->not->toContain('Árbitros propuestos para la asamblea');
    expect($response->getContent())->not->toContain('Entrenadores propuestos para la asamblea');
    expect($response->getContent())->not->toContain('Jugadores propuestos para la asamblea');
});

it('pads proposed sections up to the configured minimum', function (): void {
    $project = Project::factory()->create([
        'proposed_referees_minimum_count' => 2,
        'proposed_coaches_minimum_count' => 0,
        'proposed_players_minimum_count' => 0,
    ]);

    ProjectProposedPerson::factory()
        ->create([
            'project_id' => $project->id,
            'proposed_type' => ProjectProposedPersonType::Referee,
            'name' => 'Árbitro Real',
            'title' => 'Árbitro asistente',
            'description' => 'Tarjeta rellena para comprobar el mínimo.',
            'initials' => 'AR',
        ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    expect(substr_count($response->getContent(), 'Aún por definir'))->toBe(1);
});

it('renders supporters from the database', function (): void {
    $project = Project::factory()->create();

    Club::factory()
        ->create([
            'name' => 'Club Test',
            'description' => 'Club visible en el carrusel',
            'logo_path' => 'clubs/test-club-logo.png',
            'show_as_collaborator' => true,
        ]);

    Club::factory()
        ->create([
            'name' => 'Club Oculto',
            'description' => 'No debe aparecer en la página pública',
            'logo_path' => 'clubs/test-club-hidden-logo.png',
            'show_as_collaborator' => false,
        ]);

    if (Schema::hasColumn('project_club_supporters', 'supporter_type')) {
        $coachClub = Club::factory()->create([
            'name' => 'Club Escudo Entrenador',
            'description' => 'Club del entrenador',
            'logo_path' => 'clubs/test-coach-shield.png',
            'show_as_collaborator' => false,
        ]);

        $coachWithoutPhotoClub = Club::factory()->create([
            'name' => 'Club Sin Foto Entrenador',
            'description' => 'Club del entrenador sin foto',
            'logo_path' => 'clubs/test-coach-no-photo-shield.png',
            'show_as_collaborator' => false,
        ]);

        $playerClub = Club::factory()->create([
            'name' => 'Club Escudo Jugador',
            'description' => 'Club del jugador',
            'logo_path' => 'clubs/test-player-shield.png',
            'show_as_collaborator' => false,
        ]);

        DB::table('project_club_supporters')->insert([
            [
                'project_id' => $project->id,
                'supporter_type' => 'club',
                'name' => 'Club Test',
                'description' => 'Club visible en el carrusel',
                'image_path' => '',
                'club_id' => null,
                'sort' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $project->id,
                'supporter_type' => 'referee',
                'name' => 'Árbitro Test',
                'description' => 'Árbitro visible en el carrusel',
                'image_path' => 'project/supporters/test-referee.jpg',
                'club_id' => null,
                'sort' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $project->id,
                'supporter_type' => 'coach',
                'name' => 'Entrenador Test',
                'description' => 'Entrenador visible en el carrusel',
                'image_path' => 'project/supporters/test-coach.jpg',
                'club_id' => $coachClub->getKey(),
                'sort' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $project->id,
                'supporter_type' => 'coach',
                'name' => 'Entrenador Sin Foto',
                'description' => 'Entrenador visible solo con escudo',
                'image_path' => '',
                'club_id' => $coachWithoutPhotoClub->getKey(),
                'sort' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $project->id,
                'supporter_type' => 'player',
                'name' => 'Jugador Test',
                'description' => 'Jugador visible en el carrusel',
                'image_path' => 'project/supporters/test-player.jpg',
                'club_id' => $playerClub->getKey(),
                'sort' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    $response->assertSee('storage/clubs/test-club-logo.png');
    $response->assertDontSee('storage/clubs/test-club-hidden-logo.png');
    $response->assertSee('storage/clubs/test-coach-shield.png');
    $response->assertSee('storage/clubs/test-coach-no-photo-shield.png');
    $response->assertSee('storage/clubs/test-player-shield.png');
    expect($project->fresh()->supporters()->count())->toBe(5);
    if (Schema::hasColumn('project_club_supporters', 'supporter_type')) {
        expect($project->fresh()->clubSupporters()->count())->toBe(1);
        expect($project->fresh()->refereeSupporters()->count())->toBe(1);
        expect($project->fresh()->coachSupporters()->count())->toBe(2);
        expect($project->fresh()->playerSupporters()->count())->toBe(1);
    }
});

it('renders proposed people from the database and allows pending entries', function (): void {
    $project = Project::factory()->create();

    ProjectProposedPerson::factory()
        ->create([
            'project_id' => $project->id,
            'proposed_type' => ProjectProposedPersonType::Referee,
            'name' => 'Árbitro Pendiente',
            'title' => null,
            'description' => 'Primera propuesta para la asamblea',
            'initials' => 'AP',
        ]);

    ProjectProposedPerson::factory()
        ->create([
            'project_id' => $project->id,
            'proposed_type' => ProjectProposedPersonType::Coach,
            'name' => null,
            'title' => null,
            'description' => null,
            'initials' => null,
        ]);

    ProjectProposedPerson::factory()
        ->create([
            'project_id' => $project->id,
            'proposed_type' => ProjectProposedPersonType::Player,
            'name' => 'Jugador Pendiente',
            'title' => 'Capitán',
            'description' => 'Voz de pista y de vestuario',
            'initials' => 'JP',
        ]);

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    expect($project->fresh()->proposedPeople()->count())->toBe(3);
    expect($project->fresh()->proposedReferees()->count())->toBe(1);
    expect($project->fresh()->proposedCoaches()->count())->toBe(1);
    expect($project->fresh()->proposedPlayers()->count())->toBe(1);
    expect($project->fresh()->proposedPeople()->where('name', 'Árbitro Pendiente')->exists())->toBeTrue();
    expect($project->fresh()->proposedPeople()->whereNull('name')->exists())->toBeTrue();
    expect($project->fresh()->proposedPeople()->where('title', 'Capitán')->exists())->toBeTrue();
});
