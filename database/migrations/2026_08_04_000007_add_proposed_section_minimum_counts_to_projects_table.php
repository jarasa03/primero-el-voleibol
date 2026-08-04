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
            $table->unsignedTinyInteger('proposed_referees_minimum_count')->default(3)->after('show_proposed_players_section');
            $table->unsignedTinyInteger('proposed_coaches_minimum_count')->default(3)->after('proposed_referees_minimum_count');
            $table->unsignedTinyInteger('proposed_players_minimum_count')->default(3)->after('proposed_coaches_minimum_count');
        });

        DB::table('projects')->update([
            'proposed_referees_minimum_count' => 3,
            'proposed_coaches_minimum_count' => 3,
            'proposed_players_minimum_count' => 3,
        ]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('projects', 'proposed_players_minimum_count')) {
            Schema::table('projects', function (Blueprint $table): void {
                $table->dropColumn('proposed_players_minimum_count');
            });
        }

        if (Schema::hasColumn('projects', 'proposed_coaches_minimum_count')) {
            Schema::table('projects', function (Blueprint $table): void {
                $table->dropColumn('proposed_coaches_minimum_count');
            });
        }

        if (Schema::hasColumn('projects', 'proposed_referees_minimum_count')) {
            Schema::table('projects', function (Blueprint $table): void {
                $table->dropColumn('proposed_referees_minimum_count');
            });
        }
    }
};
