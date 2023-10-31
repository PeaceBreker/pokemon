<?php

namespace App\Services;

use App\Models\Race;
use App\Models\Skilltag;
use Illuminate\Support\Facades\Http;

class PokemonService
{
    public function LearnSkillLogic($evolution)
    {
        $race = $evolution['race_id'];
        $skillTags = Skilltag::where('race_id', $race)->pluck('skill_id')->all();
        $skill = $evolution['skill'];
        $skill = array_map('intval', $skill);

        foreach ($skill as $skills) {
            if (!in_array($skills, $skillTags)) {
                return response()->json(['message' => 'Pokémon cannot learn these skills'], 400);
            }
        }
    }
    public function Evolution($data)
    {
        $targetLevel = $data['level'];
        $raceId = $data['race_id'];
        $pokemonApiUrl = "https://pokeapi.co/api/v2/pokemon-species/{$raceId}";
        $response = Http::get($pokemonApiUrl);

        if ($response->successful()) {
            $pokemonSpeciesData = $response->json();
            $evolutionChainUrl = $pokemonSpeciesData['evolution_chain']['url'];

            // 发送 "evolution_chain" 的 API 请求
            $evolutionChainResponse = Http::get($evolutionChainUrl)->json();
        }
        if ($evolutionChainResponse == null) {
            return false;
        }
        $chain = $evolutionChainResponse['chain'];
        while (!empty($chain['evolves_to'])) {
            if ($targetLevel >= $chain['evolves_to']['0']['evolution_details']['0']['min_level']) {
                $name = $chain['evolves_to']['0']['species']['name'];
                $evolvedRace = Race::where('name', $name)->first();
                $data['race_id'] = $evolvedRace->id;
            }
            $chain = $chain['evolves_to'][0];
        }
    }
}

?>