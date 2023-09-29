<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|confirmed', // Thêm confirmed để kiểm tra mật khẩu nhập lại
            'mobile' => 'required|numeric', // Kiểu số
            'image' => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
