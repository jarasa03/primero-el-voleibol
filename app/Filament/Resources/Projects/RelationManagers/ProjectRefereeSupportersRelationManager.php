<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectSupporterType;

class ProjectRefereeSupportersRelationManager extends AbstractProjectSupportersRelationManager
{
    protected static ?string $modelLabel = 'árbitro';

    protected static ?string $pluralModelLabel = 'árbitros';

    protected static ?string $title = 'Árbitros colaboradores';

    protected static function supporterType(): ProjectSupporterType
    {
        return ProjectSupporterType::Referee;
    }

    protected static function createActionLabel(): string
    {
        return 'Añadir árbitro';
    }
}
