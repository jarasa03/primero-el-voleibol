<?php

namespace App\Filament\Resources\ProgramSections\Pages;

use App\Filament\Resources\ProgramSections\ProgramSectionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgramSection extends CreateRecord
{
    protected static string $resource = ProgramSectionResource::class;

    public function getTitle(): string
    {
        return 'Crear bloque';
    }
}
