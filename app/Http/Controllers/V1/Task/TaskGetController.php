<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;
use OpenApi\Attributes as OA;

class TaskGetController extends Controller
{
    #[OA\Get(
        path: "/v1/task/{id}",
        summary: "Получить задачу по ИД",
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
                response: 200,
                description: "Задача",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/TaskResource",
                            type: "object"
                        ),
                    ],
                    type: "object"
                )
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
    public function __invoke(string $id, TaskService $taskService): TaskResource
    {
        $task = $taskService->getTask($id, auth()->id());

        return new TaskResource($task);
    }
}
