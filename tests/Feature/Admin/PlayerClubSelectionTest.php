<?php

use App\Filament\Resources\Players\Pages\EditPlayer;
use App\Models\Club;
use App\Models\Player;
use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('allows selecting a club for a player', function (): void {
    Config::set('services.filament.admin_email', 'admin@example.com');

    $user = User::factory()->create([
        'email' => 'admin@example.com',
    ]);

    $club = Club::factory()->create([
        'name' => 'Club para jugador',
    ]);

    $player = Player::factory()->create([
        'name' => 'Jugador de prueba',
    ]);

    $this->actingAs($user);
    $this->withoutMiddleware(Authenticate::class);

    Livewire::test(EditPlayer::class, [
        'record' => $player->getKey(),
    ])
        ->fillForm([
            'club_id' => $club->getKey(),
        ])
        ->call('save')
        ->assertHasNoErrors();

    expect($player->refresh()->club_id)->toBe($club->getKey());
});
