<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
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
            'name' => 'sometimes|string|max:50',
        ];
    }

    /**
     * Get the body parameters for documentation.
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the tag.',
                'example' => 'PHP',
            ],
        ];
    }
}
