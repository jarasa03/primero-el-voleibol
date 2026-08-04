<?php

namespace App\Models;

use App\Enums\ProjectProposedPersonType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class ProjectProposedPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'proposed_type',
        'name',
        'title',
        'description',
        'initials',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'proposed_type' => ProjectProposedPersonType::class,
            'sort' => 'integer',
        ];
    }

    public static function hasProposedTypeColumn(): bool
    {
        return Schema::hasColumn('project_proposed_people', 'proposed_type');
    }

    protected static function booted(): void
    {
        static::creating(function (ProjectProposedPerson $proposedPerson): void {
            if ($proposedPerson->sort !== null) {
                return;
            }

            $proposedPerson->sort = (int) static::query()
                ->where('project_id', $proposedPerson->project_id)
                ->when(
                    static::hasProposedTypeColumn(),
                    fn ($query) => $query->where('proposed_type', $proposedPerson->proposed_type instanceof ProjectProposedPersonType
                        ? $proposedPerson->proposed_type->value
                        : (string) $proposedPerson->proposed_type)
                )
                ->max('sort') + 1;
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
