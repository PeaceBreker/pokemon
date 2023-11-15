<?php

namespace Tests\Feature;

use App\Models\Race;
use App\Models\Skill;
use App\Models\Skilltag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RaceGetSkillsByRaceIdTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Race::factory()->create();
        Skill::factory()->count(4)->create();
        Skilltag::factory()->count(4)->forRaceId(1)->create();
        
        $response = $this->get('api/races/1/skills');

        $response->assertStatus(200);
    }
}
