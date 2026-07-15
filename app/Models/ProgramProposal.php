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
    ];

    protected static function booted(): void
    {
        static::creating(function (ProgramProposal $proposal): void {
            if ($proposal->sort === null) {
                $proposal->sort = (int) static::query()
                    ->where('program_section_id', $proposal->program_section_id)
                    ->max('sort') + 1;
            }
        });
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(ProgramSection::class, 'program_section_id');
    }
}
