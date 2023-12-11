<?php

namespace Tests\Feature;

use Tests\TestCase;

class NatureStoreTest extends TestCase
{
    public function test_example(): void
    {
        $nature = [
        'name' => "爆炸"            
        ];
        $response = $this->post('api/natures', $nature);

        $response->assertStatus(201);
    }
}
