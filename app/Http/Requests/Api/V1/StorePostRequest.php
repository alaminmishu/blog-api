<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * Get the body parameters for the API documentation.
     *
     * @return array
     */
    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'The title of the post.',
                'example' => 'My First Blog Post',
            ],
            'excerpt' => [
                'description' => 'A short excerpt of the post.',
                'example' => 'This is a brief summary of my first blog post.',
            ],
            'content' => [
                'description' => 'The main content of the post.',
                'example' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
            ],
            'status' => [
                'description' => 'The publication status of the post.',
                'example' => 'published',
            ],
            'published_at' => [
                'description' => 'The date and time when the post was published.',
                'example' => '2024-06-15 10:00:00',
            ],
        ];
    }
}
