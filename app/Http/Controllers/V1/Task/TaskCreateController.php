<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\TaskCreateRequest;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;
use OpenApi\Attributes as OA;

class TaskCreateController extends Controller
{
    #[OA\Post(
        path: "/v1/task",
        summary: "Создать задачу",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(properties: [
                new OA\Property(property: "title", type: "string"),
                new OA\Property(property: "description", type: "string", nullable: true),
            ])
        ),
        tags: ["Tasks"],
        responses: [
            new OA\Response(
                response: 201,
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
            )
        ]
    )]
    public function __invoke(TaskCreateRequest $request, TaskService $taskService): TaskResource
    {
        $task = $taskService->create($request->payload());

        return new TaskResource($task);
    }
}
