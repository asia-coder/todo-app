<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Services\V1\AuthService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class RegisterController extends Controller
{
    #[OA\Post(
        path: "/v1/user/register",
        summary: "Регистрация",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(properties: [
                new OA\Property(property: "name", type: "string", example: "John Doe"),
                new OA\Property(property: "email", type: "string", example: "example@gmail.com"),
                new OA\Property(property: "password", type: "string"),
                new OA\Property(property: "password_confirmation", type: "string"),
            ])
        ),
        tags: ["User"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Токен пользователя",
                content: new OA\JsonContent(ref: "#/components/schemas/AuthTokenResource",)
            ),
            new OA\Response(
                response: 422,
                description: "Validation errors",
            ),
        ]
    )]
    public function __invoke(RegisterRequest $request, AuthService $authService): JsonResponse
    {
        $authToken = $authService->register($request->payload());

        return response()->json([
            'token' => $authToken->plainTextToken,
        ]);
    }
}
