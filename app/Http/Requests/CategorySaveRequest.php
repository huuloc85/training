<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategorySaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'catName' => 'required|string|max:255',
            'catSlug' => 'required|string|max:255',
            'catImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra loại file và kích thước tối đa
        ];
    }

    public function messages()
    {
        return [
            'catName.required' => 'Category name is required.',
            'catSlug.required' => 'Category slug is required.',
            'catImage.required' => 'Category image is required.',
            'catImage.image' => 'The file must be an image.',
            'catImage.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('catName', Rule::unique('categories', 'catName')->ignore($this->route('catSlug'), 'catSlug'), function ($input) {
            return true;
        });
    }
}
