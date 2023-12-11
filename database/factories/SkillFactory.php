<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class SkillFactory extends Factory
{

    public function definition(): array
    {
        $name = $this->faker->unique()->word;
        $name = substr($name, 0, 20);
        
        return [
            'name' => $name,
        ];
    }
}
