<?php

namespace App\Filament\Resources\ProjectClubSupporters;

use App\Enums\ProjectSupporterType;
use App\Filament\Resources\ProjectClubSupporters\Pages\CreateProjectClubSupporter;
use App\Filament\Resources\ProjectClubSupporters\Pages\EditProjectClubSupporter;
use App\Filament\Resources\ProjectClubSupporters\Pages\ListProjectClubSupporters;
use App\Models\Project;
use App\Models\ProjectClubSupporter;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ProjectClubSupporterResource extends Resource
{
    protected static ?string $model = ProjectClubSupporter::class;

    protected static ?string $modelLabel = 'club';

    protected static ?string $pluralModelLabel = 'clubes';

    protected static ?string $navigationLabel = 'Clubes del proyecto';

    protected static string|UnitEnum|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function resolveProject(): Project
    {
        return Project::ensureSingleton();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                FileUpload::make('image_path')
                    ->label('Imagen')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->disk('public')
                    ->directory('project/clubs')
                    ->visibility('public')
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Descripción')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                if (! ProjectClubSupporter::hasSupporterTypeColumn()) {
                    return $query;
                }

                return $query->where('supporter_type', ProjectSupporterType::Club->value);
            })
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(90)
                    ->wrap(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjectClubSupporters::route('/'),
            'create' => CreateProjectClubSupporter::route('/create'),
            'edit' => EditProjectClubSupporter::route('/{record}/edit'),
        ];
    }
}
