<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // or add your authorization logic here
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6'
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

