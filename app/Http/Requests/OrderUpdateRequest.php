<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'order_date' => 'required|date', // Kiểm tra order_date là một ngày hợp lệ
            'total_amount' => 'required|numeric|min:0', // Kiểm tra total_amount là số và không âm
        ];
    }
}
