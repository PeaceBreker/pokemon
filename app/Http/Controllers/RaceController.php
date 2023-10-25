<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Race;
use App\Models\Skill;
use App\Models\Skilltag;

class RaceController extends Controller
{
    public function getRaceByName(Request $request, $name)
{
    // 假设你有一个名为 Race 的模型与 races 表对应

    $race = Race::where('name', $name)->first();

    if (!$race) {
        return response()->json(['message' => 'Race not found'], 404);
    }

    return response()->json(['race' => $race->name], 200);
}
    public function getAllRaces(Request $request)
    {
        try {
            $races = Race::all();

            return response()->json(['races' => $races], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while fetching races from the database'], 500);
        }
    }

    public function getAllPokemonRaces(Request $request)
{
    // 假设你有一个名为 Race 的模型与 races 表对应

    $races = Race::all()->pluck('name');

    return response()->json(['races' => $races], 200);
}

    public function getSkillsByRaceId(Request $request, $id)
{
    $race = Race::find($id);

    if (!$race) {
        return response()->json(['message' => 'Race not found'], 404);
    }
    $raceId = $race->id;
    $skillTags = SkillTag::where('race_id', $raceId)->get();
    
    $skillData = [];
    
    foreach ($skillTags as $skillTag) {
        $skillId = $skillTag->skill_id;
        $show = Skill::find($skillId);
        $skillName = $show->name;
        $skillData[$skillId] = $skillName;
    }
    
    ksort($skillData);

    return response()->json(['skill_data' => $skillData]);
}
}
