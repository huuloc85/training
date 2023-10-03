<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class ProductSaveRequest extends FormRequest
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
            'proSlug' => 'required|string|unique:products,proSlug|max:255',
            'proPrice' => 'required|numeric|min:0',
            'proDetail' => 'required|string',
            'proQuantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            // Kiểm tra loại file và kích thước tối đa cho nhiều hình ảnh
        ];
    }
}
