<?php

namespace App\DTO\V1\Auth;

class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password
    )
    {
    }
}
