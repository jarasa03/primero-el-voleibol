<?php

namespace App\Filament\Resources\ProjectClubSupporters\Pages;

use App\Filament\Resources\ProjectClubSupporters\ProjectClubSupporterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProjectClubSupporter extends EditRecord
{
    protected static string $resource = ProjectClubSupporterResource::class;

    public function getTitle(): string
    {
        return 'Editar club';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
