<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\TodoResource;
use App\Http\Controllers\Controller;

class TodoAssigneesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Todo $todo
     *
     * @return \App\Http\Resources\TodoResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Todo $todo)
    {
        $this->validate($request, [
            'user_id' => [
                'required',
                Rule::exists('users','id'),
            ],
        ]);

        $assigneeId = $request->input('user_id');

        $todo->assignees()->syncWithoutDetaching($assigneeId);

        return new TodoResource($todo->load('assignees'));
    }

    public function destroy(Todo $todo, User $assignee)
    {
        $todo->removeAssignee($assignee);

        return new TodoResource($todo->load('assignees'));
    }
}
