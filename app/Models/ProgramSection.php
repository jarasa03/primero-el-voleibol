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
    ];

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
}
