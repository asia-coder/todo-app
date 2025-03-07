<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\TaskCreateRequest;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;

class TaskCreateController extends Controller
{
    public function __invoke(TaskCreateRequest $request, TaskService $taskService): TaskResource
    {
        $task = $taskService->create($request->payload());

        return new TaskResource($task);
    }
}
