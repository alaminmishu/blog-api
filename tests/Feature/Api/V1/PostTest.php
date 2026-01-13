<?php

namespace Tests\Feature\Api\V1;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_posts(): void
    {
        Post::factory(3)->create();

        $response = $this->getJson('/api/v1/posts');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_guests_can_view_single_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'title' => $post->title,
                ]
            ]);
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/posts', [
                'title' => 'Test Post',
                'content' => 'Test content',
                'status' => 'published',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'Test Post',
                ]
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'user_id' => $user->id,
        ]);
    }

    public function test_guests_cannot_create_post(): void
    {
        $response = $this->postJson('/api/v1/posts', [
            'title' => 'Test Post',
            'content' => 'Test content',
        ]);

        $response->assertStatus(401);
    }

    public function test_post_requires_title_and_content(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/posts', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content']);
    }
}
