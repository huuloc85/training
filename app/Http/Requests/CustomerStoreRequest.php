<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Xác định xem người dùng có được phép thực hiện yêu cầu này hay không.
        // Trong trường hợp kiểm tra xác thực của khách hàng, bạn có thể trả về true
        // nếu bạn muốn cho phép bất kỳ ai gửi yêu cầu này.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('customers', 'email'),
            ],
            'mobile' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customers', 'mobile'),
            ],
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'total_amount' => 'numeric', // Điều kiện cụ thể cho total_amount
        ];
    }
}
