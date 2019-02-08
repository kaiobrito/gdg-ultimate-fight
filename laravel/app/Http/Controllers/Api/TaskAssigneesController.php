<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\TaskResource;
use App\Http\Controllers\Controller;

class TaskAssigneesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     *
     * @return \App\Http\Resources\TaskResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Task $task)
    {
        $this->validate($request, [
            'user_id' => [
                'required',
                Rule::exists('users','id'),
            ],
        ]);

        $assigneeId = $request->input('user_id');

        $task->assignees()->syncWithoutDetaching($assigneeId);

        return new TaskResource($task->load('assignees'));
    }

    public function destroy(Task $task, User $assignee)
    {
        $task->removeAssignee($assignee);

        return new TaskResource($task->load('assignees'));
    }
}
