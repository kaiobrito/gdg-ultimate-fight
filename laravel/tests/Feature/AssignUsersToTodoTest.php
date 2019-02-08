<?php

namespace Tests\Feature;

use App\Todo;
use App\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignUsersToTodoTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsCannotAssignUsersToAnything()
    {
        $assignee = factory(User::class)->create();
        $todo = factory(Todo::class)->create();

        $response = $this->postJson(route('todos.assignees.store', [$todo]), [
            'user_id' => $assignee->id,
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUsersMustExistToBeAssigned()
    {
        $todo = factory(Todo::class)->create();

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('todos.assignees.store', [$todo]), [
                'user_id' => 123123123,
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'user_id',
        ]);
    }

    public function testCanAssignUsersToTodos()
    {
        $todo = factory(Todo::class)->create();
        $assignee = factory(User::class)->create();

        $response = $this->actingAs($todo->user, 'api')
            ->postJson(route('todos.assignees.store', [$todo]), [
                'user_id' => $assignee->id,
            ]);

        $response->assertStatus(Response::HTTP_OK);
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
        $todo = factory(Todo::class)->create();
        $assignees = factory(User::class, 4)->create();
        $todo->assignees()->sync($assignees);

        $response = $this->actingAs($todo->user, 'api')
            ->deleteJson(route('todos.assignees.destroy', [$todo, $assignees->first()]));

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
