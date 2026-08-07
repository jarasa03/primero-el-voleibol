<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectProposedPersonType;

class ProjectProposedClubsRelationManager extends AbstractProjectProposedPeopleRelationManager
{
    protected static ?string $modelLabel = 'club propuesto';

    protected static ?string $pluralModelLabel = 'clubes propuestos';

    protected static ?string $title = 'Clubes propuestos';

    protected static function proposedType(): ProjectProposedPersonType
    {
        return ProjectProposedPersonType::Club;
    }

    protected static function createActionLabel(): string
    {
        return 'Añadir club propuesto';
    }
}
