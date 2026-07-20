<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use App\Enums\BlogPostStatus;
use App\Models\BlogPost;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BlogPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->square(),
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => BlogPostStatus::fromState($state)->label())
                    ->color(fn ($state): string => BlogPostStatus::fromState($state)->color()),
                TextColumn::make('published_at')
                    ->label('Publicado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Pendiente'),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                EditAction::make(),
                Action::make('publishNow')
                    ->label('Publicar ahora')
                    ->color('success')
                    ->action(function (BlogPost $record): void {
                        $record->publishNow();
                    })
                    ->visible(fn (BlogPost $record): bool => $record->status !== BlogPostStatus::Published),
                Action::make('unpublish')
                    ->label('Despublicar')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(function (BlogPost $record): void {
                        $record->unpublish();
                    })
                    ->visible(fn (BlogPost $record): bool => $record->status === BlogPostStatus::Published),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
