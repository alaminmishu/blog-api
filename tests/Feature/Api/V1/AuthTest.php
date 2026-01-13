<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_admin' => false,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['user', 'access_token']);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'token']);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/v1/logout');

        $response->assertStatus(200);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_user_can_get_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/v1/me');

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                ]
            ]);
    }
}
