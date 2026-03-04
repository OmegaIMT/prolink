<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfissionalRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:150',
            'funcao' => 'required|string|max:150',
            'endereco_id' => 'nullable|exists:enderecos,id',
            'contato_id' => 'nullable|exists:contatos,id',
            'ativo' => 'nullable|in:S,N'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'funcao.required' => 'A função é obrigatória.',
            'endereco_id.exists' => 'Endereço inválido.',
            'contato_id.exists' => 'Contato inválido.',
            'ativo.in' => 'O campo ativo deve ser S ou N.'
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
            'errors' => $errors->toArray()
        ], 422));
    }
}