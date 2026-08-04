<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectSupporterType;

class ProjectCoachSupportersRelationManager extends AbstractProjectSupportersRelationManager
{
    protected static ?string $modelLabel = 'entrenador';

    protected static ?string $pluralModelLabel = 'entrenadores';

    protected static ?string $title = 'Entrenadores colaboradores';

    protected static function supporterType(): ProjectSupporterType
    {
        return ProjectSupporterType::Coach;
    }

    protected static function createActionLabel(): string
    {
        return 'Añadir entrenador';
    }
}
