<?php

namespace Tests\Feature\Controllers\V1;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TaskHelper;
use Tests\TestCase;

class TaskGetTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_get_all_tasks()
    {
        $user = $this->createUser();
        $tasks = $user->tasks()->createMany(
            Task::factory(3)->make()->toArray()
        );

        $response = $this->actingAs($user)->getJson(self::API_V1 . '/task/list');

        $response->assertStatus(200)
            ->assertJsonStructure(TaskHelper::listResponseStructure());

        $this->assertCount($tasks->count(), $response['data']);
    }

    public function test_unauthenticated_user_cannot_get_all_tasks()
    {
        $response = $this->getJson(self::API_V1 . '/task/list');

        $response->assertStatus(401);
    }

    public function test_user_can_get_one_task()
    {
        $user = $this->createUser();
        $task = $user->tasks()->create(
            Task::factory()->make()->toArray()
        );

        $response = $this->actingAs($user)->getJson(self::API_V1 . '/task/' . $task->id);

        $response->assertStatus(200)
            ->assertJsonStructure(TaskHelper::oneTaskResponseStructure());

        $this->assertEquals($task->id, $response['data']['id']);
    }

    public function test_user_cannot_get_another_user_task()
    {
        $user = $this->createUser();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->getJson(self::API_V1 . '/task/' . $task->id);

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_get_one_task()
    {
        $response = $this->getJson(self::API_V1 . '/task/' . $this->faker->uuid);

        $response->assertStatus(401);
    }
}
