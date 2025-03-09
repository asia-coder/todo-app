<?php

namespace Tests\Feature\Controllers\V1;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskDeleteTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_delete_task()
    {
        $user = $this->createUser();
        $task = $user->tasks()->create(
            Task::factory()->make()->toArray()
        );

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id
        ]);

        $response = $this->actingAs($user)->deleteJson(self::API_V1 . '/task/' . $task->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    public function test_user_cannot_delete_task_of_other_user()
    {
        $user = $this->createUser();
        $otherTask = Task::factory()->create();

        $response = $this->actingAs($user)->deleteJson(self::API_V1 . '/task/' . $otherTask->id);

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', [
            'id' => $otherTask->id,
            'user_id' => $otherTask->user_id,
        ]);
    }

    public function test_unauthenticated_user_cannot_delete_task()
    {
        $response = $this->deleteJson(self::API_V1 . '/task/' . $this->faker->uuid);

        $response->assertStatus(401);
    }

    public function test_user_cannot_delete_not_found_task()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->deleteJson(self::API_V1 . '/task/' . $this->faker->uuid);

        $response->assertStatus(404);
    }
}
