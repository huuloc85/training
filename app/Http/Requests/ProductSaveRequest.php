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
        $categories_id = Category::all()->pluck('id')->toArray();
        return [
            'proName' => ['required', 'min:3', 'max:255'],
            'proSlug' => ['required', 'min:3', 'max:255', 'unique:products'],
            'proPrice' => ['required', 'numeric', 'min:10000', 'max:1000000000'],
            'proDetail' => ['required', 'min:3', 'max:200'],
            'proImage' => [],
            'proQuantity' => ['required', 'numeric', 'min:1', 'max:1000'],
            'category_id' => ['required', 'numeric', 'in:' . implode(',', $categories_id)],
        ];
    }
}
