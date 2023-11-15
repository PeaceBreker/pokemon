<?php

namespace Tests\Feature;

use App\Models\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PokemonDestroyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Pokemon::factory()->create();
        
        $response = $this->delete('/api/pokemons/2');

        $response->assertStatus(200);

        $this->assertDatabaseHas('pokemons', ['id' => 2]);
    }
}
