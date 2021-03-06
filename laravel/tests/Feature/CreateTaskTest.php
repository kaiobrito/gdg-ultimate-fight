<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTaskTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testGuestsCannotCreateTasks()
    {
        $response = $this->postJson(route('tasks.store'), $this->validParams());

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoTitleIsRequired()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('tasks.store'), $this->validParams([
                'title' => null,
            ]));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'title'
        ]);
    }

    public function testCreatesTask()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('tasks.store'), $this->validParams());

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
                'assignees' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
        $response->assertJsonCount(1, 'data.assignees');
    }

    public function testDescriptionIsOptional()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('tasks.store'), $this->validParams([
                'description' => null,
            ]));

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
            ],
        ]);
    }

    public function testStatusIsOptionalAndDefaultsToTask()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('tasks.store'), $this->validParams([
                'status' => null,
            ]));

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'status' => 'todo',
            ],
        ]);
    }

    public function testCanCreateTasksInDoingStatus()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('tasks.store'), $this->validParams([
                'status' => 'doing',
            ]));

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'status' => 'doing',
            ],
        ]);
    }

    public function testCanCreateTaskInDoneStatus()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('tasks.store'), $this->validParams([
                'status' => 'done',
            ]));

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'status' => 'done',
            ],
        ]);
    }

    public function testCannotCreateTaskWithRandomStatus()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->postJson(route('tasks.store'), $this->validParams([
                'status' => $this->faker->word,
            ]));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'status',
        ]);
    }

    private function validParams(array $overrides = []): array
    {
        return array_replace([
            'title' => 'Get Milk',
            'description' => 'Go to the store and buy some milk.',
            'status' => 'todo',
        ], $overrides);
    }
}
