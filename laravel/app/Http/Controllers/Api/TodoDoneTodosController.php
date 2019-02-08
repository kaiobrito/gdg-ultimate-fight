<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\Notifications\TodoDone;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;

class TodoDoneTodosController extends Controller
{
    public function store(Todo $todo)
    {
        $todo->markAsDone();

        foreach ($todo->assignees as $assignee) {
            $assignee->notify(new TodoDone($todo));
        }

        return new TodoResource($todo);
    }
}
