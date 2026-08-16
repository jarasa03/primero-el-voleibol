<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_collaborator_submissions', function (Blueprint $table): void {
            $table->string('player_division', 120)->nullable()->after('coach_license_confirmation');
            $table->string('player_team', 120)->nullable()->after('player_division');
            $table->boolean('player_show_team_on_profile')->default(false)->after('player_team');
            $table->string('player_contact_email', 255)->nullable()->after('player_show_team_on_profile');
            $table->string('player_contact_phone', 30)->nullable()->after('player_contact_email');
            $table->boolean('player_license_confirmation')->default(false)->after('player_contact_phone');
        });
    }

    public function down(): void
    {
        Schema::table('project_collaborator_submissions', function (Blueprint $table): void {
            $table->dropColumn([
                'player_division',
                'player_team',
                'player_show_team_on_profile',
                'player_contact_email',
                'player_contact_phone',
                'player_license_confirmation',
            ]);
        });
    }
};
