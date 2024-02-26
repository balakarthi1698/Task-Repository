<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreateCategoryRequest extends FormRequest
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
            'category_name' => 'required|string',
            'new_category_name' => 'nullable|string',
            'item_name' => 'required|string',
            'item_image' => ['nullable', File::image()->types(['jpg', 'jpeg', 'png', 'svg', 'webp'])],
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ];
    }
}
