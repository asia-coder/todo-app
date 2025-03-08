<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Services\V1\TaskService;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class TaskDeleteController extends Controller
{
    #[OA\Delete(
        path: "/v1/task/{id}",
        summary: "Удалить задачу",
        security: [["bearerAuth" => []]],
        tags: ["Tasks"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ИД задачи",
                in: "path",
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Задача удалена"
            ),
            new OA\Response(
                response: 404,
                description: "Задача не найдена",
            ),
            new OA\Response(
                response: 401,
                description: "Пользователь не авторизован",
            ),
        ]
    )]
    public function __invoke(string $id, TaskService $taskService): Response
    {
        $taskService->delete($id, auth()->id());

        return response()->noContent();
    }
}
