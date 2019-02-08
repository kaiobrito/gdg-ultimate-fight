<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;

class TodoDoneTodosController extends Controller
{
    public function store(Todo $todo)
    {
        $todo->markAsDone();

        return new TodoResource($todo->load('assignees'));
    }
}
