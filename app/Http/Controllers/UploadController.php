<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nature;
use Symfony\Component\HttpFoundation\Response;

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

        return response()->json(
            ['success' => config('http_success_message.upload.json_file_saved_successfully')],
            Response::HTTP_CREATED
        );
    }

}