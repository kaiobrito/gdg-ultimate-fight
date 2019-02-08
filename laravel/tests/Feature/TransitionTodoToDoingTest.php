<?php

namespace Tests\Feature;

use App\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransitionTodoToDoingTest extends TestCase
{
    use RefreshDatabase;

    public function testCanMoveTodoToDoingStatus()
    {
        $todo = factory(Todo::class)->create([
            'status' => 'todo',
        ]);

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('todos.doing-todos.store', $todo));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $todo->id,
                'status' => 'doing',
            ],
        ]);
    }
}
