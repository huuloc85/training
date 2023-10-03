<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Sử dụng Rule::unique để kiểm tra email và mobile không trùng với các khách hàng khác (loại trừ khách hàng hiện tại)
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($this->customer),
            ],
            'mobile' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customers', 'mobile')->ignore($this->customer),
            ],
            'address' => 'required|string|max:255',
        ];
    }
}
