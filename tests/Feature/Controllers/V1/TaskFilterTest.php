<?php

namespace Tests\Feature\Controllers\V1;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TaskHelper;
use Tests\TestCase;

class TaskFilterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_filter_tasks_by_status()
    {
        $user = $this->createUser();
        $user->tasks()->createMany(
            Task::factory(3)->make([
                'status' => TaskStatus::ACTIVE->value
            ])->toArray()
        );

        $completedTask = $user->tasks()->create(
            Task::factory()->make([
                'status' => TaskStatus::COMPLETED->value
            ])->toArray()
        );

        $queryString = http_build_query([
            'filter' => [
                'status' => TaskStatus::COMPLETED->value
            ]
        ]);
        $response = $this->actingAs($user)->getJson(self::API_V1 . '/task/list?' . $queryString);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure(TaskHelper::listResponseStructure());

        $this->assertIsString($response['data'][0]['id']);
        $this->assertIsString($response['data'][0]['title']);
        $this->assertIsString($response['data'][0]['status']);
        $this->assertIsString($response['data'][0]['created_at']);
        $this->assertIsString($response['data'][0]['updated_at']);

        $this->assertEquals($completedTask->id, $response['data'][0]['id']);
    }

    public function test_user_can_sort_tasks_by_status_desc()
    {
        $user = $this->createUser();
        $activeTask = $user->tasks()->create(
            Task::factory()->make([
                'status' => TaskStatus::ACTIVE->value
            ])->toArray()
        );

        $completedTask = $user->tasks()->create(
            Task::factory()->make([
                'status' => TaskStatus::COMPLETED->value
            ])->toArray()
        );

        $queryString = http_build_query([
            'sort_by' => 'status',
            'sort_order' => 'desc'
        ]);
        $response = $this->actingAs($user)->getJson(self::API_V1 . '/task/list?' . $queryString);

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(TaskHelper::listResponseStructure());

        $this->assertEquals($completedTask->id, $response['data'][0]['id']);
        $this->assertEquals($activeTask->id, $response['data'][1]['id']);
    }

    public function test_user_can_sort_tasks_by_status_asc()
    {
        $user = $this->createUser();
        $activeTask = $user->tasks()->create(
            Task::factory()->make([
                'status' => TaskStatus::ACTIVE->value
            ])->toArray()
        );

        $completedTask = $user->tasks()->create(
            Task::factory()->make([
                'status' => TaskStatus::COMPLETED->value
            ])->toArray()
        );

        $queryString = http_build_query([
            'sort_by' => 'status',
            'sort_order' => 'asc'
        ]);
        $response = $this->actingAs($user)->getJson(self::API_V1 . '/task/list?' . $queryString);

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(TaskHelper::listResponseStructure());

        $this->assertEquals($activeTask->id, $response['data'][0]['id']);
        $this->assertEquals($completedTask->id, $response['data'][1]['id']);
    }

    public function test_user_can_search_tasks_from_title()
    {
        $user = $this->createUser();
        $searchTask = $user->tasks()->create(
            Task::factory()->make([
                'title' => 'Task Yellow'
            ])->toArray()
        );

        $user->tasks()->create(
            Task::factory()->make([
                'title' => 'Task Blue'
            ])->toArray()
        );

        $queryString = http_build_query([
            'search_query' => 'yellow'
        ]);
        $response = $this->actingAs($user)->getJson(self::API_V1 . '/task/list?' . $queryString);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure(TaskHelper::listResponseStructure());

        $this->assertEquals($searchTask->id, $response['data'][0]['id']);
    }

    public function test_user_can_search_tasks_from_description()
    {
        $user = $this->createUser();
        $searchTask = $user->tasks()->create(
            Task::factory()->make([
                'description' => 'Task description laravel'
            ])->toArray()
        );

        $user->tasks()->create(
            Task::factory()->make([
                'description' => 'Task description - PHP'
            ])->toArray()
        );

        $queryString = http_build_query([
            'search_query' => 'Laravel'
        ]);
        $response = $this->actingAs($user)->getJson(self::API_V1 . '/task/list?' . $queryString);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure(TaskHelper::listResponseStructure());

        $this->assertEquals($searchTask->id, $response['data'][0]['id']);
    }
}
