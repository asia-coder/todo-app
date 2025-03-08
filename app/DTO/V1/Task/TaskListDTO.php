<?php

namespace App\DTO\V1\Task;

class TaskListDTO
{
    public function __construct(
        public readonly array $filter,
        public readonly string $sortBy,
        public readonly string $sortOrder,
        public readonly ?string $searchQuery
    )
    {}
}
