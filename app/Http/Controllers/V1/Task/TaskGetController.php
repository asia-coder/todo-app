<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;

class TaskGetController extends Controller
{
    public function __invoke(string $id, TaskService $taskService): TaskResource
    {
        $task = $taskService->getTask($id, auth()->id());

        return new TaskResource($task);
    }
}
