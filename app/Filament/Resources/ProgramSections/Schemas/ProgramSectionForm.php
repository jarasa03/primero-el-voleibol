<?php

namespace App\Filament\Resources\ProgramSections\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProgramSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del bloque')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
