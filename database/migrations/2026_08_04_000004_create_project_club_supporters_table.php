<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('project_club_supporters')) {
            return;
        }

        Schema::create('project_club_supporters', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('image_path');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->index(['project_id', 'sort']);
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('project_club_supporters')) {
            Schema::drop('project_club_supporters');
        }
    }
};
