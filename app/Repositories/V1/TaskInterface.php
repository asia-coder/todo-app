<?php

namespace App\Repositories\V1;

use App\DTO\V1\TaskCreateDTO;

interface TaskInterface
{
    public function all();
    public function create(TaskCreateDTO $taskCreate);
    public function update(TaskCreateDTO $taskUpdate);
    public function delete(int $id);
    public function show(int $id);
}
