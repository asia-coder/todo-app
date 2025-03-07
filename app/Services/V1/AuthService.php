<?php

namespace App\Services\V1;

use App\DTO\V1\Auth\LoginDTO;
use App\DTO\V1\Auth\RegisterDTO;
use App\Repositories\V1\UserRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    )
    {}

    /**
     * @throws ValidationException
     */
    public function login(LoginDTO $loginDTO): NewAccessToken
    {
        $user = $this->userRepository->getByEmail($loginDTO->email);

        if (!$user || !password_verify($loginDTO->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.'
            ]);
        }

        // $user->tokens()->delete(); // расскомментировать, если нужно, чтобы у пользователя был только один токен

        return $user->createToken('auth');
    }

    public function register(RegisterDTO $registerDTO): NewAccessToken
    {
        $user = $this->userRepository->create($registerDTO);

        return $user->createToken('auth');
    }
}
