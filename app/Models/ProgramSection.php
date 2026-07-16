<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort',
        'beach_volleyball_enabled',
    ];

    protected function casts(): array
    {
        return [
            'beach_volleyball_enabled' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ProgramSection $section): void {
            if ($section->sort === null) {
                $section->sort = (int) static::query()->max('sort') + 1;
            }
        });
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(ProgramProposal::class)->orderBy('sort');
    }

    public function mainProposals(): HasMany
    {
        return $this->hasMany(ProgramProposal::class)
            ->where(function ($query): void {
                $query->where('is_beach_volleyball', false)
                    ->orWhereNull('is_beach_volleyball');
            })
            ->orderBy('sort');
    }

    public function beachProposals(): HasMany
    {
        return $this->hasMany(ProgramProposal::class)
            ->where('is_beach_volleyball', true)
            ->orderBy('sort');
    }
}
