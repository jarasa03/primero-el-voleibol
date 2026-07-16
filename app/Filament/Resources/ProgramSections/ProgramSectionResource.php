<?php

namespace App\Filament\Resources\ProgramSections;

use App\Filament\Resources\ProgramSections\Pages\CreateProgramSection;
use App\Filament\Resources\ProgramSections\Pages\EditProgramSection;
use App\Filament\Resources\ProgramSections\Pages\ListProgramSections;
use App\Filament\Resources\ProgramSections\RelationManagers\BeachVolleyballProposalsRelationManager;
use App\Filament\Resources\ProgramSections\RelationManagers\ProgramProposalsRelationManager;
use App\Filament\Resources\ProgramSections\Schemas\ProgramSectionForm;
use App\Filament\Resources\ProgramSections\Tables\ProgramSectionsTable;
use App\Models\ProgramSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProgramSectionResource extends Resource
{
    protected static ?string $model = ProgramSection::class;

    protected static ?string $modelLabel = 'bloque';

    protected static ?string $pluralModelLabel = 'bloques';

    protected static ?string $navigationLabel = 'Programa';

    protected static string|UnitEnum|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProgramSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramSectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProgramProposalsRelationManager::class,
            BeachVolleyballProposalsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProgramSections::route('/'),
            'create' => CreateProgramSection::route('/create'),
            'edit' => EditProgramSection::route('/{record}/edit'),
        ];
    }
}
