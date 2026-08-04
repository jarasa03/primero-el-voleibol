<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->string('leader_name');
            $table->string('leader_title');
            $table->longText('leader_description');
            $table->timestamps();
        });

        DB::table('projects')->insert([
            'leader_name' => 'Francisco Sabroso',
            'leader_title' => 'Árbitro internacional, exárbitro de Superliga 1 y entrenador FIVB 2',
            'leader_description' => 'Francisco Sabroso es una persona con mucha experiencia en el voleibol. Ha sido árbitro internacional, ha pitado un total de 638 partidos de Superliga 1 y es entrenador FIVB 2. Además, ha estado designando durante muchos años a árbitros madrileños de toda la comunidad, lo que le da un conocimiento directo del cuerpo arbitral y de los problemas de cada club, porque habla con ellos todos los fines de semana y conoce desde dentro los retos de organización.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
