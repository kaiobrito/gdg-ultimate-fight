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
        $response = $this->postJson(route('todos.store'), [
            'title' => 'Get Milk',
            'description' => 'Go to the store and buy some milk.',
            'status' => 'todo',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoTitleIsRequired()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('todos.store'), [
                'title' => null,
                'description' => 'Go to the store and buy some milk.',
                'status' => 'todo',
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'title'
        ]);
    }

    public function testCreatesTodo()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('todos.store'), [
                'title' => 'Get Milk',
                'description' => 'Go to the store and buy some milk.',
                'status' => 'todo',
            ]);

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
}
