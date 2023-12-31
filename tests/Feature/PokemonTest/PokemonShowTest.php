<?php

namespace Tests\Feature;

use App\Models\Ability;
use App\Models\Nature;
use App\Models\Pokemon;
use App\Models\Race;
use App\Models\Skill;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PokemonShowTest extends TestCase
{
    //use RefreshDatabase;
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // 基礎假資料生成
        Race::factory()->create(['name' => 'Bulbasaur']);
        Ability::factory()->create(['name' => '硬化']);
        Nature::factory()->create(['name' => '暴怒仔']);
        Skill::factory()->count(4)->create();
        Pokemon::factory()->create();

        $response = $this->get('/api/pokemons/1');

        $response->assertStatus(200);
    }
}