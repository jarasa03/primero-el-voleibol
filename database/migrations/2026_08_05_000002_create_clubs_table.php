<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('clubs')) {
            return;
        }

        Schema::create('clubs', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('logo_path');
            $table->boolean('show_as_collaborator')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->index(['show_as_collaborator', 'sort']);
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('clubs')) {
            Schema::drop('clubs');
        }
    }
};
