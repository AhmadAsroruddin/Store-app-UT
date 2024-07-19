<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Sesuaikan dengan kebijakan akses Anda jika diperlukan
    }

    public function rules()
    {
        $categoryId = $this->route('id'); // Ambil ID dari rute
        return [
            'name' => 'required|string|max:255|unique:category_products,name,' . $categoryId,
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
