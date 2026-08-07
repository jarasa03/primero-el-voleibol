<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            if (! Schema::hasColumn('projects', 'show_proposed_clubs_section')) {
                $table->boolean('show_proposed_clubs_section')->default(true)->after('show_proposed_players_section');
            }

            if (! Schema::hasColumn('projects', 'proposed_clubs_minimum_count')) {
                $table->unsignedTinyInteger('proposed_clubs_minimum_count')->default(3)->after('proposed_players_minimum_count');
            }
        });

        DB::table('projects')->update([
            'show_proposed_clubs_section' => true,
            'proposed_clubs_minimum_count' => 3,
        ]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('projects', 'proposed_clubs_minimum_count')) {
            Schema::table('projects', function (Blueprint $table): void {
                $table->dropColumn('proposed_clubs_minimum_count');
            });
        }

        if (Schema::hasColumn('projects', 'show_proposed_clubs_section')) {
            Schema::table('projects', function (Blueprint $table): void {
                $table->dropColumn('show_proposed_clubs_section');
            });
        }
    }
};
