<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSaveRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id', // Kiểm tra xem customer_id có tồn tại trong bảng customers không
            'product_id' => 'required|exists:products,id',   // Kiểm tra xem product_id có tồn tại trong bảng products không
            'quantity' => 'required|integer|min:1', // Kiểm tra quantity là số nguyên và phải lớn hơn hoặc bằng 1
            'note' => 'nullable|string', // Ghi chú có thể là chuỗi hoặc null // Kiểm tra status chỉ nhận các giá trị đã cho
        ];
    }
}
