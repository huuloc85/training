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
            'new_image' => 'required|image|mimes:jpeg,png,jpg,gif', // Bỏ qua kiểm tra kích thước tối đa.
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'name.required' => 'Vui lòng nhập tên của bạn.',
    //         'email.required' => 'Vui lòng nhập địa chỉ email của bạn.',
    //         'email.email' => 'Địa chỉ email không hợp lệ.',
    //         'new_image' => 'Vui lòng thêm ảnh.',
    //         'username.required' => 'Vui lòng nhập tên đăng nhập của bạn.',
    //         'role.required' => 'Vui lòng chọn vai trò của bạn.',
    //         'mobile.required' => 'Vui lòng nhập số điện thoại của bạn.',
    //         'new_image.image' => 'Tệp phải là ảnh.',
    //         'new_image.mimes' => 'Tệp ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
    //     ];
    // }
}
