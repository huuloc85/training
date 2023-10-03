<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . $this->id, // Đảm bảo không trùng với email của người dùng khác có id khác
            'username' => 'required|string|unique:users,username,' . $this->id, // Đảm bảo không trùng với username của người dùng khác có id khác
            'mobile' => 'required|unique:users,mobile,' . $this->id, // Đảm bảo không trùng với số điện thoại của người dùng khác có id khác
        ];
        // Kiểm tra nếu 'new_image' đã được điền, thì áp dụng quy tắc cho nó
        if ($this->filled('new_image')) {
            $rules['new_image'] = 'required|image|mimes:jpeg,png,jpg,gif';
        }

        return $rules;
    }
}
