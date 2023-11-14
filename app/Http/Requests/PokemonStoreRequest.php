<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\SkillValidator;

class PokemonStoreRequest extends FormRequest
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
            'name' => 'required|max:20',
            'level' => 'required|integer|between:1,100',
            'nature_id' => 'required|max:20|exists:natures,id',
            'race_id' => 'required|max:20|exists:races,id',
            'ability_id' => 'required|max:20|exists:abilities,id',
            'skill' => ['required', 'array', 'between:1,4', new SkillValidator]
        ];
    }
}
