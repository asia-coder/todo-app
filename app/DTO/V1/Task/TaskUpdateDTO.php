<?php

namespace App\DTO\V1\Task;

use App\Enums\TaskStatus;

class TaskUpdateDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $status,
        public readonly string $userId
    )
    {}
}
