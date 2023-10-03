<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInforRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255',
            'role' => 'required|integer', // Điều chỉnh quy tắc kiểm tra theo loại dữ liệu của role.
            'mobile' => 'required|string|max:255',
            // Bỏ qua kiểm tra kích thước tối đa.
        ];
        if ($this->filled('new_image')) {
            $rules['new_image'] = 'required|image|mimes:jpeg,png,jpg,gif';
        }

        return $rules;
    }
}
