<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Club extends Model
{
    use HasFactory;

    protected ?string $previousLogoPath = null;

    protected $fillable = [
        'name',
        'description',
        'logo_path',
        'show_as_collaborator',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'show_as_collaborator' => 'boolean',
            'sort' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Club $club): void {
            if (! $club->isDirty('logo_path')) {
                return;
            }

            $club->previousLogoPath = (string) $club->getOriginal('logo_path');
        });

        static::saved(function (Club $club): void {
            if ($club->previousLogoPath === null || $club->previousLogoPath === '') {
                return;
            }

            Storage::disk('public')->delete($club->previousLogoPath);
            $club->previousLogoPath = null;
        });

        static::deleted(function (Club $club): void {
            if ($club->logo_path === '') {
                return;
            }

            Storage::disk('public')->delete($club->logo_path);
        });

        static::creating(function (Club $club): void {
            if ($club->sort !== null) {
                return;
            }

            $club->sort = (int) static::query()->max('sort') + 1;
        });
    }

    public function supporters(): HasMany
    {
        return $this->hasMany(ProjectClubSupporter::class);
    }
}
