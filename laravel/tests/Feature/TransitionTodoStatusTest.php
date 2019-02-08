<?php

namespace Tests\Feature;

use App\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransitionTodoStatusTest extends TestCase
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

    public function testCanMoveTodoToDoneStatus()
    {
        $todo = factory(Todo::class)->create([
            'status' => 'doing',
        ]);

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('todos.done-todos.store', $todo));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $todo->id,
                'status' => 'done',
            ],
        ]);
    }

    public function testCanTransitionTodoBackToTodo()
    {
        $todo = factory(Todo::class)->create([
            'status' => 'doing',
        ]);

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('todos.todo-todos.store', $todo));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $todo->id,
                'status' => 'todo',
            ],
        ]);
    }
}
