<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participation_ideas', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 120)->nullable();
            $table->string('email', 255)->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('club_or_role', 140)->nullable();
            $table->string('topic', 50);
            $table->text('idea');
            $table->string('source', 100)->default('participa-page');
            $table->timestamp('consented_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participation_ideas');
    }
};
