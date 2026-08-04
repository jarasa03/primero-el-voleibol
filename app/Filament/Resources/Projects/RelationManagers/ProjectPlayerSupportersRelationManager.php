<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectSupporterType;

class ProjectPlayerSupportersRelationManager extends AbstractProjectSupportersRelationManager
{
    protected static ?string $modelLabel = 'jugador';

    protected static ?string $pluralModelLabel = 'jugadores';

    protected static ?string $title = 'Jugadores colaboradores';

    protected static function supporterType(): ProjectSupporterType
    {
        return ProjectSupporterType::Player;
    }

    protected static function createActionLabel(): string
    {
        return 'Añadir jugador';
    }
}
