<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_section_id',
        'title',
        'description',
        'sort',
        'is_beach_volleyball',
    ];

    protected function casts(): array
    {
        return [
            'is_beach_volleyball' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ProgramProposal $proposal): void {
            if ($proposal->sort === null) {
                $proposal->sort = (int) static::query()
                    ->where('program_section_id', $proposal->program_section_id)
                    ->where('is_beach_volleyball', $proposal->is_beach_volleyball ?? false)
                    ->max('sort') + 1;
            }
        });
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(ProgramSection::class, 'program_section_id');
    }
}
