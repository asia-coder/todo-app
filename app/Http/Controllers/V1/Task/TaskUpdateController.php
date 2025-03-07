<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\TaskUpdateRequest;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;

class TaskUpdateController extends Controller
{
    public function __invoke(TaskUpdateRequest $request, TaskService $taskService): TaskResource
    {
        $task = $taskService->update($request->payload());

        return new TaskResource($task);
    }
}
