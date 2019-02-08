<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use App\Rules\ExistsIn;
use Illuminate\Http\Request;
use App\Http\Resources\TodoResource;
use App\Http\Controllers\Controller;

class TodoAssigneesController extends Controller
{
    public function store(Request $request, Todo $todo)
    {
        $this->validate($request, [
            'user_ids' => [
                'present',
                'array',
                (new ExistsIn('users', 'id'))
                    ->canBeEmpty(),
            ],
        ]);

        $assignees = $request->input('user_ids');

        $todo->assignees()->sync($assignees);

        return new TodoResource($todo->load('assignees'));
    }
}
