<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ability;
use Symfony\Component\HttpFoundation\Response;

class AbilityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20|unique:abilities',
        ]);
        try {
            $ability = Ability::create([
                'name' => $request->input('name'),
            ]);

            return response()->json([
                'success' => config('http_success_message.general.created_successfully'),
                'Ability' => $ability
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => config('http_error_message.general.error_creating')],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function index()
    {
        try {
            $abilities = Ability::all();

            return response()->json(['data' => $abilities], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => config('http_error_message.general.error_fetching')],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
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

            $updatedAbility = Ability::find($id);

            return response()->json([
                'error' => config('http_success_message.general.updated_successfully'),
                'Ability' => $updatedAbility
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => config('http_error_message.general.error_updating')],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}