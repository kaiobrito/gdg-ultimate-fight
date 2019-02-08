<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\Events\TodoWasMoved;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;

class TodoDoingTodosController extends Controller
{
    public function store(Todo $todo)
    {
        $todo->markAsDoing();

        event(new TodoWasMoved($todo));

        return new TodoResource($todo);
    }
}
