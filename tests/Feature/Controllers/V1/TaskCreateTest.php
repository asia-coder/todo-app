<?php

namespace Tests\Feature\Controllers\V1;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TaskHelper;
use Tests\TestCase;

class TaskCreateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_create_task()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->postJson(self::API_V1 . '/task', [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(TaskHelper::oneTaskResponseStructure());

        $this->assertIsString($response['data']['id']);
        $this->assertIsString($response['data']['title']);
        $this->assertIsString($response['data']['status']);
        $this->assertIsString($response['data']['created_at']);
        $this->assertIsString($response['data']['updated_at']);

        $this->assertDatabaseHas('tasks', [
            'id' => $response['data']['id'],
            'title' => $response['data']['title'],
            'description' => $response['data']['description'],
            'status' => $response['data']['status'],
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_create_task_by_empty_title_request()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->postJson(self::API_V1 . '/task', [
            'title' => null,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title'])
            ->assertJsonMissingValidationErrors(['description']);
    }

    public function test_user_cannot_create_task_by_invalidation_title_type_request()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->postJson(self::API_V1 . '/task', [
            'title' => $this->faker->randomNumber(),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title'])
            ->assertJsonMissingValidationErrors(['description']);
    }

    public function test_unauthenticated_user_cannot_create_task()
    {
        $response = $this->postJson(self::API_V1 . '/task', [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ]);

        $response->assertStatus(401);
    }
}
