<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AttachTagsRequest;
use App\Http\Resources\Api\V1\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostTagController extends Controller
{
    /**
     * Attach tags to post
     */
    public function attach(AttachTagsRequest $request, Post $post): PostResource
    {
        $post->tags()->attach($request->tag_ids);

        return new PostResource($post->load('tags'));
    }

    /**
     * Detach tags from post
     */
    public function detach(AttachTagsRequest $request, Post $post): PostResource
    {
        $post->tags()->detach($request->tag_ids);

        return new PostResource($post->load('tags'));
    }

    /**
     * Sync tags (replace all)
     */
    public function sync(AttachTagsRequest $request, Post $post): PostResource
    {
        $post->tags()->sync($request->tag_ids);

        return new PostResource($post->load('tags'));
    }

    /**
     * Get all tags for a post
     */
    public function index(Post $post): JsonResponse
    {
        return response()->json([
            'data' => $post->tags
        ]);
    }
}
