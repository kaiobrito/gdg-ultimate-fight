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
    public function store(Request $request, Todo $todo)
    {
        $this->validate($request, [
            'user_id' => [
                'required',
                Rule::exists('users','id'),
            ],
        ]);

        $assignees = $request->input('user_ids');

        $todo->assignees()->sync($assignees);

        return new TodoResource($todo->load('assignees'));
    }

    public function destroy(Todo $todo, User $assignee)
    {
        $todo->removeAssignee($assignee);

        return new TodoResource($todo->load('assignees'));
    }
}
