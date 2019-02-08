<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('tasks', 'Api\\TasksController', ['only' => ['index', 'store', 'update']]);
    Route::resource('tasks.assignees', 'Api\\TaskAssigneesController', ['only' => ['store', 'destroy']]);
    Route::resource('tasks.doing', 'Api\\TaskDoingController', ['only' => ['store']]);
    Route::resource('tasks.done', 'Api\\TaskDoneController', ['only' => ['store']]);
    Route::resource('tasks.todo', 'Api\\TaskTodoController', ['only' => ['store']]);
});
