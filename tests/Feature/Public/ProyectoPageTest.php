<?php

use App\Enums\ProjectProposedPersonType;
use App\Enums\ProjectSupporterType;
use App\Models\Project;
use App\Models\ProjectClubSupporter;
use App\Models\ProjectProposedPerson;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;

uses(DatabaseMigrations::class);

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

    ProjectClubSupporter::factory()
        ->create([
            'project_id' => $project->id,
            'supporter_type' => ProjectSupporterType::Club,
            'name' => 'Club Test',
            'description' => 'Club visible en el carrusel',
            'image_path' => 'project/clubs/test-club.jpg',
        ]);

    if (Schema::hasColumn('project_club_supporters', 'supporter_type')) {
        ProjectClubSupporter::factory()
            ->create([
                'project_id' => $project->id,
                'supporter_type' => ProjectSupporterType::Referee,
                'name' => 'Árbitro Test',
                'description' => 'Árbitro visible en el carrusel',
                'image_path' => 'project/supporters/test-referee.jpg',
            ]);

        ProjectClubSupporter::factory()
            ->create([
                'project_id' => $project->id,
                'supporter_type' => ProjectSupporterType::Coach,
                'name' => 'Entrenador Test',
                'description' => 'Entrenador visible en el carrusel',
                'image_path' => 'project/supporters/test-coach.jpg',
            ]);

        ProjectClubSupporter::factory()
            ->create([
                'project_id' => $project->id,
                'supporter_type' => ProjectSupporterType::Player,
                'name' => 'Jugador Test',
                'description' => 'Jugador visible en el carrusel',
                'image_path' => 'project/supporters/test-player.jpg',
            ]);
    }

    $response = $this->get(route('proyecto'));

    $response->assertOk();
    expect($project->fresh()->supporters()->count())->toBe(4);
    if (Schema::hasColumn('project_club_supporters', 'supporter_type')) {
        expect($project->fresh()->clubSupporters()->count())->toBe(1);
        expect($project->fresh()->refereeSupporters()->count())->toBe(1);
        expect($project->fresh()->coachSupporters()->count())->toBe(1);
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
