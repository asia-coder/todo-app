<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Services\V1\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class LoginController extends Controller
{
    #[OA\Post(
        path: "/v1/user/login",
        summary: "Авторизация",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(properties: [
                new OA\Property(property: "email", type: "string", example: "example@gmail.com"),
                new OA\Property(property: "password", type: "string"),
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
    /**
     * @throws ValidationException
     */
    public function __invoke(LoginRequest $request, AuthService $authService): JsonResponse
    {
        $accessToken = $authService->login($request->payload());

        return response()->json([
            'token' => $accessToken->plainTextToken
        ]);
    }
}
