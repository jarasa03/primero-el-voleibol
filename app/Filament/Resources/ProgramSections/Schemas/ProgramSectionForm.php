<?php

namespace App\Filament\Resources\ProgramSections\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                Toggle::make('beach_volleyball_enabled')
                    ->label('Activar voley playa')
                    ->helperText('Muestra la tabla de propuestas de voley playa debajo del bloque.')
                    ->live(),
            ]);
    }
}
