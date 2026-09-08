<?php

namespace App\Models;

use App\Enums\ProjectSupporterType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProjectClubSupporter extends Model
{
    use HasFactory;

    protected ?string $previousImagePath = null;

    protected ?string $previousShieldPath = null;

    protected $fillable = [
        'project_id',
        'club_id',
        'supporter_type',
        'name',
        'description',
        'image_path',
        'shield_path',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'supporter_type' => ProjectSupporterType::class,
            'sort' => 'integer',
        ];
    }

    public static function hasSupporterTypeColumn(): bool
    {
        return Schema::hasColumn('project_club_supporters', 'supporter_type');
    }

    protected static function booted(): void
    {
        static::saving(function (ProjectClubSupporter $projectClubSupporter): void {
            if ($projectClubSupporter->image_path === null) {
                $projectClubSupporter->image_path = '';
            }

            if ($projectClubSupporter->shield_path === null) {
                $projectClubSupporter->shield_path = '';
            }

            if ($projectClubSupporter->isDirty('image_path')) {
                $projectClubSupporter->previousImagePath = (string) $projectClubSupporter->getOriginal('image_path');
            }

            if ($projectClubSupporter->isDirty('shield_path')) {
                $projectClubSupporter->previousShieldPath = (string) $projectClubSupporter->getOriginal('shield_path');
            }
        });

        static::saved(function (ProjectClubSupporter $projectClubSupporter): void {
            if ($projectClubSupporter->previousImagePath !== null && $projectClubSupporter->previousImagePath !== '') {
                Storage::disk('public')->delete($projectClubSupporter->previousImagePath);
                $projectClubSupporter->previousImagePath = null;
            }

            if ($projectClubSupporter->previousShieldPath !== null && $projectClubSupporter->previousShieldPath !== '') {
                Storage::disk('public')->delete($projectClubSupporter->previousShieldPath);
                $projectClubSupporter->previousShieldPath = null;
            }
        });

        static::deleted(function (ProjectClubSupporter $projectClubSupporter): void {
            if ($projectClubSupporter->image_path !== '') {
                Storage::disk('public')->delete($projectClubSupporter->image_path);
            }

            if ($projectClubSupporter->shield_path !== '') {
                Storage::disk('public')->delete($projectClubSupporter->shield_path);
            }
        });

        static::creating(function (ProjectClubSupporter $projectClubSupporter): void {
            if (static::hasSupporterTypeColumn() && $projectClubSupporter->supporter_type === null) {
                $projectClubSupporter->supporter_type = ProjectSupporterType::Club;
            }

            if ($projectClubSupporter->sort !== null) {
                return;
            }

            $projectClubSupporter->sort = (int) static::query()
                ->where('project_id', $projectClubSupporter->project_id)
                ->when(
                    static::hasSupporterTypeColumn(),
                    fn ($query) => $query->where('supporter_type', $projectClubSupporter->supporter_type instanceof ProjectSupporterType
                        ? $projectClubSupporter->supporter_type->value
                        : (string) $projectClubSupporter->supporter_type)
                )
                ->max('sort') + 1;
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
}
