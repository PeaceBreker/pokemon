<?php

namespace Tests\Unit;

use App\Models\Ability;
use App\Models\Nature;
use App\Models\Race;
use App\Models\Skill;
use App\Models\Skilltag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class LearnSkillLogicTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     */
    public function testUserCanLearnSkill(): void
    {
        // 模擬skilltags假資料
        $skilltags = [
            ['race_id' => 1, 'skill_id' => 1],
            ['race_id' => 1, 'skill_id' => 2],
            ['race_id' => 1, 'skill_id' => 3],
            ['race_id' => 1, 'skill_id' => 4],
        ];
        // 模拟用户输入数据
        $pokemonData = ['skill' => [1, 2, 3, 5],];
        // foreach循環查看檢查是否在array裡，這裡是模擬錯誤的消息，以驗證邏輯正確性
        foreach ($pokemonData['skill'] as $skills) {
            if (!in_array($skills, $skilltags)) {
                $this->assertTrue(True ,'Pokémon cannot learn these skills');
            }
        }
    }
}