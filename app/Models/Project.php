<?php

namespace App\Models;

use App\Enums\ProjectProposedPersonType;
use App\Enums\ProjectSupporterType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $attributes = [
        'show_leader_section' => true,
        'show_proposed_clubs_section' => true,
        'show_proposed_referees_section' => true,
        'show_proposed_coaches_section' => true,
        'show_proposed_players_section' => true,
        'proposed_clubs_minimum_count' => 3,
        'proposed_referees_minimum_count' => 3,
        'proposed_coaches_minimum_count' => 3,
        'proposed_players_minimum_count' => 3,
    ];

    protected $fillable = [
        'leader_name',
        'leader_title',
        'leader_description',
        'show_leader_section',
        'show_proposed_clubs_section',
        'show_proposed_referees_section',
        'show_proposed_coaches_section',
        'show_proposed_players_section',
        'proposed_clubs_minimum_count',
        'proposed_referees_minimum_count',
        'proposed_coaches_minimum_count',
        'proposed_players_minimum_count',
    ];

    protected function casts(): array
    {
        return [
            'show_leader_section' => 'boolean',
            'show_proposed_clubs_section' => 'boolean',
            'show_proposed_referees_section' => 'boolean',
            'show_proposed_coaches_section' => 'boolean',
            'show_proposed_players_section' => 'boolean',
            'proposed_clubs_minimum_count' => 'integer',
            'proposed_referees_minimum_count' => 'integer',
            'proposed_coaches_minimum_count' => 'integer',
            'proposed_players_minimum_count' => 'integer',
        ];
    }

    public static function ensureSingleton(): self
    {
        $project = static::query()->latest('id')->first();

        if ($project instanceof self) {
            return $project;
        }

        return static::create([
            'leader_name' => 'Francisco Sabroso',
            'leader_title' => 'árbitro internacional, exárbitro de Superliga 1 y entrenador FIVB 2',
            'leader_description' => 'Francisco Sabroso es una persona con mucha experiencia en el voleibol. Ha sido árbitro internacional, ha pitado un total de 638 partidos de Superliga 1 y es entrenador FIVB 2. Además, ha estado designando durante muchos años a árbitros madrileños de toda la comunidad, lo que le da un conocimiento directo del cuerpo arbitral y de los problemas de cada club, porque habla con ellos todos los fines de semana y conoce desde dentro los retos de organización.',
            'show_leader_section' => true,
            'show_proposed_clubs_section' => true,
            'show_proposed_referees_section' => true,
            'show_proposed_coaches_section' => true,
            'show_proposed_players_section' => true,
            'proposed_clubs_minimum_count' => 3,
            'proposed_referees_minimum_count' => 3,
            'proposed_coaches_minimum_count' => 3,
            'proposed_players_minimum_count' => 3,
        ]);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort')->orderBy('id');
    }

    public function clubSupporters(): HasMany
    {
        if (! ProjectClubSupporter::hasSupporterTypeColumn()) {
            return $this->supporters();
        }

        return $this->supportersOfType(ProjectSupporterType::Club);
    }

    public function refereeSupporters(): HasMany
    {
        if (! ProjectClubSupporter::hasSupporterTypeColumn()) {
            return $this->supporters()->whereRaw('1 = 0');
        }

        return $this->supportersOfType(ProjectSupporterType::Referee);
    }

    public function coachSupporters(): HasMany
    {
        if (! ProjectClubSupporter::hasSupporterTypeColumn()) {
            return $this->supporters()->whereRaw('1 = 0');
        }

        return $this->supportersOfType(ProjectSupporterType::Coach);
    }

    public function playerSupporters(): HasMany
    {
        if (! ProjectClubSupporter::hasSupporterTypeColumn()) {
            return $this->supporters()->whereRaw('1 = 0');
        }

        return $this->supportersOfType(ProjectSupporterType::Player);
    }

    public function supporters(): HasMany
    {
        return $this->hasMany(ProjectClubSupporter::class)->orderBy('sort')->orderBy('id');
    }

    public function supportersOfType(ProjectSupporterType $type): HasMany
    {
        return $this->supporters()
            ->where('supporter_type', $type->value)
            ->orderBy('sort')
            ->orderBy('id');
    }

    public function proposedPeople(): HasMany
    {
        return $this->hasMany(ProjectProposedPerson::class)->orderBy('sort')->orderBy('id');
    }

    public function proposedReferees(): HasMany
    {
        return $this->proposedPeopleOfType(ProjectProposedPersonType::Referee);
    }

    public function proposedClubs(): HasMany
    {
        return $this->proposedPeopleOfType(ProjectProposedPersonType::Club);
    }

    public function proposedCoaches(): HasMany
    {
        return $this->proposedPeopleOfType(ProjectProposedPersonType::Coach);
    }

    public function proposedPlayers(): HasMany
    {
        return $this->proposedPeopleOfType(ProjectProposedPersonType::Player);
    }

    public function proposedPeopleOfType(ProjectProposedPersonType $type): HasMany
    {
        return $this->proposedPeople()
            ->where('proposed_type', $type->value)
            ->orderBy('sort')
            ->orderBy('id');
    }
}
