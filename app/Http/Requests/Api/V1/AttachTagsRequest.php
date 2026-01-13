<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class AttachTagsRequest extends FormRequest
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
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'exists:tags,id',
        ];
    }

    /**
     * Get the body parameters for documentation.
     */
    public function bodyParameters(): array
    {
        return [
            'tag_ids' => [
                'description' => 'An array of tag IDs to attach/detach/sync.',
                'example' => [1, 2, 3],
            ],
            'tag_ids.*' => [
                'description' => 'A tag ID.',
                'example' => 1,
            ],
        ];
    }
}
