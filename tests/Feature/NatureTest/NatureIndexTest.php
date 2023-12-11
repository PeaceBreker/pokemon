<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NatureIndexTest extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('api/natures');

        $response->assertStatus(200);
    }
}
