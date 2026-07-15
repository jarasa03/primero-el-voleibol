<?php

use App\Models\ProgramProposal;
use App\Models\ProgramSection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders program sections and proposals from the database', function (): void {
    $section = ProgramSection::factory()->create([
        'name' => 'Bloque de prueba',
        'sort' => 1,
    ]);

    ProgramProposal::factory()->create([
        'program_section_id' => $section->id,
        'title' => 'Propuesta de prueba',
        'description' => 'Descripcion de prueba para validar el render del programa.',
        'sort' => 1,
    ]);

    $response = $this->get(route('programa'));

    $response->assertOk();
    $response->assertSee('Bloque de prueba');
    $response->assertSee('Propuesta de prueba');
    $response->assertSee('Descripcion de prueba para validar el render del programa.');
});

it('renders rich text proposal descriptions safely', function (): void {
    $section = ProgramSection::factory()->create([
        'name' => 'Bloque rico',
        'sort' => 1,
    ]);

    ProgramProposal::factory()->create([
        'program_section_id' => $section->id,
        'title' => 'Propuesta rica',
        'description' => '<p>Texto con <strong>negrita</strong> y <em>énfasis</em>.</p>',
        'sort' => 1,
    ]);

    $response = $this->get(route('programa'));

    $response->assertOk();
    $response->assertSee('Texto con');
    $response->assertSee('<strong>negrita</strong>', false);
    $response->assertSee('<em>énfasis</em>', false);
});

it('numbers proposals sequentially across all blocks', function (): void {
    $firstSection = ProgramSection::factory()->create([
        'name' => 'Bloque uno',
        'sort' => 1,
    ]);

    $secondSection = ProgramSection::factory()->create([
        'name' => 'Bloque dos',
        'sort' => 2,
    ]);

    ProgramProposal::factory()->create([
        'program_section_id' => $firstSection->id,
        'title' => 'Propuesta uno',
        'description' => 'Descripcion uno.',
        'sort' => 1,
    ]);

    ProgramProposal::factory()->create([
        'program_section_id' => $firstSection->id,
        'title' => 'Propuesta dos',
        'description' => 'Descripcion dos.',
        'sort' => 2,
    ]);

    ProgramProposal::factory()->create([
        'program_section_id' => $secondSection->id,
        'title' => 'Propuesta tres',
        'description' => 'Descripcion tres.',
        'sort' => 1,
    ]);

    $response = $this->get(route('programa'));

    $response->assertOk();
    $response->assertSee('Propuesta uno');
    $response->assertSee('Propuesta dos');
    $response->assertSee('Propuesta tres');
    expect(preg_match('/data-program-number="01".*data-program-number="02".*data-program-number="03"/s', $response->getContent()))->toBe(1);
});
