<?php

namespace App\Enums;

enum ProjectSupporterType: string
{
    case Club = 'club';
    case Referee = 'referee';
    case Coach = 'coach';
    case Player = 'player';

    public function label(): string
    {
        return match ($this) {
            self::Club => 'Club',
            self::Referee => 'Árbitro',
            self::Coach => 'Entrenador',
            self::Player => 'Jugador',
        };
    }

    public function pluralLabel(): string
    {
        return match ($this) {
            self::Club => 'Clubes',
            self::Referee => 'Árbitros',
            self::Coach => 'Entrenadores',
            self::Player => 'Jugadores',
        };
    }

    public function sectionLabel(): string
    {
        return match ($this) {
            self::Club => 'Clubes colaboradores',
            self::Referee => 'Árbitros colaboradores',
            self::Coach => 'Entrenadores colaboradores',
            self::Player => 'Jugadores colaboradores',
        };
    }
}


