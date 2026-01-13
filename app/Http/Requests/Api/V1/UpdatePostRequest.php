<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $postId = $this->route('post') ? $this->route('post')->id : null;

        return [
            'title' => 'sometimes|required|string|max:255',
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('posts', 'slug')->ignore($postId),
            ],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'sometimes|required|string',
            'featured_image' => 'nullable|url',
            'status' => 'sometimes|required|in:draft,published',
            'published_at' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    /**
     * Get the body parameters for documentation.
     */
    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'The title of the post.',
                'example' => 'Updated Blog Post Title',
            ],
            'slug' => [
                'description' => 'The URL-friendly version of the title.',
                'example' => 'updated-blog-post-title',
            ],
            'excerpt' => [
                'description' => 'A short excerpt of the post.',
                'example' => 'This is an updated brief summary of my blog post.',
            ],
            'content' => [
                'description' => 'The main content of the post.',
                'example' => 'Updated content goes here...',
            ],
            'featured_image' => [
                'description' => 'URL of the featured image for the post.',
                'example' => 'https://example.com/images/updated-featured-image.jpg',
            ],
            'status' => [
                'description' => 'The publication status of the post.',
                'example' => 'draft',
            ],
            'published_at' => [
                'description' => 'The date and time when the post was published.',
                'example' => '2024-07-01 14:00:00',
            ],
            'category_id' => [
                'description' => 'The ID of the category this post belongs to.',
                'example' => 3,
            ],
        ];
    }
}
