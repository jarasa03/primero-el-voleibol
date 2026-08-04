<?php

namespace App\Filament\Resources\ProjectClubSupporters\Pages;

use App\Filament\Resources\ProjectClubSupporters\ProjectClubSupporterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjectClubSupporters extends ListRecords
{
    protected static string $resource = ProjectClubSupporterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Añadir club'),
        ];
    }
}
