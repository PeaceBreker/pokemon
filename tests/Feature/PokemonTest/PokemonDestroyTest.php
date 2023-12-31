<?php

namespace Tests\Feature;

use App\Models\Pokemon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PokemonDestroyTest extends TestCase
{
    //use RefreshDatabase;
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Pokemon::factory()->create();
        
        $response = $this->delete('/api/pokemons/1');

        $response->assertStatus(200);

        $this->assertDatabaseHas('pokemons', ['id' => 1]);
    }
}
