<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Enums\BlogPostStatus;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
                    ->previewable(false)
                    ->getUploadedFileUsing(static fn (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array => self::getUploadedAttachmentFile($component, $file, $storedFileNames))
                    ->deleteUploadedFileUsing(static function (string $file): void {
                        Log::debug('Blog post attachment delete requested from Filament.', [
                            'file' => $file,
                        ]);
                    })
                    ->afterStateUpdated(static function (mixed $state): void {
                        Log::debug('Blog post attachments field state updated in Filament.', [
                            'state' => $state,
                        ]);
                    })
                    ->openable()
                    ->getOpenableFileUrlUsing(static fn (BaseFileUpload $component, string $file): string => self::getPublicUploadedFileUrl($component, $file))
                    ->downloadable()
                    ->getDownloadableFileUrlUsing(static fn (BaseFileUpload $component, string $file): string => self::getPublicUploadedFileUrl($component, $file))
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

    /**
     * @param  string|array<string, string>|null  $storedFileNames
     * @return array{name: string, size: int, type: ?string, url: string}|null
     */
    private static function getUploadedAttachmentFile(BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array
    {
        $storage = $component->getDisk();

        if (! $storage->exists($file)) {
            return null;
        }

        return [
            'name' => (is_array($storedFileNames) ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($file),
            'size' => $storage->size($file),
            'type' => $storage->mimeType($file),
            'url' => self::getPublicUploadedFileUrl($component, $file),
        ];
    }

    private static function getPublicUploadedFileUrl(BaseFileUpload $component, string $file): string
    {
        $url = $component->getDisk()->url($file);

        return Str::startsWith($url, ['http://', 'https://'])
            ? $url
            : url($url);
    }
}
