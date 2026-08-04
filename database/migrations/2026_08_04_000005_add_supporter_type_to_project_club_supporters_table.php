<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('project_club_supporters') || Schema::hasColumn('project_club_supporters', 'supporter_type')) {
            return;
        }

        Schema::table('project_club_supporters', function (Blueprint $table): void {
            $table->string('supporter_type')->default('club')->after('project_id');
        });

        DB::table('project_club_supporters')
            ->whereNull('supporter_type')
            ->update(['supporter_type' => 'club']);
    }

    public function down(): void
    {
        if (! Schema::hasTable('project_club_supporters') || ! Schema::hasColumn('project_club_supporters', 'supporter_type')) {
            return;
        }

        Schema::table('project_club_supporters', function (Blueprint $table): void {
            $table->dropColumn('supporter_type');
        });
    }
};
