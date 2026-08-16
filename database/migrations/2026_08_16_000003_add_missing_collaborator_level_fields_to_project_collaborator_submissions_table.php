<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_collaborator_submissions', function (Blueprint $table): void {
            if (! Schema::hasColumn('project_collaborator_submissions', 'club_locality')) {
                $table->string('club_locality', 120)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'club_contact_name')) {
                $table->string('club_contact_name', 120)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'club_contact_email')) {
                $table->string('club_contact_email', 255)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'club_contact_phone')) {
                $table->string('club_contact_phone', 30)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'referee_volleyball_level')) {
                $table->string('referee_volleyball_level', 120)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'referee_beach_level')) {
                $table->string('referee_beach_level', 120)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'referee_contact_email')) {
                $table->string('referee_contact_email', 255)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'referee_contact_phone')) {
                $table->string('referee_contact_phone', 30)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'federated_team_confirmation')) {
                $table->boolean('federated_team_confirmation')->default(false);
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'referee_license_confirmation')) {
                $table->boolean('referee_license_confirmation')->default(false);
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'coach_volleyball_level')) {
                $table->string('coach_volleyball_level', 120)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'coach_beach_level')) {
                $table->string('coach_beach_level', 120)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'coach_contact_email')) {
                $table->string('coach_contact_email', 255)->nullable();
            }

            if (! Schema::hasColumn('project_collaborator_submissions', 'coach_contact_phone')) {
                $table->string('coach_contact_phone', 30)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('project_collaborator_submissions', function (Blueprint $table): void {
            $table->dropColumn([
                'club_locality',
                'club_contact_name',
                'club_contact_email',
                'club_contact_phone',
                'referee_volleyball_level',
                'referee_beach_level',
                'referee_contact_email',
                'referee_contact_phone',
                'federated_team_confirmation',
                'referee_license_confirmation',
                'coach_volleyball_level',
                'coach_beach_level',
                'coach_contact_email',
                'coach_contact_phone',
            ]);
        });
    }
};
