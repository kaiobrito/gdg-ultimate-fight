<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\Events\TodoWasDone;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;

class TodoDoneTodosController extends Controller
{
    public function store(Todo $todo)
    {
        $todo->markAsDone();

        event(new TodoWasDone($todo));

        return new TodoResource($todo->load('assignees'));
    }
}
