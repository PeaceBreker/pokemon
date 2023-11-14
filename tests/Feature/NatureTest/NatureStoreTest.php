<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NatureStoreTest extends TestCase
{
    //use RefreshDatabase;
    //use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $nature = [
        'name' => "爆炸"            
        ];
        $response = $this->post('api/natures', $nature);

        $response->assertStatus(201);
    }
}
