<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use Illuminate\Http\Request;

class NatureController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:20|unique:natures',
        ]);
        $nature = Nature::create($validatedData);
        return response()->json(['message' => 'Nature created successfully', 'nature' => $nature], 201);
    }

    public function index()
    {
        $natures = Nature::all();

        return response()->json(['natures' => $natures], 200);
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:20|unique:natures',
        ]);

        $nature = Nature::find($id);

        if (!$nature) {
            return response()->json(['message' => 'Nature not found'], 404);
        }

        $nature->update($validatedData);

        return response()->json(['message' => 'Nature updated successfully', 'nature' => $nature], 200);
    }//
}
