<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\Notifications\TodoMoved;
use App\Http\Resources\TodoResource;
use App\Http\Controllers\Controller;

class TodoTodoTodosController extends Controller
{
    public function store(Todo $todo)
    {
        $todo->markAsTodo();

        foreach ($todo->assignees as $assignee) {
            $assignee->notify(new TodoMoved($todo));
        }

        return new TodoResource($todo);
    }
}
