<?php

namespace App\Filament\Resources\ProgramSections\Pages;

use App\Filament\Resources\ProgramSections\ProgramSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProgramSection extends EditRecord
{
    protected static string $resource = ProgramSectionResource::class;

    public function getTitle(): string
    {
        return 'Editar bloque';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
