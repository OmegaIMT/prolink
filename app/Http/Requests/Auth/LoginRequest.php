<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => 'required',
            'password' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'O campo login é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter 6 caracteres.'
        ];
    }    

    protected function failedValidation(Validator $validator)
    {
        $errors = collect();

        foreach ($validator->errors()->messages() as $field => $messages) {
            $errors->put($field, $messages[0]);
        }

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $errors->toArray()
        ], 422));
    }
}