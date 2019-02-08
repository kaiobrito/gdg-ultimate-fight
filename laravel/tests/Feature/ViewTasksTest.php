<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTasksTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanSeeTheirTasks()
    {
        $user = factory(User::class)->create();
        $tasks = factory(Task::class, 3)->create([
            'user_id' => $user->id,
        ]);

        // create todos for some other user.
        factory(Task::class, 4)->create();

        $response = $this->actingAs($user, 'api')
            ->getJson(route('tasks.index'));

        $response->assertOk();
        $response->assertJsonCount($tasks->count(), 'data');
    }
}
