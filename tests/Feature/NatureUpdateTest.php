<?php

namespace Tests\Feature;

use App\Models\Nature;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NatureUpdateTest extends TestCase
{
    use DatabaseMigrations;    
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Nature::factory()->create();
        $response = $this->put('api/natures/1', ['name' => "躁鬱症"]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('natures', [
            'name' => "躁鬱症",
        ]);
    }
}