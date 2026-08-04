<?php

namespace App\Enums;

enum ProjectProposedPersonType: string
{
    case Referee = 'referee';
    case Coach = 'coach';
    case Player = 'player';

    public function label(): string
    {
        return match ($this) {
            self::Referee => 'Árbitro',
            self::Coach => 'Entrenador',
            self::Player => 'Jugador',
        };
    }

    public function pluralLabel(): string
    {
        return match ($this) {
            self::Referee => 'Árbitros',
            self::Coach => 'Entrenadores',
            self::Player => 'Jugadores',
        };
    }

    public function sectionLabel(): string
    {
        return match ($this) {
            self::Referee => 'Árbitros propuestos',
            self::Coach => 'Entrenadores propuestos',
            self::Player => 'Jugadores propuestos',
        };
    }
}
