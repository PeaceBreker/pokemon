<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pokemon>
 */
class PokemonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Luka',
            'level' => '30',
            'nature_id' => 6,
            'race_id' => 4,
            'ability_id' => 6,
            'skill' => "[6 ,7 ,8 ,9]",
        ];
    }
}