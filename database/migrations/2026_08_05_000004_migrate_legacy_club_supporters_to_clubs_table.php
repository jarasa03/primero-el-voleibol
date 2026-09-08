<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('clubs') || ! Schema::hasTable('project_club_supporters')) {
            return;
        }

        if (DB::table('clubs')->exists()) {
            return;
        }

        if (! Schema::hasColumn('project_club_supporters', 'supporter_type')) {
            return;
        }

        $legacyClubs = DB::table('project_club_supporters')
            ->where('supporter_type', 'club')
            ->orderBy('sort')
            ->orderBy('id')
            ->get();

        foreach ($legacyClubs as $legacyClub) {
            DB::table('clubs')->insert([
                'name' => $legacyClub->name,
                'description' => $legacyClub->description,
                'logo_path' => $legacyClub->image_path,
                'show_as_collaborator' => true,
                'sort' => $legacyClub->sort ?? 0,
                'created_at' => $legacyClub->created_at,
                'updated_at' => $legacyClub->updated_at,
            ]);
        }
    }

    public function down(): void {}
};
