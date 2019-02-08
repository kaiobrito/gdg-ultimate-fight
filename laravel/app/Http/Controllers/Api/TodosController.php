<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\TodoResource;
use App\Http\Controllers\Controller;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $todos = $request->user()->todos()->paginate();

        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\TodoResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:todo,doing,done'],
        ]);

        $todo = $request->user()->todos()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status') ?: 'todo',
        ]);

        return new TodoResource($todo->refresh());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
