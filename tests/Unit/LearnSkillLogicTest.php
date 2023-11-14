<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class LearnSkillLogicTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testUserCanLearnSkill(): void
    {
        // 模擬skillTags假資料
         $skillTags = [1, 2, 3, 4];
        // 模拟用户输入数据
        $pokemonData = [1, 2, 3, 5];
        // foreach循環查看檢查是否在array裡，這裡是模擬錯誤的消息，以驗證邏輯正確性

        $this->assertEquals(false, SkillLogic($pokemonData, $skillTags));
    
    }
}