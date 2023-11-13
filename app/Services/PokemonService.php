<?php

namespace App\Services;

use App\Models\Pokemon;
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
        // $result接收一個bool判斷
        $result = SkillLogic($skill,$skillTags);
        if($result == true){
            // 如果是true就把資料原路丟回
            return true;
        }   // 如果是false也把資料原路丟回
        else{return false;}
    }
    public function Evolution($data,$id)
    {
        if($id == false){
            $targetLevel = $data['level'];
            $raceId = $data['race_id'];
        }
        else{
            $pokemon = Pokemon::find($id);
            $targetLevel = $data['level'];
            $raceId = $pokemon['race_id'];
        }
        //不確定邏輯是否正確，程式碼保留
        //$pokemon = Pokemon::find($id);
        //$targetLevel = $data['level'];
        //$raceId = $pokemon['race_id'];
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
        return $data;
    }
}

?>