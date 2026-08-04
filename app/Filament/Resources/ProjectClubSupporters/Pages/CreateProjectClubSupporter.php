<?php

namespace App\Filament\Resources\ProjectClubSupporters\Pages;

use App\Filament\Resources\ProjectClubSupporters\ProjectClubSupporterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectClubSupporter extends CreateRecord
{
    protected static string $resource = ProjectClubSupporterResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['project_id'] = ProjectClubSupporterResource::resolveProject()->getKey();

        return $data;
    }

    public function getTitle(): string
    {
        return 'Añadir club';
    }
}
