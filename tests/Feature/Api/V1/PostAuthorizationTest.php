<?php

namespace Tests\Feature\Api\V1;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_update_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->putJson("/api/v1/posts/{$post->id}", [
                'title' => 'Updated Title',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_non_owner_cannot_update_post(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)
            ->putJson("/api/v1/posts/{$post->id}", [
                'title' => 'Hacked Title',
            ]);

        $response->assertStatus(403);
    }

    public function test_owner_can_delete_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->deleteJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_non_owner_cannot_delete_post(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)
            ->deleteJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_any_post(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $owner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($admin)
            ->deleteJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
