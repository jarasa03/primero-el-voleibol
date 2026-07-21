<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationIdea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'club_or_role',
        'topic',
        'idea',
        'source',
        'is_anonymous',
        'consented_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'consented_at' => 'datetime',
        ];
    }
}
