<?php

namespace App\Filament\Resources\ProgramSections\Pages;

use App\Filament\Resources\ProgramSections\ProgramSectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProgramSections extends ListRecords
{
    protected static string $resource = ProgramSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Crear bloque'),
        ];
    }
}
