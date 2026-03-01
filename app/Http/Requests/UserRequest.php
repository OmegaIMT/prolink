<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'username' => [
                'required',
                'max:15',
                Rule::unique('users', 'username')->ignore($this->route('id'))
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('id'))
            ],
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|min:8|max:255';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['password'] = 'nullable|min:8|max:255';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'username.max' => 'O usuário não pode ter mais de :max caracteres.',
            'username.required' => 'O usuário é obrigatório.',
            'username.unique' => 'Este usuário já está em uso.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Por favor, forneça um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
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