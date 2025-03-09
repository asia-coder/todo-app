<?php

namespace Tests\Feature\Controllers\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_profile()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->getJson(self::API_V1 . '/user');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email']
            ]);

        $this->assertIsString($response['data']['id']);
        $this->assertIsString($response['data']['name']);
        $this->assertIsString($response['data']['email']);

        $this->assertEquals($user->id, $response['data']['id']);
    }
}
