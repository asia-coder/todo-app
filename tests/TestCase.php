<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public const API_V1 = '/api/v1';

    use CreatesApplication;

    public function createUser($attributes = []): User
    {
        return User::factory()->create($attributes);
    }
}
