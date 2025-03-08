<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "TaskResource"
)]
class TaskResource extends JsonResource
{
    #[OA\Property(property: "id", type: "string", example: "9e61f8ce-7994-4d5a-ae5a-87c81dab378a")]
    #[OA\Property(property: "title", type: "string", example: "Task #1")]
    #[OA\Property(property: "description", type: "string", example: "Description of task #1")]
    #[OA\Property(property: "status", type: "string", enum: ["active", "completed"], example: "active")]
    #[OA\Property(property: "created_at", type: "string", format: "date-time", example: "2021-10-10 10:00:00")]
    #[OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2021-10-10 10:00:00")]

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function toResponse($request)
    {
        $status = $this->wasRecentlyCreated ? 201 : 200;

        return response()->json([
            'data' => $this->toArray($request)
        ], $status);
    }
}
