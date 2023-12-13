<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NatureController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:20|unique:natures',
        ]);
        $nature = Nature::create($validatedData);
        return response()->json(
            [
                'success' => config('http_success_message.general.created_successfully'),
                'nature' => $nature
            ],
            Response::HTTP_CREATED
        );
    }

    public function index()
    {
        $natures = Nature::all();

        return response()->json(['natures' => $natures], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:20|unique:natures',
        ]);

        $nature = Nature::find($id);

        if (!$nature) {
            return response()->json(
                ['error' => config('http_error_message.general.not_found')],
                Response::HTTP_NOT_FOUND
            );
        }

        $nature->update($validatedData);

        return response()->json(
            [
                'success' => config('http_success_message.general.updated_successfully'),
                'nature' => $nature
            ],
            Response::HTTP_OK
        );
    }
}