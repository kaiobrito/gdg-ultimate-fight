<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatesTodosTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsCannotCreateTodos()
    {
        $response = $this->postJson(route('todos.store'), $this->validParams());

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoTitleIsRequired()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('todos.store'), $this->validParams([
                'title' => null,
            ]));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'title'
        ]);
    }

    public function testCreatesTodo()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('todos.store'), $this->validParams());

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
            ],
        ]);
    }

    public function testDescriptionIsOptional()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('todos.store'), $this->validParams([
                'description' => null,
            ]));

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
            ],
        ]);
    }

    public function testStatusIsOptionalAndDefaultsToTodo()
    {
    }

    public function testCanCreateTodosInDoingStatus()
    {
    }

    public function testCanCreateTodoInDoneStatus()
    {
    }

    private function validParams(array $overrides = []): array
    {
        return array_replace([
            'title' => 'Get Milk',
            'description' => 'Go to the store and buy some milk.',
            'status' => 'todo',
        ], $overrides);
    }
}
