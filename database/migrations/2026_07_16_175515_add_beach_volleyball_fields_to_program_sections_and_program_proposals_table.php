<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('program_sections', function (Blueprint $table): void {
            $table->boolean('beach_volleyball_enabled')
                ->default(false)
                ->after('sort');
        });

        Schema::table('program_proposals', function (Blueprint $table): void {
            $table->boolean('is_beach_volleyball')
                ->default(false)
                ->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_proposals', function (Blueprint $table): void {
            $table->dropColumn('is_beach_volleyball');
        });

        Schema::table('program_sections', function (Blueprint $table): void {
            $table->dropColumn('beach_volleyball_enabled');
        });
    }
};
