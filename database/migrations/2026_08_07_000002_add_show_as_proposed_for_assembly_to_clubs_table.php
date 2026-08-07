<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('clubs') || Schema::hasColumn('clubs', 'show_as_proposed_for_assembly')) {
            return;
        }

        Schema::table('clubs', function (Blueprint $table): void {
            $table->boolean('show_as_proposed_for_assembly')->default(false)->after('show_as_collaborator');
        });

        DB::table('clubs')->update([
            'show_as_proposed_for_assembly' => false,
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('clubs') || ! Schema::hasColumn('clubs', 'show_as_proposed_for_assembly')) {
            return;
        }

        Schema::table('clubs', function (Blueprint $table): void {
            $table->dropColumn('show_as_proposed_for_assembly');
        });
    }
};
