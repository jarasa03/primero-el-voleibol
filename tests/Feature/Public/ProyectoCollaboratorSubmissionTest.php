<?php

use App\Mail\ProjectCollaboratorSubmissionReceived;
use App\Models\ProjectCollaboratorSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('renders collaborator submission triggers on the project page', function (): void {
    $response = $this->get(route('proyecto'));

    $response->assertOk();
    $response->assertSee('Solicitar colaboración');
    $response->assertSee('Apoyos del proyecto');
    $response->assertSee('Dónde quieres salir');
    $response->assertSee('Nombre del club');
    $response->assertSee('Nivel de voleibol');
    $response->assertSee('Nivel de vóley playa');
    $response->assertSee('Nivel de voleibol');
    $response->assertSee('Nivel de vóley playa');
    $response->assertSee('División en la que juegas');
    $response->assertSee('Equipo en el que juegas');
    $response->assertSee('Correo electrónico de contacto');
    $response->assertSee('Número de teléfono de contacto');
    $response->assertSee('Nombre de la persona de contacto');
    $response->assertSee('Correo electrónico de contacto');
    $response->assertSee('Número de teléfono de contacto');
    $response->assertSee('Foto');
    $response->assertSee('Asumo que el club que estoy enviando tiene algún equipo federado');
    $response->assertSee('Asumo que al enviar esto soy un árbitro federado con licencia en vigor');
    $response->assertSee('Asumo que al enviar esto soy un entrenador federado con licencia en vigor');
    $response->assertSee('Asumo que al enviar esto soy un jugador federado con licencia en vigor');
    $response->assertSee('consiento el tratamiento de mis datos');
    $response->assertSee('Autorizo expresamente que');
    $response->assertSee('Confirmo que tengo 18 años o más y consiento');
    $response->assertSee('Responsable: Francisco Javier Arruabarrena Sabroso. Tus datos se utilizarán para gestionar esta solicitud.');
    $response->assertSeeHtml('Más información en nuestra <a class="font-semibold text-accent-700 underline" href="'.route('legal.politica-de-privacidad').'">Política de Privacidad</a>.');
    expect(substr_count($response->getContent(), 'name="consent"'))->toBe(1);
    expect(substr_count($response->getContent(), 'name="publication_consent"'))->toBe(1);
    $response->assertSeeHtml('class="flex cursor-pointer items-start gap-3 rounded-[1.5rem]');
    $response->assertSeeHtml('class="mt-1 size-4 cursor-pointer rounded border-slate-300 text-amber-500 focus:ring-amber-500"');
    expect(substr_count($response->getContent(), 'class="align-top text-rose-500">*</span>'))->toBeGreaterThanOrEqual(2);
    $response->assertDontSeeHtml('name="consent" value="1" checked');
    $response->assertDontSeeHtml('name="publication_consent" value="1" checked');
});

it('stores a collaborator submission with a private club upload', function (): void {
    Mail::fake();

    Storage::fake('local');
    Storage::fake('public');

    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'club',
        'full_name' => 'Club María López',
        'club_locality' => 'Madrid',
        'club_contact_name' => 'María López',
        'club_contact_email' => 'maria@example.com',
        'club_contact_phone' => '600000000',
        'photo' => UploadedFile::fake()->image('foto-colaborador.jpg'),
        'federated_team_confirmation' => '1',
        'consent' => '1',
        'publication_consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));

    $submission = ProjectCollaboratorSubmission::query()->first();

    expect($submission)->not->toBeNull();

    $this->assertDatabaseHas('project_collaborator_submissions', [
        'collaborator_type' => 'club',
        'full_name' => 'Club María López',
        'club_locality' => 'Madrid',
        'club_contact_name' => 'María López',
        'club_contact_email' => 'maria@example.com',
        'club_contact_phone' => '600000000',
        'federated_team_confirmation' => true,
        'status' => 'pending',
        'source' => 'proyecto-page',
    ]);

    expect($submission?->consented_at)->not->toBeNull();
    expect($submission?->adult_confirmed_at)->not->toBeNull();
    expect($submission?->publication_consented_at)->not->toBeNull();

    Storage::disk('local')->assertExists($submission->photo_path);
    Storage::disk('public')->assertMissing($submission->photo_path);

    Mail::assertSent(ProjectCollaboratorSubmissionReceived::class, function (ProjectCollaboratorSubmissionReceived $mail): bool {
        $envelope = $mail->envelope();
        $cc = collect($envelope->cc)->pluck('address')->sort()->values()->all();
        $expectedCc = collect(config('public_forms.cc_emails'))->sort()->values()->all();

        return $envelope->isFrom(config('mail.from.address'))
            && $envelope->hasTo(config('public_forms.contact_email'))
            && $cc === $expectedCc
            && $envelope->hasReplyTo('maria@example.com');
    });
});

it('stores a collaborator submission with a private referee upload', function (): void {
    Storage::fake('local');
    Storage::fake('public');

    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'referee',
        'full_name' => 'Ana Pérez',
        'referee_volleyball_level' => 'superliga_1',
        'referee_beach_level' => 'vp_level_2',
        'referee_contact_email' => 'ana@example.com',
        'referee_contact_phone' => '611111111',
        'photo' => UploadedFile::fake()->image('foto-arbitro.jpg'),
        'referee_license_confirmation' => '1',
        'consent' => '1',
        'publication_consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));

    $submission = ProjectCollaboratorSubmission::query()->first();

    expect($submission)->not->toBeNull();

    $this->assertDatabaseHas('project_collaborator_submissions', [
        'collaborator_type' => 'referee',
        'full_name' => 'Ana Pérez',
        'referee_volleyball_level' => 'superliga_1',
        'referee_beach_level' => 'vp_level_2',
        'referee_contact_email' => 'ana@example.com',
        'referee_contact_phone' => '611111111',
        'referee_license_confirmation' => true,
        'status' => 'pending',
        'source' => 'proyecto-page',
    ]);

    expect($submission?->consented_at)->not->toBeNull();

    Storage::disk('local')->assertExists($submission->photo_path);
    Storage::disk('public')->assertMissing($submission->photo_path);
});

it('includes all referee details and the uploaded photo in the email', function (): void {
    Storage::fake('local');

    $photoPath = 'project-collaborator-submissions/foto-arbitro.jpg';
    Storage::disk('local')->put($photoPath, 'fake-image-data');

    $submission = ProjectCollaboratorSubmission::factory()->create([
        'collaborator_type' => 'referee',
        'full_name' => 'Ana Pérez',
        'referee_volleyball_level' => 'superliga_1',
        'referee_beach_level' => 'vp_level_2',
        'referee_contact_email' => 'ana@example.com',
        'referee_contact_phone' => '611111111',
        'referee_license_confirmation' => true,
        'photo_path' => $photoPath,
    ]);

    $mail = new ProjectCollaboratorSubmissionReceived($submission);

    $mail->assertSeeInHtml('Nueva colaboración recibida');
    $mail->assertSeeInHtml('Ana Pérez');
    $mail->assertSeeInHtml('Superliga 1');
    $mail->assertSeeInHtml('VP Nivel 2');
    $mail->assertDontSeeInHtml('superliga_1');
    $mail->assertDontSeeInHtml('vp_level_2');
    $mail->assertSeeInHtml('ana@example.com');
    $mail->assertSeeInHtml('611111111');
    $mail->assertSeeInHtml('Fotografía:');
    $mail->assertSeeInHtml('data:image/jpeg;base64,');
    $mail->assertDontSeeInHtml('se ha guardado como pendiente');
    $mail->assertDontSeeInHtml('Tiene equipo federado');
    $mail->assertDontSeeInHtml('Licencia federativa en vigor');
});

it('marks a non-public coach submission as anonymous in the email', function (): void {
    Storage::fake('local');

    $photoPath = 'project-collaborator-submissions/foto-entrenador.jpg';
    Storage::disk('local')->put($photoPath, 'fake-image-data');

    $submission = ProjectCollaboratorSubmission::factory()->create([
        'collaborator_type' => 'coach',
        'coach_show_club_on_profile' => false,
        'photo_path' => $photoPath,
    ]);

    $mail = new ProjectCollaboratorSubmissionReceived($submission);

    $mail->assertSeeInHtml('Identidad pública:');
    $mail->assertSeeInHtml('Anónima');
    $mail->assertDontSeeInHtml('Mostrar el club en la ficha');
});

it('requires at least one referee level for referee submissions', function (): void {
    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'referee',
        'full_name' => 'Ana Pérez',
        'referee_volleyball_level' => '',
        'referee_beach_level' => '',
        'referee_contact_email' => 'ana@example.com',
        'referee_contact_phone' => '611111111',
        'photo' => UploadedFile::fake()->image('foto-arbitro.jpg'),
        'referee_license_confirmation' => '1',
        'consent' => '1',
        'publication_consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));
    $response->assertSessionHasErrors([
        'referee_volleyball_level',
        'referee_beach_level',
    ]);

    $this->assertDatabaseCount('project_collaborator_submissions', 0);
});

it('stores a collaborator submission with a private coach upload', function (): void {
    Storage::fake('local');
    Storage::fake('public');

    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'coach',
        'full_name' => 'Carlos Gómez',
        'coach_volleyball_level' => 'fivb_2',
        'coach_beach_level' => 'vp_level_1',
        'coach_main_club' => 'Club Principal',
        'coach_contact_email' => 'carlos@example.com',
        'coach_contact_phone' => '633333333',
        'coach_show_club_on_profile' => 'yes',
        'photo' => UploadedFile::fake()->image('foto-entrenador.jpg'),
        'coach_license_confirmation' => '1',
        'consent' => '1',
        'publication_consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));

    $submission = ProjectCollaboratorSubmission::query()->first();

    expect($submission)->not->toBeNull();

    $this->assertDatabaseHas('project_collaborator_submissions', [
        'collaborator_type' => 'coach',
        'full_name' => 'Carlos Gómez',
        'coach_volleyball_level' => 'fivb_2',
        'coach_beach_level' => 'vp_level_1',
        'coach_main_club' => 'Club Principal',
        'coach_contact_email' => 'carlos@example.com',
        'coach_contact_phone' => '633333333',
        'coach_show_club_on_profile' => true,
        'coach_license_confirmation' => true,
        'status' => 'pending',
        'source' => 'proyecto-page',
    ]);

    expect($submission?->consented_at)->not->toBeNull();

    Storage::disk('local')->assertExists($submission->photo_path);
    Storage::disk('public')->assertMissing($submission->photo_path);
});

it('requires at least one coach level for coach submissions', function (): void {
    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'coach',
        'full_name' => 'Carlos Gómez',
        'coach_volleyball_level' => '',
        'coach_beach_level' => '',
        'coach_main_club' => 'Club Principal',
        'coach_contact_email' => 'carlos@example.com',
        'coach_contact_phone' => '633333333',
        'coach_show_club_on_profile' => 'yes',
        'photo' => UploadedFile::fake()->image('foto-entrenador.jpg'),
        'coach_license_confirmation' => '1',
        'consent' => '1',
        'publication_consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));
    $response->assertSessionHasErrors([
        'coach_volleyball_level',
        'coach_beach_level',
    ]);

    $this->assertDatabaseCount('project_collaborator_submissions', 0);
});

it('requires coach contact details for coach submissions', function (): void {
    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'coach',
        'full_name' => 'Carlos Gómez',
        'coach_volleyball_level' => 'fivb_2',
        'coach_beach_level' => 'vp_level_1',
        'coach_main_club' => 'Club Principal',
        'coach_contact_email' => '',
        'coach_contact_phone' => '',
        'coach_show_club_on_profile' => 'yes',
        'photo' => UploadedFile::fake()->image('foto-entrenador.jpg'),
        'coach_license_confirmation' => '1',
        'consent' => '1',
        'publication_consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));
    $response->assertSessionHasErrors([
        'coach_contact_email',
        'coach_contact_phone',
    ]);
    expect(session('errors')->get('coach_contact_email'))
        ->toContain('El correo de contacto del entrenador es obligatorio para las colaboraciones de tipo entrenador.');

    $this->assertDatabaseCount('project_collaborator_submissions', 0);
});

it('stores a collaborator submission with a private player upload', function (): void {
    Storage::fake('local');
    Storage::fake('public');

    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'player',
        'full_name' => 'Lucía Martín',
        'player_division' => 'Primera',
        'player_team' => 'Club Atlético',
        'player_show_team_on_profile' => 'yes',
        'player_contact_email' => 'lucia@example.com',
        'player_contact_phone' => '622222222',
        'photo' => UploadedFile::fake()->image('foto-jugador.jpg'),
        'player_license_confirmation' => '1',
        'consent' => '1',
        'publication_consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));

    $submission = ProjectCollaboratorSubmission::query()->first();

    expect($submission)->not->toBeNull();

    $this->assertDatabaseHas('project_collaborator_submissions', [
        'collaborator_type' => 'player',
        'full_name' => 'Lucía Martín',
        'player_division' => 'Primera',
        'player_team' => 'Club Atlético',
        'player_show_team_on_profile' => true,
        'player_contact_email' => 'lucia@example.com',
        'player_contact_phone' => '622222222',
        'player_license_confirmation' => true,
        'status' => 'pending',
        'source' => 'proyecto-page',
    ]);

    expect($submission?->consented_at)->not->toBeNull();

    Storage::disk('local')->assertExists($submission->photo_path);
    Storage::disk('public')->assertMissing($submission->photo_path);
});

it('requires player details for player submissions', function (): void {
    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'player',
        'full_name' => 'Lucía Martín',
        'player_division' => '',
        'player_team' => '',
        'player_show_team_on_profile' => '',
        'player_contact_email' => '',
        'player_contact_phone' => '',
        'photo' => UploadedFile::fake()->image('foto-jugador.jpg'),
        'player_license_confirmation' => '',
        'consent' => '1',
        'publication_consent' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));
    $response->assertSessionHasErrors([
        'player_division',
        'player_team',
        'player_show_team_on_profile',
        'player_contact_email',
        'player_contact_phone',
        'player_license_confirmation',
    ]);

    $this->assertDatabaseCount('project_collaborator_submissions', 0);
});

it('requires treatment and publication consent', function (): void {
    Storage::fake('local');

    $response = $this->from(route('proyecto'))->post(route('proyecto.colaboradores.store'), [
        'collaborator_type' => 'club',
        'full_name' => 'Club de prueba',
        'club_locality' => 'Madrid',
        'club_contact_name' => 'Persona de prueba',
        'club_contact_email' => 'club@example.com',
        'club_contact_phone' => '600000000',
        'photo' => UploadedFile::fake()->image('logo.jpg'),
        'federated_team_confirmation' => '1',
        'website' => '',
    ]);

    $response->assertRedirect(route('proyecto'));
    $response->assertSessionHasErrors(['consent', 'publication_consent']);
    $this->assertDatabaseCount('project_collaborator_submissions', 0);
});
