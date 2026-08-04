<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectProposedPersonType;

class ProjectProposedRefereesRelationManager extends AbstractProjectProposedPeopleRelationManager
{
    protected static ?string $modelLabel = 'árbitro propuesto';

    protected static ?string $pluralModelLabel = 'árbitros propuestos';

    protected static ?string $title = 'Árbitros propuestos';

    protected static function proposedType(): ProjectProposedPersonType
    {
        return ProjectProposedPersonType::Referee;
    }

    protected static function createActionLabel(): string
    {
        return 'Añadir árbitro propuesto';
    }
}
