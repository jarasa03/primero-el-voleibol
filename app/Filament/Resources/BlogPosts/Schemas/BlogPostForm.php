<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Enums\BlogPostStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Estado')
                    ->options(BlogPostStatus::options())
                    ->default(BlogPostStatus::Draft->value)
                    ->required()
                    ->live(),
                Toggle::make('is_featured')
                    ->label('Destacado')
                    ->helperText('Si se activa, esta entrada ocupará la sección destacada del blog.')
                    ->columnSpanFull(),
                DateTimePicker::make('scheduled_for')
                    ->label('Programar publicación')
                    ->native(false)
                    ->seconds(false)
                    ->visible(fn (Get $get): bool => $get('status') === BlogPostStatus::Scheduled->value)
                    ->required(fn (Get $get): bool => $get('status') === BlogPostStatus::Scheduled->value)
                    ->helperText('La entrada se publicará automáticamente cuando llegue esta fecha.'),
                FileUpload::make('featured_image_path')
                    ->label('Imagen destacada')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->disk('public')
                    ->directory('blog/featured')
                    ->visibility('public')
                    ->helperText('Obligatoria. Se usa en la cuadrícula y en la portada del artículo.')
                    ->columnSpanFull(),
                FileUpload::make('attachments')
                    ->label('Adjuntos')
                    ->multiple()
                    ->preserveFilenames()
                    ->disk('public')
                    ->directory('blog/attachments')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->helperText('Sube uno o varios archivos que aparecerán en la sección de adjuntos del artículo.')
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Contenido')
                    ->required()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('blog/content')
                    ->fileAttachmentsVisibility('public')
                    ->preventFileAttachmentPathTampering()
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                        ['h2', 'h3'],
                        ['alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                        ['table'],
                        ['undo', 'redo'],
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
