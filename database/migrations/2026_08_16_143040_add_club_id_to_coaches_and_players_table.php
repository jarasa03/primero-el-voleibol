<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coaches', function (Blueprint $table): void {
            if (! Schema::hasColumn('coaches', 'club_id')) {
                $table->foreignId('club_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete()
                    ->after('logo_path');
            }
        });

        Schema::table('players', function (Blueprint $table): void {
            if (! Schema::hasColumn('players', 'club_id')) {
                $table->foreignId('club_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete()
                    ->after('logo_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('coaches', function (Blueprint $table): void {
            if (Schema::hasColumn('coaches', 'club_id')) {
                $table->dropConstrainedForeignId('club_id');
            }
        });

        Schema::table('players', function (Blueprint $table): void {
            if (Schema::hasColumn('players', 'club_id')) {
                $table->dropConstrainedForeignId('club_id');
            }
        });
    }
};
