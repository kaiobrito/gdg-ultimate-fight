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

    Route::resource('todos', 'Api\\TodosController', ['only' => ['index', 'store', 'update']]);
    Route::resource('todos.assignees', 'Api\\TodoAssigneesController', ['only' => ['store']]);
    Route::resource('todos.doing-todos', 'Api\\TodoDoingTodosController', ['only' => ['store']]);
    Route::resource('todos.done-todos', 'Api\\TodoDoneTodosController', ['only' => ['store']]);
});
