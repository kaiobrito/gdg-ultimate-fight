<?php

namespace Tests\Feature;

use App\Task;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTaskTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testCanUpdateTitleAndPermission()
    {
        $task = factory(Task::class)->create();

        $newTitle = $this->faker->sentence;
        $newDescription = $this->faker->paragraph;

        $response = $this->actingAs($task->user, 'api')
            ->putJson(route('tasks.update', $task), [
                'title' => $newTitle,
                'description' => $newDescription,
            ]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'title' => $newTitle,
                'description' => $newDescription,
            ],
        ]);
    }

    public function testTitleIsRequired()
    {
        $task = factory(Task::class)->create();

        $response = $this->actingAs($task->user, 'api')
            ->putJson(route('tasks.update', $task), [
                'title' => null,
                'description' => $this->faker->paragraph,
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'title',
        ]);
    }

    public function testDescriptionCanBeNull()
    {
        $task = factory(Task::class)->create();

        $newTitle = $this->faker->sentence;
        $newDescription = null;

        $response = $this->actingAs($task->user, 'api')
            ->putJson(route('tasks.update', $task), [
                'title' => $newTitle,
                'description' => $newDescription,
            ]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'title' => $newTitle,
                'description' => $newDescription,
            ],
        ]);
    }

    public function testCannotUpdateStatusOfTask()
    {
        $task = factory(Task::class)->create([
            'status' => 'todo',
        ]);

        $newTitle = $this->faker->sentence;
        $newDescription = null;

        $response = $this->actingAs($task->user, 'api')
            ->putJson(route('tasks.update', $task), [
                'title' => $newTitle,
                'description' => $newDescription,
                'status' => 'doing',
            ]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'title' => $newTitle,
                'description' => $newDescription,
                'status' => 'todo',
            ],
        ]);
    }
}
