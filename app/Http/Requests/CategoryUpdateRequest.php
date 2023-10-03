<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
            'catName' => 'required|string|unique|max:255',
            'catSlug' => 'required|string|unique:categories,catSlug,' . $this->route('catSlug') . ',catSlug|max:255',
            'new_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra loại file và kích thước tối đa
        ];
    }

    public function messages()
    {
        return [
            'catName.required' => 'Category name is required.',
            'catSlug.required' => 'Category slug is required.',
            'catSlug.unique' => 'Category slug must be unique.',
            'new_image.image' => 'The file must be an image.',
            'new_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        ];
    }
}
