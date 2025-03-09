<?php

namespace Tests\Feature\Controllers\V1;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TaskHelper;
use Tests\TestCase;

class TaskUpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_update_task()
    {
        $user = $this->createUser();
        $task = $user->tasks()->create(
            Task::factory()->make()->toArray()
        );

        $newTitle = $this->faker->sentence;
        $newDescription = $this->faker->paragraph;
        $newStatus = $this->faker->boolean ? TaskStatus::COMPLETED->value : TaskStatus::ACTIVE->value;

        $response = $this->actingAs($user)->putJson(self::API_V1 . '/task/' . $task->id, [
            'title' => $newTitle,
            'description' => $newDescription,
            'status' => $newStatus,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(TaskHelper::oneTaskResponseStructure());

        $this->assertEquals($newTitle, $response['data']['title']);
        $this->assertEquals($newDescription, $response['data']['description']);
        $this->assertEquals($newStatus, $response['data']['status']);
    }

    public function test_user_cannot_update_another_user_task()
    {
        $user = $this->createUser();
        $otherTask = $this->createUser()->tasks()->create(
            Task::factory()->make()->toArray()
        );

        $response = $this->actingAs($user)->putJson(self::API_V1 . '/task/' . $otherTask->id, [
            'title' => 'test',
            'description' => 'test',
            'status' => 'completed',
        ]);

        $response->assertStatus(403);
    }
}
