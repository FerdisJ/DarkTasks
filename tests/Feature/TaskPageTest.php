<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_see_tasks_board(): void
    {
        // Crear usuario de prueba
        $user = User::factory()->create();

        // Acceder a la página de tareas
        $response = $this->actingAs($user)->get('/tasks');

        // Comprobar estado y contenido
        $response->assertStatus(200);
        $response->assertSee('Task Manager');
    }
}
