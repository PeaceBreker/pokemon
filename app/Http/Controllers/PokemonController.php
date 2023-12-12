<?php

namespace App\Http\Controllers;

use App\Http\Requests\PokemonStoreRequest;
use App\Http\Requests\PokemonUpdateRequest;
use App\Http\Resources\PokemonResource;
use App\Models\Pokemon;
use App\Models\Skilltag;
use App\Services\PokemonService;
use Symfony\Component\HttpFoundation\Response;

class PokemonController extends Controller
{
    public $evolutionAndLearnSkill;

    public function __construct(PokemonService $evolutionAndLearnSkill)
    {
        $this->evolutionAndLearnSkill = $evolutionAndLearnSkill;
    }
    public function store(PokemonStoreRequest $request)
    {
        $data = $request->validated();

        $evolution = $this->evolutionAndLearnSkill->evolution($data, false);

        $validator = $this->evolutionAndLearnSkill->learnSkillLogic($evolution);

        if ($validator == false) {

            return response()->json(['message' => 'Pokémon cannot learn these skills'], Response::HTTP_BAD_REQUEST);
        }

        $evolution['skill'] = json_encode($evolution['skill']);

        $pokemon = Pokemon::create($evolution);

        return ['message' => 'Pokemon created successfully', 'pokemons' => $pokemon, Response::HTTP_CREATED];

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
            return response()->json(['message' => 'Pokemon not found'], Response::HTTP_NOT_FOUND);
        }

        return PokemonResource::make($pokemon);
    }

    public function update(PokemonUpdateRequest $request, $id)
    {
        $pokemon = Pokemon::find($id);
        $data = $request->validated();
        if (!$pokemon) {
            return response()->json(['message' => 'Pokemon not found'], Response::HTTP_NOT_FOUND);
        }
        if ($request->has('level')) {
            $this->evolutionAndLearnSkill->evolution($data, $id);
        }

        if ($request->has('skill')) {
            $race = $pokemon->race_id;
            $skillTags = SkillTag::where('race_id', $race)->pluck('skill_id')->all();
            $skill = $data['skill'];
            $skill = array_map('intval', $skill);

            $result = skillLogic($skill, $skillTags);
            if ($result == false) {
                return response()->json(['message' => 'Pokémon cannot learn these skills'], Response::HTTP_BAD_REQUEST);
            }
        }

        $pokemon->update($request->validated());

        return response()->json(['message' => 'Pokemon updated successfully', 'pokemon' => $pokemon], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            return response()->json(['message' => 'Pokemon not found'], Response::HTTP_NOT_FOUND);
        }

        $deleted = $pokemon->delete();

        return response()->json(['message' => 'Pokemon deleted successfully'], Response::HTTP_OK);
    }
}