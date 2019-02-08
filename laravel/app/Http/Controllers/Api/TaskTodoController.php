<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\Events\TaskWasMoved;
use App\Http\Resources\TaskResource;
use App\Http\Controllers\Controller;

class TaskTodoController extends Controller
{
    public function store(Task $task)
    {
        $task->markAsTodo();

        event(new TaskWasMoved($task));

        return new TaskResource($task->load('assignees'));
    }
}
