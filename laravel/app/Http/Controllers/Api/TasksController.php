<?php

namespace App\Http\Controllers\Api;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $tasks = $request->user()->assignedTasks()->paginate();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\TaskResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:todo,doing,done'],
        ]);

        $task = $request->user()->tasks()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status') ?: 'todo',
        ]);

        return new TaskResource($task->refresh());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \App\Http\Resources\TaskResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Task $task)
    {
        $params = $this->validate($request, [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $task->update($params);

        return new TaskResource($task->load('assignees'));
    }
}
