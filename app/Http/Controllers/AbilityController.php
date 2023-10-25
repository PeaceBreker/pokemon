<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ability;

class AbilityController extends Controller
{
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|max:100|unique:abilities',
        ]);
        try {
            $Ability = Ability::create([
                'name' => $request->input('name'),
            ]);

            return response()->json([
                'message' => 'Ability created successfully','Ability' => $Ability], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while creating ability'], 500);
        }
    }

    public function index()
    {
        try {
            $abilities = Ability::all();

            return response()->json(['data' => $abilities], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while fetching abilities'], 500);
        }
    }

    public function update(Request $request, $id)
{
    try {
        $ability = Ability::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:20|unique:abilities',
        ]);

        $ability->update([
            'name' => $request->input('name'),
        ]);

        // 重新加载已更新的能力
        $updatedAbility = Ability::find($id);

        return response()->json([
            'message' => 'Ability updated successfully','Ability' => $updatedAbility], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error occurred while updating ability'], 500);
    }
}
}
