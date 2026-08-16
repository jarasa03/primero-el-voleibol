<?php

use App\Filament\Resources\Players\Pages\EditPlayer;
use App\Models\Player;
use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('allows removing a player logo without requiring a replacement', function (): void {
    Storage::fake('public');
    Config::set('services.filament.admin_email', 'admin@example.com');

    $user = User::factory()->create([
        'email' => 'admin@example.com',
    ]);

    $logoPath = 'players/legacy-player.png';
    Storage::disk('public')->put($logoPath, 'image');

    $player = Player::factory()->create([
        'name' => 'Jugador de prueba',
        'logo_path' => $logoPath,
    ]);

    $this->actingAs($user);
    $this->withoutMiddleware(Authenticate::class);

    Livewire::test(EditPlayer::class, [
        'record' => $player->getKey(),
    ])
        ->fillForm([
            'logo_path' => null,
        ])
        ->call('save')
        ->assertHasNoErrors();

    expect(Storage::disk('public')->exists($logoPath))->toBeFalse();
    expect($player->refresh()->logo_path)->toBe('');
});
