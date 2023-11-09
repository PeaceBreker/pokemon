<?php

namespace Tests\Feature;

use App\Models\Skill;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SKillUpdateTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Skill::factory()->create();

        $response = $this->put('/api/skills/1', ['name' => "肉蛋蔥雞"]);

        $response->assertStatus(200);
    }
}