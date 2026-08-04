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
            if (! Schema::hasColumn('projects', 'show_proposed_referees_section')) {
                $table->boolean('show_proposed_referees_section')->default(true)->after('show_leader_section');
            }

            if (! Schema::hasColumn('projects', 'show_proposed_coaches_section')) {
                $table->boolean('show_proposed_coaches_section')->default(true)->after('show_proposed_referees_section');
            }

            if (! Schema::hasColumn('projects', 'show_proposed_players_section')) {
                $table->boolean('show_proposed_players_section')->default(true)->after('show_proposed_coaches_section');
            }
        });

        DB::table('projects')->update([
            'show_proposed_referees_section' => true,
            'show_proposed_coaches_section' => true,
            'show_proposed_players_section' => true,
        ]);
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            if (Schema::hasColumn('projects', 'show_proposed_players_section')) {
                $table->dropColumn('show_proposed_players_section');
            }

            if (Schema::hasColumn('projects', 'show_proposed_coaches_section')) {
                $table->dropColumn('show_proposed_coaches_section');
            }

            if (Schema::hasColumn('projects', 'show_proposed_referees_section')) {
                $table->dropColumn('show_proposed_referees_section');
            }
        });
    }
};
