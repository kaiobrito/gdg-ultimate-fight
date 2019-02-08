<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\Events\TaskWasDone;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;

class TaskDoneController extends Controller
{
    public function store(Task $task)
    {
        $task->markAsDone();

        event(new TaskWasDone($task));

        return new TaskResource($task->load('assignees'));
    }
}
