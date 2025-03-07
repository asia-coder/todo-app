<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Resources\V1\UserResource;

class UserController
{
    public function __invoke()
    {
        return new UserResource(auth()->user());
    }

    public function update()
    {
        // тут будет обновление данных пользователя... может быть :)
    }
}
