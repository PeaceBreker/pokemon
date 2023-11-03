<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AbilityStoreTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $ability = [
            'name' => "超強新秀"
        ];

        $response = $this->post('api/abilities', $ability);
        $response->assertStatus(201);
        $this->assertDatabaseHas('abilities', ['name' => "超強新秀"]);
    }
}