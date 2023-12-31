<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Race;
use App\Models\Skill;
use App\Models\SkillTag;

class ImportPokemonData extends Command
{
    protected $signature = 'import:pokemon-races';
    protected $description = 'Import Pokemon data including Races and Skill Tags';

    public function handle()
{
    $startId = 1;
    $endId = 1000;

    for ($pokemonId = $startId; $pokemonId <= $endId; $pokemonId++) {
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/$pokemonId");
        $pokemonInfo = $response->json();

        $pokemonName = $pokemonInfo['name'];

        $existingRace = Race::where('name', $pokemonName)->first();

            $race = Race::create(['name' => $pokemonName]);

            $moves = $pokemonInfo['moves'];

            foreach ($moves as $moveData) {
                $moveName = $moveData['move']['name'];

                $existingSkill = Skill::where('name', $moveName)->first();

                if (!$existingSkill) {
                    $skill = Skill::create(['name' => $moveName]);

                    SkillTag::create([
                        'race_id' => $race->id,
                        'skill_id' => $skill->id,
                    ]);
                } else {
                    SkillTag::create([
                        'race_id' => $race->id,
                        'skill_id' => $existingSkill->id,
                    ]);
                }
        }
    }

    $this->info('Pokemon data imported successfully.');
}
}