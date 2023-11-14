<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PokemonUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|max:20',
            'level' => 'sometimes|required|integer|max:100',
            'nature_id' => 'sometimes|required|max:20|exists:natures,id',
            'race_id' => 'sometimes|required|max:20|exists:race,id',
            'ability_id' => 'sometimes|required|max:20|exists:abilities,id',
            'skill' => 'sometimes|required|array|between:1,4'
        ];
    }
}
