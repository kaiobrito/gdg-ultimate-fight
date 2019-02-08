<?php

namespace Tests\Feature;

use App\Notifications\TodoMoved;
use App\Todo;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransitionTodoStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testCanMoveTodoToDoingStatus()
    {
        $notifications = Notification::fake();

        $todo = factory(Todo::class)->create([
            'status' => 'todo',
        ]);
        $assignees = factory(User::class, 2)->create();
        $todo->assignees()->sync($assignees);

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('todos.doing-todos.store', $todo));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $todo->id,
                'status' => 'doing',
            ],
        ]);

        $notifications->assertSentTo($assignees, TodoMoved::class, function (TodoMoved $notification) use ($todo) {
            return $notification->todo->is($todo);
        });
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
        $notifications = Notification::fake();

        $todo = factory(Todo::class)->create([
            'status' => 'doing',
        ]);
        $assignees = factory(User::class, 2)->create();
        $todo->assignees()->sync($assignees);

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('todos.todo-todos.store', $todo));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $todo->id,
                'status' => 'todo',
            ],
        ]);

        $notifications->assertSentTo($assignees, TodoMoved::class, function (TodoMoved $notification) use ($todo) {
            return $notification->todo->is($todo);
        });
    }
}
