<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectSupporterType;

class ProjectClubSupportersRelationManager extends AbstractProjectSupportersRelationManager
{
    protected static ?string $modelLabel = 'club';

    protected static ?string $pluralModelLabel = 'clubes';

    protected static ?string $title = 'Clubes colaboradores';

    protected static function supporterType(): ProjectSupporterType
    {
        return ProjectSupporterType::Club;
    }

    protected static function createActionLabel(): string
    {
        return 'Añadir club';
    }
}
