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
            'users' => [$assignee->id],
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUsersMustExistToBeAssigned()
    {
    }

    public function testCanAssignUsersToTodos()
    {
    }

    public function testCanAssignMultipleUsersAtOnce()
    {
    }
}
