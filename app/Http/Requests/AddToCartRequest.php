<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CategoryItem;

class AddToCartRequest extends FormRequest
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
        $totalQuantity = CategoryItem::findOrFail($this->product_id)->quantity;
        return [
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|gte:1|lte:'.$totalQuantity
        ];
    }
}
