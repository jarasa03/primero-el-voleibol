<?php

use App\Enums\ProjectProposedPersonType;
use App\Enums\ProjectSupporterType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('project_club_supporters')) {
            return;
        }

        $this->restoreCollaboratorCatalogs();
        $this->restoreProposedCatalogs();
    }

    public function down(): void
    {
        // This migration only restores historical data. Reversing it safely
        // would require knowing which rows were later edited in production.
    }

    private function restoreCollaboratorCatalogs(): void
    {
        $catalogs = [
            ProjectSupporterType::Club->value => 'clubs',
            ProjectSupporterType::Referee->value => 'referees',
            ProjectSupporterType::Coach->value => 'coaches',
            ProjectSupporterType::Player->value => 'players',
        ];

        foreach ($catalogs as $type => $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            $legacyRows = DB::table('project_club_supporters')
                ->where('supporter_type', $type)
                ->orderBy('sort')
                ->orderBy('id')
                ->get();

            foreach ($legacyRows as $legacyRow) {
                DB::table($table)->updateOrInsert(
                    ['name' => $legacyRow->name],
                    [
                        'description' => $legacyRow->description,
                        'logo_path' => $legacyRow->image_path ?: $legacyRow->shield_path ?: '',
                        'show_as_collaborator' => true,
                        'show_as_proposed_for_assembly' => false,
                        'sort' => (int) ($legacyRow->sort ?? 0),
                        'created_at' => $legacyRow->created_at,
                        'updated_at' => $legacyRow->updated_at,
                    ],
                );
            }
        }
    }

    private function restoreProposedCatalogs(): void
    {
        if (! Schema::hasTable('project_proposed_people')) {
            return;
        }

        $catalogs = [
            ProjectProposedPersonType::Club->value => 'clubs',
            ProjectProposedPersonType::Referee->value => 'referees',
            ProjectProposedPersonType::Coach->value => 'coaches',
            ProjectProposedPersonType::Player->value => 'players',
        ];

        foreach ($catalogs as $type => $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            $legacyRows = DB::table('project_proposed_people')
                ->where('proposed_type', $type)
                ->orderBy('sort')
                ->orderBy('id')
                ->get();

            foreach ($legacyRows as $legacyRow) {
                $existing = DB::table($table)->where('name', $legacyRow->name)->first();

                DB::table($table)->updateOrInsert(
                    ['name' => $legacyRow->name],
                    [
                        'description' => $existing?->description ?: ($legacyRow->title ?: $legacyRow->description ?: ''),
                        'logo_path' => $existing?->logo_path ?: '',
                        'show_as_collaborator' => (bool) ($existing?->show_as_collaborator ?? false),
                        'show_as_proposed_for_assembly' => true,
                        'sort' => (int) ($existing?->sort ?? $legacyRow->sort ?? 0),
                        'created_at' => $existing?->created_at ?? $legacyRow->created_at,
                        'updated_at' => $legacyRow->updated_at,
                    ],
                );
            }
        }
    }
};
