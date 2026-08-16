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
        Schema::table('project_proposed_people', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('initials');
            $table->foreignId('club_id')->nullable()->constrained()->nullOnDelete()->after('logo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_proposed_people', function (Blueprint $table) {
            $table->dropConstrainedForeignId('club_id');
            $table->dropColumn('logo_path');
        });
    }
};
