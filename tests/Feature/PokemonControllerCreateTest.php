<?php

namespace Tests\Feature;

use App\Models\Ability;
use App\Models\Nature;
use App\Models\Race;
use App\Models\Skill;
use App\Models\Skilltag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PokemonControllerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {   
        // 基礎假資料生成
        $races = Race::factory()
                ->count(3)
                ->sequence(
                    ['name' => 'Bulbasaur'],
                    ['name' => 'Ivysaur'],
                    ['name' => 'Venusaur'],
                )
                ->create();
        $ability = Ability::factory()->count(5)->create();
        $nature = Nature::factory()->count(5)->create();
        $skill = Skill::factory()->count(5)->create();
        // 模擬skilltags假資料
        $skilltagForRace1 = Skilltag::factory()->count(4)->forRaceId(1)->create();
        $skilltagForRace2 = Skilltag::factory()->count(4)->forRaceId(2)->create();
        $skilltagForRace3 = Skilltag::factory()->count(4)->forRaceId(3)->create();
        // 模拟用户输入数据
        $pokemonData = [
            'name' => 'Luka',
            'level' => '30',
            'nature_id' => 1,
            'race_id' => 1,
            'ability_id' => 1,
            'skill' => [1,2,3,4],
        ];
        // 发送 POST 请求到控制器的 API 端点
        $response = $this->post('/api/pokemons', $pokemonData);
        //dd($response);
        // 断言响应状态码是否为 200
        $response->assertStatus(200);
    }
}
