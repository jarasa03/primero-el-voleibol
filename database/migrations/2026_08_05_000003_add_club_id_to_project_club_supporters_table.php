<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('project_club_supporters') || Schema::hasColumn('project_club_supporters', 'club_id')) {
            return;
        }

        Schema::table('project_club_supporters', function (Blueprint $table): void {
            $table->foreignId('club_id')
                ->nullable()
                ->after('project_id')
                ->constrained('clubs')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('project_club_supporters') || ! Schema::hasColumn('project_club_supporters', 'club_id')) {
            return;
        }

        Schema::table('project_club_supporters', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('club_id');
        });
    }
};
