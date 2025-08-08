<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Department;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para listar todos os itens.
     *
     * @return void
     */
    public function test_can_list_items()
    {
        Department::factory()->create(); // Cria um departamento para associar aos itens
        Item::factory()->count(3)->create();

        $response = $this->getJson('/api/items');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}
