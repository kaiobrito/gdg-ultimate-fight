<?php

namespace App\Http\Controllers\Api;

use App\Rules\ExistsIn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodoAssigneesController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_ids' => [
                'required',
                'array',
                new ExistsIn('users', 'id'),
            ],
        ]);
    }
}
