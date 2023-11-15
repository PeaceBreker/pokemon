<?php

namespace App\Http\Controllers;

use App\Http\Requests\PokemonStoreRequest;
use App\Http\Requests\PokemonUpdateRequest;
use App\Http\Resources\PokemonResource;
use App\Models\Pokemon;
use App\Models\Race;
use App\Models\Skilltag;
use App\Services\PokemonService;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public $learnSkill;

    public function __construct(PokemonService $learnSkill)
    {
        $this->learnSkill = $learnSkill;
    }
    public function store(PokemonStoreRequest $request)
    {
        $data = $request->all();

        // 自定義表单验证 PokemonStoreRequest

        // 判断是否进化
        $evolution = $this->learnSkill->Evolution($data);
        // 判斷是否可以學習技能
        $result = $this->learnSkill->LearnSkillLogic($evolution);

        $result['skill'] = json_encode($result['skill']);

        $pokemon = Pokemon::create($result);

        return ['message' => 'Pokemon created successfully', 'pokemons' => $pokemon, 201];

    }

    public function index()
    {
        // 1,'1';
        //dd(1 == '1');// int vs string
        //php裏面 弱型別 // 他不會檢查到型別
        // === 嚴謹模式 //會檢查到型別
        //url id = 1   => query string  => string
        //Sql  id = 1 => int 
        //php 兩者相等 嚴謹模式 報錯 

        $pokemons = Pokemon::all();

        return PokemonResource::collection($pokemons);
    }

    public function show($id)
    {
        $pokemon = Pokemon::with('nature', 'race', 'ability')->find($id);
        if (!$pokemon) {
            return response()->json(['message' => 'Pokemon not found'], 404);
        }
        //dd($pokemon);
        //PokemonResource::make方法接收一個Object
        //PokemonResource::collection方法接收一個集合(many Object)
        //底層邏輯會執行json decode接著會執行資料整理，call完 To array function最後才會把值包成一包return回來
        return PokemonResource::make($pokemon);
    }

    public function update(PokemonUpdateRequest $request, $id)
    {
        $pokemon = Pokemon::find($id);
        $data = $request->all();
        if ($request->has('level')) {
            $targetLevel = $data;
            $raceId = $pokemon->race_id;
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
                    $raceId = $evolvedRace->id;
                }
                $chain = $chain['evolves_to'][0];
            }
            $pokemon->race_id = $raceId;
        }
        if ($request->has('skill')) {
            $race = $pokemon->race_id;
            $skillTags = SkillTag::where('race_id', $race)->pluck('skill_id')->all();
            $skill = $data['skill'];
            $skill = array_map('intval', $skill);

            foreach ($skill as $skills) {
                if (!in_array($skills, $skillTags)) {
                    return response()->json(['message' => 'Pokemon cannot learn these skills'], 400);
                }
            }
        }

        if (!$pokemon) {
            return response()->json(['message' => 'Pokemon not found'], 404);
        }
        // 使用 $request 的数据来更新 Pokemon 模型
        $pokemon->update($request->all());

        return response()->json(['message' => 'Pokemon updated successfully', 'pokemon' => $pokemon], 200);
    }

    public function destroy($id)
    {
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            return response()->json(['message' => 'Pokemon not found'], 404);
        }

        $deleted = $pokemon->delete();
        //dd($deleted);
        return response()->json(['message' => 'Pokemon deleted successfully'], 200);
    }
}