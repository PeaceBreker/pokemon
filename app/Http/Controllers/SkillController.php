<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:skills|max:20',
        ]);

        $skill = Skill::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Skill created successfully', 'data' => $skill], 201);
    }

    public function index()
    {
        $skills = Skill::all();

        return response()->json(['data' => $skills], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:skills|max:20',
        ]);

        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(['message' => 'Skill not found'], 404);
        }

        $skill->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Skill updated successfully', 'data' => $skill], 200);
    }
}
