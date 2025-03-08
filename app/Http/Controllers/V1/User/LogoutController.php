<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class LogoutController extends Controller
{
    #[OA\Post(
        path: "/v1/user/logout",
        summary: "Logout",
        security: [["bearerAuth" => []]],
        tags: ["User"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Пользователь разлогинен",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Logged out successfully"
                        )
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
    public function __invoke(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
