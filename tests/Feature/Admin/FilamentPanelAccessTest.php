<?php

use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

uses(RefreshDatabase::class);

it('allows the configured admin email to access the admin panel', function (): void {
    Config::set('services.filament.admin_email', 'admin@example.com');

    $user = User::factory()->create([
        'email' => 'Admin@Example.com',
    ]);

    expect($user->canAccessPanel(Panel::make()->id('admin')))->toBeTrue();
});

it('denies other emails access to the admin panel', function (): void {
    Config::set('services.filament.admin_email', 'admin@example.com');

    $user = User::factory()->create([
        'email' => 'other@example.com',
    ]);

    expect($user->canAccessPanel(Panel::make()->id('admin')))->toBeFalse();
});

it('denies access when the configured admin email is empty', function (): void {
    Config::set('services.filament.admin_email', '');

    $user = User::factory()->create([
        'email' => 'admin@example.com',
    ]);

    expect($user->canAccessPanel(Panel::make()->id('admin')))->toBeFalse();
});
