<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StorePostRequest;
use App\Http\Requests\Api\V1\UpdatePostRequest;
use App\Http\Resources\Api\V1\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Get all posts
     *
     * Retrieve a paginated list of all published posts.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "My Post",
     *       "content": "Post content"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $posts = Post::with('user', 'category', 'tags')
            ->latest()
            ->paginate(15);
        return PostResource::collection($posts);
    }

    /**
     * Create a post
     *
     * @authenticated
     *
     * @bodyParam title string required The post title. Example: My Blog Post
     * @bodyParam content string required The post content.
     * @bodyParam status string The post status. Example: published
     *
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "title": "My Blog Post"
     *   }
     * }
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $post = Post::create($data);

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post->load('user', 'category', 'tags'));
    }

    /**
     * Update a post
     *
     * @urlParam post integer required The post ID. Example: 1
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "title": "Updated Title",
     *     "content": "Updated content"
     *   }
     * }
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $this->authorize('update', $post);

        $data = $request->validated();
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $post->update($data);

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.'
        ], 200);
    }
}
