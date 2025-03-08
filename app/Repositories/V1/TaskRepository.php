<?php

namespace App\Repositories\V1;

use App\DTO\V1\Task\TaskCreateDTO;
use App\DTO\V1\Task\TaskListDTO;
use App\DTO\V1\Task\TaskUpdateDTO;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function listByUserId(string $userId, TaskListDTO $taskListDTO): Collection
    {
        if ($taskListDTO->searchQuery) {
            $taskQuery = Task::search($taskListDTO->searchQuery)
                ->take(100); // защита от дурака, да здравствует пагинация
        } else {
            $taskQuery = Task::query()
                ->limit(100); // защита от дурака, да здравствует пагинация
        }

        return $taskQuery
            ->where('user_id', $userId)
            ->when($taskListDTO->filter, function ($query, $filter) {
                if (isset($filter['status'])) {
                    $query->where('status', $filter['status']);
                }

                return $query;
            })
            ->when($taskListDTO->sortBy, function ($query, $sortBy) use ($taskListDTO) {
                $query->orderBy($sortBy, $taskListDTO->sortOrder);
            })
            ->get();
    }

    public function create(TaskCreateDTO $taskCreate): Task
    {
        return Task::create([
            'title' => $taskCreate->title,
            'description' => $taskCreate->description,
            'user_id' => $taskCreate->userId,
            'status' => TaskStatus::ACTIVE->value
        ]);
    }

    public function update(TaskUpdateDTO $taskUpdate): Task
    {
        Task::where('id', $taskUpdate->id)->update([
            'title' => $taskUpdate->title,
            'description' => $taskUpdate->description,
            'status' => $taskUpdate->status
        ]);

        return $this->getById($taskUpdate->id);
    }

    public function delete(string $id)
    {
        Task::destroy($id);
    }

    public function getById(string $id): ?Task
    {
        return Task::find($id);
    }
}
