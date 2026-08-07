<?php

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Projects\RelationManagers\ProjectProposedClubsRelationManager;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers the clubs proposed relation manager in the project resource', function (): void {
    $relations = ProjectResource::getRelations();

    expect($relations)->toHaveKey('proposed_clubs');
    expect($relations['proposed_clubs'])->toBe(ProjectProposedClubsRelationManager::class);
});
