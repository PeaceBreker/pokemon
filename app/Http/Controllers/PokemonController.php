<?php

namespace App\Http\Controllers;

use App\Http\Requests\PokemonStoreRequest;
use App\Http\Requests\PokemonUpdateRequest;
use App\Http\Resources\PokemonResource;
use App\Models\Pokemon;
use App\Models\Skilltag;
use App\Services\PokemonService;

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

        $evolution = $this->learnSkill->Evolution($data,false);

        $validator = $this->learnSkill->LearnSkillLogic($evolution);

        if ($validator == false) {

            return response()->json(['message' => 'Pokémon cannot learn these skills'], 400);
        }

        $evolution['skill'] = json_encode($evolution['skill']);

        $pokemon = Pokemon::create($evolution);

        return ['message' => 'Pokemon created successfully', 'pokemons' => $pokemon, 201];

    }

    public function index()
    {
        $pokemons = Pokemon::all();

        return PokemonResource::collection($pokemons);
    }

    public function show($id)
    {
        $pokemon = Pokemon::with('nature', 'race', 'ability')->find($id);
        if (!$pokemon) {
            return response()->json(['message' => 'Pokemon not found'], 404);
        }

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

        return response()->json(['message' => 'Pokemon deleted successfully'], 200);
    }
}