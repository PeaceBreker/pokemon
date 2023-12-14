<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SKillIndexTest extends TestCase
{
    use DatabaseMigrations;
    
    public function test_example(): void
    {
        $response = $this->get('/api/skills');

        $response->assertStatus(200);
    }
}
