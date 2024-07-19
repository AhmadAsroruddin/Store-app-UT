<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Sesuaikan dengan kebijakan akses Anda jika diperlukan
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:category_products,name',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'The category name has already been taken.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation failed'
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
