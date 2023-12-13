<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use Symfony\Component\HttpFoundation\Response;

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

        return response()->json(
            ['success' => config('http_success_message.general.created_successfully'), 'data' => $skill],
            Response::HTTP_CREATED
        );
    }

    public function index()
    {
        $skills = Skill::all();

        return response()->json(['data' => $skills], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:skills|max:20',
        ]);

        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(
                ['error' => config('http_error_message.general.not_found')],
                Response::HTTP_NOT_FOUND
            );
        }

        $skill->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(
            ['success' => config('http_success_message.general.updated_successfully'), 'data' => $skill],
            Response::HTTP_OK
        );
    }
}