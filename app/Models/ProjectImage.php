<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProjectImage extends Model
{
    use HasFactory;

    protected ?string $previousImagePath = null;

    protected $fillable = [
        'project_id',
        'image_path',
        'alt_text',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'sort' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (ProjectImage $projectImage): void {
            if (! $projectImage->isDirty('image_path')) {
                return;
            }

            $projectImage->previousImagePath = (string) $projectImage->getOriginal('image_path');
        });

        static::saved(function (ProjectImage $projectImage): void {
            if ($projectImage->previousImagePath === null || $projectImage->previousImagePath === '') {
                return;
            }

            Storage::disk('public')->delete($projectImage->previousImagePath);
            $projectImage->previousImagePath = null;
        });

        static::deleted(function (ProjectImage $projectImage): void {
            if ($projectImage->image_path === '') {
                return;
            }

            Storage::disk('public')->delete($projectImage->image_path);
        });

        static::creating(function (ProjectImage $projectImage): void {
            if ($projectImage->sort !== null) {
                return;
            }

            $projectImage->sort = (int) static::query()
                ->where('project_id', $projectImage->project_id)
                ->max('sort') + 1;
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
