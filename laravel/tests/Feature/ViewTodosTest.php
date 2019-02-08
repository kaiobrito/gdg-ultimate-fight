<?php

namespace Tests\Feature;

use App\Todo;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTodosTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanSeeTheirTodos()
    {
        $user = factory(User::class)->create();
        $todos = factory(Todo::class, 3)->create([
            'user_id' => $user->id,
        ]);

        // create todos for some other user.
        factory(Todo::class, 4)->create();

        $response = $this->actingAs($user, 'api')
            ->getJson(route('todos.index'));

        $response->assertOk();
        $response->assertJsonCount($todos->count(), 'data');
    }
}
