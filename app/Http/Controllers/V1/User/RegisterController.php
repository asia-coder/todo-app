<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Services\V1\AuthService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, AuthService $authService): JsonResponse
    {
        $authToken = $authService->register($request->payload());

        return response()->json([
            'token' => $authToken->plainTextToken,
        ]);
    }
}
