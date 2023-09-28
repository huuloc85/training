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
            'mobile' => 'required|numeric',
            'new_image' => 'required|image|mimes:jpeg,png,jpg,gif', // Kiểm tra hình ảnh mới
        ];
    }
}
