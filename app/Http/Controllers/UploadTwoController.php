<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use Illuminate\Http\Request;

class UploadTwoController extends Controller
{
    public function uploadJson(Request $request)
{
    $request->validate([
        'json_file' => 'required|file',
    ]);

    
    $jsonFile = $request->file('json_file');


    $jsonData = json_decode(file_get_contents($jsonFile->getPathname()), true);
    

    foreach ($jsonData["data"]["pokemon_v2_ability"] as $item) {
        $abilityNames = $item["pokemon_v2_abilitynames"];
        if (!empty($abilityNames) && isset($abilityNames[0]['name'])) {
            $abilityName = $abilityNames[0]['name'];
            Ability::create([
                'name' => $abilityName,
            ]);
        }
    }
    

    return response()->json(['message' => 'JSON file uploaded and data saved successfully'], 201);
}
}
