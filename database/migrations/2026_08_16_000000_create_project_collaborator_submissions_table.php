<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_collaborator_submissions', function (Blueprint $table): void {
            $table->id();
            $table->string('collaborator_type', 40);
            $table->string('full_name', 120);
            $table->string('club_locality', 120)->nullable();
            $table->string('club_contact_name', 120)->nullable();
            $table->string('club_contact_email', 255)->nullable();
            $table->string('club_contact_phone', 30)->nullable();
            $table->string('referee_level', 120)->nullable();
            $table->string('referee_contact_email', 255)->nullable();
            $table->string('referee_contact_phone', 30)->nullable();
            $table->string('photo_path');
            $table->boolean('federated_team_confirmation')->default(false);
            $table->boolean('referee_license_confirmation')->default(false);
            $table->string('status', 30)->default('pending');
            $table->string('source', 80)->nullable();
            $table->timestamp('consented_at')->nullable();
            $table->timestamps();

            $table->index(['collaborator_type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_collaborator_submissions');
    }
};
