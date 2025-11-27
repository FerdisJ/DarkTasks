<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskPageTest extends TestCase  // <-- Este nombre
{
    use RefreshDatabase;

    public function test_authenticated_user_can_see_tasks_board(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tasks');

        $response->assertStatus(200);
        $response->assertSee('Task Manager');
    }
}
