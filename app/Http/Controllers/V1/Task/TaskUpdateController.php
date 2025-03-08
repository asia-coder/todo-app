<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\TaskUpdateRequest;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;
use OpenApi\Attributes as OA;

class TaskUpdateController extends Controller
{
    #[OA\Put(
        path: "/v1/task/{id}",
        summary: "Обновить задачу",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(properties: [
                new OA\Property(property: "title", type: "string"),
                new OA\Property(property: "description", type: "string", nullable: true),
                new OA\Property(property: "status", type: "string", enum: ["active", "completed"]),
            ])
        ),
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
    public function __invoke(TaskUpdateRequest $request, TaskService $taskService): TaskResource
    {
        $task = $taskService->update($request->payload());

        return new TaskResource($task);
    }
}
