<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UserResource"
)]
class UserResource extends JsonResource
{
    #[OA\Property(property: "id", type: "string", example: "9e61f8ce-7994-4d5a-ae5a-87c81dab378a")]
    #[OA\Property(property: "name", type: "string", example: "John Smith")]
    #[OA\Property(property: "email", type: "string", example: "admin@gmail.com")]

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
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
