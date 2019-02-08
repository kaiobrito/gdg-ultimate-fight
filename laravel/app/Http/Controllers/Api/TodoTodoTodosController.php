<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\Events\TodoWasMoved;
use App\Http\Resources\TodoResource;
use App\Http\Controllers\Controller;

class TodoTodoTodosController extends Controller
{
    public function store(Todo $todo)
    {
        $todo->markAsTodo();

        event(new TodoWasMoved($todo));

        return new TodoResource($todo->load('assignees'));
    }
}
