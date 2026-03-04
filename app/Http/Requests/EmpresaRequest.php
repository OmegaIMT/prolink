<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmpresaRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:150',
            'tipo' => 'required|in:online,fisica,hibrida',
            'endereco_id' => 'nullable|exists:enderecos,id',
            'ativo' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome deve ter no máximo 150 caracteres.',
            'tipo.required' => 'O tipo é obrigatório.',
            'tipo.in' => 'O tipo deve ser online, fisica ou hibrida.',
            'endereco_id.exists' => 'Endereço inválido.',
            'ativo.boolean' => 'O campo ativo deve ser verdadeiro ou falso.'
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