<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('referees')) {
            return;
        }

        Schema::create('referees', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('logo_path');
            $table->boolean('show_as_collaborator')->default(false);
            $table->boolean('show_as_proposed_for_assembly')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->index(
                ['show_as_collaborator', 'show_as_proposed_for_assembly', 'sort'],
                'referees_visibility_sort_index',
            );
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('referees')) {
            Schema::drop('referees');
        }
    }
};
