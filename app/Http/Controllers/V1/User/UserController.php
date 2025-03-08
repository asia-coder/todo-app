<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Resources\V1\UserResource;
use OpenApi\Attributes as OA;

class UserController
{
    #[OA\Get(
        path: "/v1/user",
        summary: "Получить профиль пользователя",
        security: [["bearerAuth" => []]],
        tags: ["User"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Пользователь",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/UserResource",
                            type: "object"
                        ),
                    ],
                    type: "object"
                )
            ),
            new OA\Response(
                response: 401,
                description: "Пользователь не авторизован",
            ),
        ]
    )]
    public function __invoke()
    {
        return new UserResource(auth()->user());
    }

    public function update()
    {
        // тут будет обновление данных пользователя... может быть :)
    }
}
