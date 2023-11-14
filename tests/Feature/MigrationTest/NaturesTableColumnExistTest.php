<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class NaturesTableColumnExistTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_natures_column_exist(): void
    {
        $this->assertTrue(Schema::hasColumn('natures', 'name'));
    }
}
