<?php

namespace App\Repositories\V1;

use App\DTO\V1\Task\TaskCreateDTO;
use App\DTO\V1\Task\TaskUpdateDTO;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function listByUserId(string $userId): Collection
    {
        return Task::query()
            ->where('user_id', $userId)
            ->limit(500) // защита от дурака, да здравствует пагинация
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
