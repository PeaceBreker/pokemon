<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PokemonTableExistTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_pokemons_table_exist(): void
    {   
        // 運行迁移
        Artisan::call('migrate');
    
        // 斷言數據庫中是否有預期的表
        $this->assertTrue(Schema::hasTable('pokemons'));
    }
}
