<?php

namespace App\Repositories\V1;

use App\DTO\V1\Auth\RegisterDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(RegisterDTO $registerDTO): User;

    public function getByEmail(string $email): ?User;
}
