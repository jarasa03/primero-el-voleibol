<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_collaborator_submissions', function (Blueprint $table): void {
            $table->string('coach_level', 120)->nullable()->after('referee_contact_phone');
            $table->string('coach_main_club', 120)->nullable()->after('coach_level');
            $table->boolean('coach_show_club_on_profile')->default(false)->after('coach_main_club');
            $table->boolean('coach_license_confirmation')->default(false)->after('coach_show_club_on_profile');
        });
    }

    public function down(): void
    {
        Schema::table('project_collaborator_submissions', function (Blueprint $table): void {
            $table->dropColumn([
                'coach_level',
                'coach_main_club',
                'coach_show_club_on_profile',
                'coach_license_confirmation',
            ]);
        });
    }
};
