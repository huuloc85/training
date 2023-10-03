<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'proName' => 'required|string|max:255',
            'proSlug' => 'required|string|max:255',
            'proDetail' => 'required|string',
            'proPrice' => 'required|numeric',
            'proQuantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id', // Kiểm tra xem category_id có tồn tại trong bảng categories không
            'new_image' => 'image|mimes:jpeg,png,jpg,gif', // Kiểm tra loại file
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif', // Kiểm tra loại file
        ];
    }
}
