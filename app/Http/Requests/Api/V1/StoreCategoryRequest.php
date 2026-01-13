<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    /**
     * Get the body parameters for documentation.
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the category.',
                'example' => 'Technology',
            ],
            'description' => [
                'description' => 'A description of the category (optional).',
                'example' => 'Posts about technology and programming',
            ],
            'parent_id' => [
                'description' => 'The parent category ID for nested categories (optional).',
                'example' => null,
            ],
        ];
    }
}
