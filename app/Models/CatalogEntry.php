<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

abstract class CatalogEntry extends Model
{
    use HasFactory;

    protected ?string $previousLogoPath = null;

    protected $fillable = [
        'name',
        'description',
        'logo_path',
        'show_as_collaborator',
        'show_as_proposed_for_assembly',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'show_as_collaborator' => 'boolean',
            'show_as_proposed_for_assembly' => 'boolean',
            'sort' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $catalogEntry): void {
            if (! $catalogEntry->isDirty('logo_path')) {
                return;
            }

            $catalogEntry->previousLogoPath = (string) $catalogEntry->getOriginal('logo_path');
        });

        static::saved(function (self $catalogEntry): void {
            if ($catalogEntry->previousLogoPath === null || $catalogEntry->previousLogoPath === '') {
                return;
            }

            Storage::disk('public')->delete($catalogEntry->previousLogoPath);
            $catalogEntry->previousLogoPath = null;
        });

        static::deleted(function (self $catalogEntry): void {
            if ($catalogEntry->logo_path === '') {
                return;
            }

            Storage::disk('public')->delete($catalogEntry->logo_path);
        });

        static::creating(function (self $catalogEntry): void {
            if ($catalogEntry->sort !== null) {
                return;
            }

            $catalogEntry->sort = (int) static::query()->max('sort') + 1;
        });
    }
}
