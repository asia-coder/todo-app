<?php

namespace App\DTO\V1\Task;

class TaskCreateDTO
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $userId
    )
    {}
}
