<?php

namespace Tests\Feature;

use App\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTodoTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testCanUpdateTitleAndPermission()
    {
        $todo = factory(Todo::class)->create();

        $newTitle = $this->faker->sentence;
        $newDescription = $this->faker->paragraph;

        $response = $this->actingAs($todo->user, 'api')
            ->putJson(route('todos.update', $todo), [
                'title' => $newTitle,
                'description' => $newDescription,
            ]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $todo->id,
                'title' => $newTitle,
                'description' => $newDescription,
            ],
        ]);
    }

    public function testTitleIsRequired()
    {
    }

    public function testDescriptionCanBeNull()
    {
    }
}
