<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SkillsTableColumnExistTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_skills_column_exist(): void
    {
        $this->assertTrue(Schema::hasColumn('skills', 'name'));
    }
}
