<?php

namespace App\Repositories\V1;

use App\DTO\V1\Task\TaskCreateDTO;
use App\DTO\V1\Task\TaskUpdateDTO;
use App\Models\Task;
use Illuminate\Support\Collection;

/**
 * тут в идеале не должно быть зависимости от моделей, но для тестового задания думаю пойдет
 */
interface TaskRepositoryInterface
{
    /**
     * @return Collection<Task>
     */
    public function listByUserId(string $userId): Collection;
    public function create(TaskCreateDTO $taskCreate): Task;
    public function update(TaskUpdateDTO $taskUpdate): Task;
    public function delete(string $id);
    public function getById(string $id): ?Task;
}
