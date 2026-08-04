<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectProposedPersonType;

class ProjectProposedCoachesRelationManager extends AbstractProjectProposedPeopleRelationManager
{
    protected static ?string $modelLabel = 'entrenador propuesto';

    protected static ?string $pluralModelLabel = 'entrenadores propuestos';

    protected static ?string $title = 'Entrenadores propuestos';

    protected static function proposedType(): ProjectProposedPersonType
    {
        return ProjectProposedPersonType::Coach;
    }

    protected static function createActionLabel(): string
    {
        return 'Añadir entrenador propuesto';
    }
}
