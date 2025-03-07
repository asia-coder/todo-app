<?php

namespace App\Repositories\V1;

use App\DTO\V1\Auth\RegisterDTO;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create(RegisterDTO $registerDTO): User
    {
        return User::create([
            'name' => $registerDTO->name,
            'email' => $registerDTO->email,
            'password' => bcrypt($registerDTO->password)
        ]);
    }

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
