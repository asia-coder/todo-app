<?php

namespace App\DTO\V1\Auth;

class RegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    )
    {
    }
}
