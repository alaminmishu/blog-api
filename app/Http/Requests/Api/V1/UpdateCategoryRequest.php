<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],
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
                'example' => 'Updated Category Name',
            ],
            'slug' => [
                'description' => 'The URL-friendly version of the category name.',
                'example' => 'updated-category-name',
            ],
            'description' => [
                'description' => 'A description of the category (optional).',
                'example' => 'Updated description of the category.',
            ],
            'parent_id' => [
                'description' => 'The parent category ID for nested categories (optional).',
                'example' => 2,
            ],
        ];
    }
}
