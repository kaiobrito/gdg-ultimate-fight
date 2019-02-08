<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatesTodosTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsCannotCreateTodos()
    {
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
