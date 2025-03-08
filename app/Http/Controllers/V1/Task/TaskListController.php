<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\TaskListRequest;
use App\Http\Resources\V1\TaskResource;
use App\Services\V1\TaskService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class TaskListController extends Controller
{
    #[OA\Get(
        path: "/v1/task/list",
        summary: "Получить список задач",
        security: [["bearerAuth" => []]],
        tags: ["Tasks"],
        parameters: [
            new OA\Parameter(
                name: "filter[status]",
                description: "Фильтр по статусу задачи (active, completed)",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string", enum: ["active", "completed"])
            ),
            new OA\Parameter(
                name: "sort_by",
                description: "Поле для сортировки",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string", enum: ["created_at", "status"])
            ),
            new OA\Parameter(
                name: "sort_order",
                description: "Порядок сортировки",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string", enum: ["asc", "desc"])
            ),
            new OA\Parameter(
                name: "search_query",
                description: "Поисковый запрос по задачам.",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список задач",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/TaskResource")
                        ),
                    ],
                    type: "object"
                )
            )
        ]
    )]
    public function __invoke(TaskListRequest $request, TaskService $taskService): AnonymousResourceCollection
    {
        $taskList = $taskService->listByUserId(auth()->id(), $request->payload());

        return TaskResource::collection($taskList);
    }
}
