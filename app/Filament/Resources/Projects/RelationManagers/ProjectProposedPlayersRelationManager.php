<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectProposedPersonType;

class ProjectProposedPlayersRelationManager extends AbstractProjectProposedPeopleRelationManager
{
    protected static ?string $modelLabel = 'jugador propuesto';

    protected static ?string $pluralModelLabel = 'jugadores propuestos';

    protected static ?string $title = 'Jugadores propuestos';

    protected static function proposedType(): ProjectProposedPersonType
    {
        return ProjectProposedPersonType::Player;
    }

    protected static function createActionLabel(): string
    {
        return 'Añadir jugador propuesto';
    }
}
