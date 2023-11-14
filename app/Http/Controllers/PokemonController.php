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
        // PokemonStoreRequest驗證整包$data的初步驗證
        $data = $request->all();
        // 自定義表单验证 PokemonStoreRequest

        // 執行進化邏輯傳進$data參數，進化或不進化都會回傳一個$evolution的值
        $evolution = $this->learnSkill->Evolution($data,false);
        // 以$validator接收bool值(傳入evolution的值判斷是否可以學習技能)
        $validator = $this->learnSkill->LearnSkillLogic($evolution);
        // 執行$validator的判斷
        if ($validator == false) {
            // 如果是false就直接回傳message
            return response()->json(['message' => 'Pokémon cannot learn these skills'], 400);
        }
        // 如果是true就繼續往下跑
        $evolution['skill'] = json_encode($evolution['skill']);

        $pokemon = Pokemon::create($evolution);

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
        if (!$pokemon) {
            return response()->json(['message' => 'Pokemon not found'], 404);
        }
        if ($request->has('level')) {
            $this->learnSkill->Evolution($data, $id);
        }

        if ($request->has('skill')) {
            $race = $pokemon->race_id;
            $skillTags = SkillTag::where('race_id', $race)->pluck('skill_id')->all();
            $skill = $data['skill'];
            $skill = array_map('intval', $skill);

            $result = SkillLogic($skill, $skillTags);
            if ($result == false) {
                return response()->json(['message' => 'Pokémon cannot learn these skills'], 400);
            }
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