<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nature;

class UploadController extends Controller
{
    public function uploadJson(Request $request)
{
    $request->validate([
        'json_file' => 'required|file|mimes:json',
    ]);

    $jsonFile = $request->file('json_file');

    $jsonData = json_decode(file_get_contents($jsonFile->getPathname()), true);
    
    foreach ($jsonData["data"]["pokemon_v2_naturename"] as $item) {
        Nature::create([
            'name' => $item['name'],
        ]);
    }

    return response()->json(['message' => 'JSON file uploaded and data saved successfully'], 201);
} 

}
