<?php

namespace Tests\Feature;

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
    }

    public function testCreatesTodo()
    {
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
