<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignUsersToTaskTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsCannotAssignUsersToAnything()
    {
        $assignee = factory(User::class)->create();
        $todo = factory(Task::class)->create();

        $response = $this->postJson(route('tasks.assignees.store', [$todo]), [
            'user_id' => $assignee->id,
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUsersMustExistToBeAssigned()
    {
        $todo = factory(Task::class)->create();

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('tasks.assignees.store', [$todo]), [
                'user_id' => 123123123,
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'user_id',
        ]);
    }

    public function testCanAssignUsersToTodos()
    {
        $todo = factory(Task::class)->create();
        $assignee = factory(User::class)->create();

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('tasks.assignees.store', [$todo]), [
                'user_id' => $assignee->id,
            ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(1, 'data.assignees');
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
                'assignees' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
    }

    public function testRemoveAssignedUsers()
    {
        $todo = factory(Task::class)->create();
        $assignees = factory(User::class, 4)->create();
        $todo->assignees()->sync($assignees);

        $response = $this->actingAs($todo->user, 'api')
            ->deleteJson(route('tasks.assignees.destroy', [$todo, $assignees->first()]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
                'assignees',
            ],
        ]);
        $response->assertJsonCount($assignees->count() - 1, 'data.assignees');
    }
}
