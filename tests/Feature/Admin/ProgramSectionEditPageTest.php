<?php

use App\Filament\Resources\ProgramSections\Pages\EditProgramSection;
use App\Filament\Resources\ProgramSections\RelationManagers\BeachVolleyballProposalsRelationManager;
use App\Models\ProgramProposal;
use App\Models\ProgramSection;
use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the beach volleyball proposals table only when the section is enabled', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);
    $this->withoutMiddleware(Authenticate::class);

    $enabledSection = ProgramSection::factory()->create([
        'name' => 'Árbitros',
        'beach_volleyball_enabled' => true,
        'sort' => 1,
    ]);

    ProgramProposal::factory()->create([
        'program_section_id' => $enabledSection->id,
        'title' => 'Propuesta principal',
        'description' => 'Descripción principal.',
        'sort' => 1,
    ]);

    ProgramProposal::factory()->create([
        'program_section_id' => $enabledSection->id,
        'title' => 'Propuesta de voley playa',
        'description' => 'Descripción de voley playa.',
        'sort' => 1,
        'is_beach_volleyball' => true,
    ]);

    $disabledSection = ProgramSection::factory()->create([
        'name' => 'Entrenadores',
        'beach_volleyball_enabled' => false,
        'sort' => 2,
    ]);

    ProgramProposal::factory()->create([
        'program_section_id' => $disabledSection->id,
        'title' => 'Propuesta secundaria',
        'description' => 'Descripción secundaria.',
        'sort' => 1,
    ]);

    $enabledResponse = $this->get(route('filament.admin.resources.program-sections.edit', [
        'record' => $enabledSection,
    ]));

    $enabledResponse->assertSuccessful();
    $enabledResponse->assertSee('Propuestas');
    $enabledResponse->assertSee('Voley playa');
    $enabledResponse->assertSee('Propuesta principal');

    $disabledResponse = $this->get(route('filament.admin.resources.program-sections.edit', [
        'record' => $disabledSection,
    ]));

    $disabledResponse->assertSuccessful();
    $disabledResponse->assertSee('Propuestas');
    $disabledResponse->assertSee('Propuesta secundaria');
    $disabledResponse->assertDontSee('Voley playa');

    expect(BeachVolleyballProposalsRelationManager::canViewForRecord($enabledSection, EditProgramSection::class))->toBeTrue();
    expect(BeachVolleyballProposalsRelationManager::canViewForRecord($disabledSection, EditProgramSection::class))->toBeFalse();
    expect($enabledSection->beachProposals()->count())->toBe(1);
    expect($disabledSection->beachProposals()->count())->toBe(0);
});
