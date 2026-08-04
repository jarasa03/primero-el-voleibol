<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('projects', 'show_leader_section')) {
            Schema::table('projects', function (Blueprint $table): void {
                $table->boolean('show_leader_section')->default(true)->after('leader_description');
            });
        }

        DB::table('projects')->update([
            'show_leader_section' => true,
        ]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('projects', 'show_leader_section')) {
            Schema::table('projects', function (Blueprint $table): void {
                $table->dropColumn('show_leader_section');
            });
        }
    }
};
