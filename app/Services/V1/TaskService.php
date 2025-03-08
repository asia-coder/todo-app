<?php

namespace App\Services\V1;

use App\DTO\V1\Task\TaskCreateDTO;
use App\DTO\V1\Task\TaskListDTO;
use App\DTO\V1\Task\TaskUpdateDTO;
use App\Models\Task;
use App\Repositories\V1\TaskRepositoryInterface;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    )
    {}

    public function listByUserId(string $userId, TaskListDTO $taskListDTO): Collection
    {
        return $this->taskRepository->listByUserId($userId, $taskListDTO);
    }

    public function create(TaskCreateDTO $taskCreateDTO): Task
    {
        return $this->taskRepository->create($taskCreateDTO);
    }

    public function update(TaskUpdateDTO $taskUpdateDTO): Task
    {
        $task = $this->taskRepository->getById($taskUpdateDTO->id);

        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }

        if ($task->user_id !== $taskUpdateDTO->userId) {
            throw new AccessDeniedHttpException('You are not allowed to update this task');
        }

        return $this->taskRepository->update($taskUpdateDTO);
    }

    public function getTask(string $taskId, string $userId): Task
    {
        $task = $this->taskRepository->getById($taskId);

        if (!$task || $task->user_id !== $userId) {
            throw new NotFoundHttpException('Task not found');
        }

        return $task;
    }

    public function delete(string $taskId, string $userId): void
    {
        $task = $this->taskRepository->getById($taskId);

        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }

        if ($task->user_id !== $userId) {
            throw new AccessDeniedHttpException('You are not allowed to delete this task');
        }

        $this->taskRepository->delete($taskId);
    }
}
