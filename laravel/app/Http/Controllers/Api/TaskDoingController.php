<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\Events\TaskWasMoved;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;

class TaskDoingController extends Controller
{
    public function store(Task $task)
    {
        $task->markAsDoing();

        event(new TaskWasMoved($task));

        return new TaskResource($task->load('assignees'));
    }
}
