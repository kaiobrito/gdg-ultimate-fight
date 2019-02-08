<?php

namespace Tests\Feature;

use App\Notifications\TaskDone;
use App\Notifications\TaskMoved;
use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransitionTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testCanMoveTodoToDoingStatus()
    {
        $notifications = Notification::fake();

        $task = factory(Task::class)->create([
            'status' => 'todo',
        ]);
        $assignees = factory(User::class, 2)->create();
        $task->assignees()->sync($assignees);

        $response = $this->actingAs($task->user, 'api')
            ->postJson(route('tasks.doing.store', $task));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'status' => 'doing',
            ],
        ]);

        $notifications->assertSentTo($assignees, TaskMoved::class, function (TaskMoved $notification) use ($task) {
            return $notification->task->is($task);
        });
    }

    public function testCanMoveTodoToDoneStatus()
    {
        $notifications = Notification::fake();

        $task = factory(Task::class)->create([
            'status' => 'doing',
        ]);
        $assignees = factory(User::class, 2)->create();
        $task->assignees()->sync($assignees);

        $response = $this->actingAs($task->user, 'api')
            ->postJson(route('tasks.done.store', $task));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'status' => 'done',
            ],
        ]);

        $notifications->assertSentTo($assignees, TaskDone::class, function (TaskDone $notification) use ($task) {
            return $notification->todo->is($task);
        });
    }

    public function testCanTransitionTodoBackToTodo()
    {
        $notifications = Notification::fake();

        $task = factory(Task::class)->create([
            'status' => 'doing',
        ]);
        $assignees = factory(User::class, 2)->create();
        $task->assignees()->sync($assignees);

        $response = $this->actingAs($task->user, 'api')
            ->postJson(route('tasks.todo.store', $task));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'status' => 'todo',
            ],
        ]);

        $notifications->assertSentTo($assignees, TaskMoved::class, function (TaskMoved $notification) use ($task) {
            return $notification->task->is($task);
        });
    }
}
