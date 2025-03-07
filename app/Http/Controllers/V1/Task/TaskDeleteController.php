<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskDeleteController extends Controller
{
    public function __invoke(string $id, TaskService $taskService): Response
    {
        $taskService->delete($id, auth()->id());

        return response()->noContent();
    }
}
