<?php

namespace Tests\Feature\Controllers\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $password = $this->faker->password(8);
        $user = $this->createUser([
            'password' => bcrypt($password)
        ]);

        $response = $this->postJson(self::API_V1 . '/user/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);

        $this->assertIsString($response['token']);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);
    }

    public function test_user_can_register()
    {
        $email = $this->faker->email;
        $password = $this->faker->password(8);

        $response = $this->postJson(self::API_V1 . '/user/register', [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);

        $this->assertIsString($response['token']);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);

        $user = User::where('email', $email)->first();
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);
    }

    public function test_user_can_logout()
    {
        $user = $this->createUser();
        $token = $user->createToken('test')->plainTextToken;

        // actingAs() выдает ошибку для logout, так как под капотом используется сессия(смотрим логику logout)
        $response = $this->withHeader(
            'Authorization',
            'Bearer ' . $token
        )->postJson(self::API_V1 . '/user/logout');

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);
    }
}
