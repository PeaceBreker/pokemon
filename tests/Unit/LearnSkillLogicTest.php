<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class LearnSkillLogicTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testUserCanLearnSkill(): void
    {
         $skillTags = [1, 2, 3, 4];

        $pokemonData = [1, 2, 3, 5];

        $this->assertEquals(false, SkillLogic($pokemonData, $skillTags)); 
    }
}