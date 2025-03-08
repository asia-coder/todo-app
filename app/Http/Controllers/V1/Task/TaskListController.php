<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\TaskListRequest;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskListController extends Controller
{
    public function __invoke(TaskListRequest $request, TaskService $taskService): AnonymousResourceCollection
    {
        $taskList = $taskService->listByUserId(auth()->id(), $request->payload());

        return TaskResource::collection($taskList);
    }
}
