<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'email' => ['required', 'email', 'min:11', 'max:50'],
            'password' => ['required', 'min:3', 'max:200'],
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'email.required' => 'Vui lòng nhập địa chỉ email.',
    //         'email.email' => 'Địa chỉ email không hợp lệ.',
    //         'password.required' => 'Vui lòng nhập mật khẩu.',
    //     ];
    // }
}
