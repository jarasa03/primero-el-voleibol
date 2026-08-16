<?php

use App\Filament\Resources\Coaches\Pages\EditCoach;
use App\Models\Club;
use App\Models\Coach;
use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('allows selecting a club for a coach', function (): void {
    Config::set('services.filament.admin_email', 'admin@example.com');

    $user = User::factory()->create([
        'email' => 'admin@example.com',
    ]);

    $club = Club::factory()->create([
        'name' => 'Club para entrenador',
    ]);

    $coach = Coach::factory()->create([
        'name' => 'Entrenador de prueba',
    ]);

    $this->actingAs($user);
    $this->withoutMiddleware(Authenticate::class);

    Livewire::test(EditCoach::class, [
        'record' => $coach->getKey(),
    ])
        ->fillForm([
            'club_id' => $club->getKey(),
        ])
        ->call('save')
        ->assertHasNoErrors();

    expect($coach->refresh()->club_id)->toBe($club->getKey());
});
