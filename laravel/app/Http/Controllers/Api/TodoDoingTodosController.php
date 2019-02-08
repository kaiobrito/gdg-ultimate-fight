<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\Notifications\TodoMoved;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;

class TodoDoingTodosController extends Controller
{
    public function store(Todo $todo)
    {
        $todo->markAsDoing();

        /** @var \App\User $assignee */
        foreach ($todo->assignees as $assignee) {
            $assignee->notify(new TodoMoved($todo));
        }

        return new TodoResource($todo);
    }
}
