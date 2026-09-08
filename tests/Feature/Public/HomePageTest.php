<?php

use App\Models\BlogPost;
use App\Models\ProgramProposal;
use App\Models\ProgramSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('renders the home page', function (): void {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Primero el voleibol');
    $response->assertSeeHtml('<body class="antialiased page-home" data-nav-scrolled="true">');
});

it('renders real programme proposals and published blog posts', function (): void {
    $clubs = ProgramSection::factory()->create(['name' => 'Clubes', 'sort' => 1]);
    $federation = ProgramSection::factory()->create(['name' => 'Federación', 'sort' => 2]);
    $referees = ProgramSection::factory()->create(['name' => 'Árbitros', 'sort' => 3]);

    ProgramProposal::factory()->create([
        'program_section_id' => $clubs->id,
        'title' => 'Transparencia en las sanciones y reinversión en el juego limpio',
        'description' => '<p>Las sanciones deben tener consecuencias para todos.</p><p>La competición.</p><p>Contar con reglas claras mejora el voleibol.</p>',
        'sort' => 1,
    ]);
    ProgramProposal::factory()->create([
        'program_section_id' => $federation->id,
        'title' => 'Permitir la incorporación de patrocinadores en la equipación oficial de la Federación',
        'description' => 'La información debe estar ordenada y actualizada.',
        'sort' => 1,
    ]);
    ProgramProposal::factory()->create([
        'program_section_id' => $referees->id,
        'title' => 'Programa de Mentoría Arbitral',
        'description' => 'La formación debe continuar durante toda la temporada.',
        'sort' => 1,
    ]);

    BlogPost::factory()->create(['title' => 'Una entrada publicada']);
    BlogPost::factory()->draft()->create(['title' => 'Una entrada privada']);

    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertSee('Transparencia en las sanciones y reinversión en el juego limpio');
    $response->assertSee('Permitir la incorporación de patrocinadores en la equipación oficial de la Federación');
    $response->assertSee('Programa de Mentoría Arbitral');
    $response->assertSee('Las normas deben aplicarse por igual para todos, las sanciones deben cumplirse');
    $response->assertDontSee('competición.Contar');
    $response->assertDontSee('...');
    $response->assertSee('Una entrada publicada');
    $response->assertSeeText('Nuevo!');
    $response->assertDontSee('Una entrada privada');
});

it('shows at most the four latest published posts on the home page', function (): void {
    foreach (range(1, 5) as $postNumber) {
        BlogPost::factory()->create([
            'title' => "Publicación {$postNumber}",
            'published_at' => Carbon::now()->subDays(5 - $postNumber),
        ]);
    }

    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertSee('Publicación 2');
    $response->assertSee('Publicación 3');
    $response->assertSee('Publicación 4');
    $response->assertSee('Publicación 5');
    $response->assertDontSee('Publicación 1');
});
