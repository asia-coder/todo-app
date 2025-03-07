<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Services\V1\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
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
