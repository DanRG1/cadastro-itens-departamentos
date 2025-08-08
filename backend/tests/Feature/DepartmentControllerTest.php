<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Department;

class DepartmentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para listar todos os departamentos.
     *
     * @return void
     */
    public function test_can_list_departments()
    {
        Department::factory()->count(3)->create();

        $response = $this->getJson('/api/departments');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /**
     * Teste para criar um novo departamento.
     *
     * @return void
     */
    public function test_can_create_department()
    {
        $departmentData = ['name' => 'Novo Departamento'];

        $response = $this->postJson('/api/departments', $departmentData);

        $response->assertStatus(201)
                 ->assertJsonFragment($departmentData);

        $this->assertDatabaseHas('departments', $departmentData);
    }
}
