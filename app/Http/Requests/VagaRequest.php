<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VagaRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'empresa_id' => 'required|exists:empresas,id',
            'titulo' => 'required|string|max:150',
            'descricao' => 'required|string',
            'salario' => 'nullable|numeric|min:0',
            'modalidade' => 'required|in:presencial,remoto,hibrido',
            'data_publicacao' => 'nullable|date',
            'ativo' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'empresa_id.required' => 'A empresa é obrigatória.',
            'empresa_id.exists' => 'Empresa inválida.',
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título deve ter no máximo 150 caracteres.',
            'descricao.required' => 'A descrição é obrigatória.',
            'salario.numeric' => 'O salário deve ser numérico.',
            'salario.min' => 'O salário não pode ser negativo.',
            'modalidade.required' => 'A modalidade é obrigatória.',
            'modalidade.in' => 'A modalidade deve ser presencial, remoto ou hibrido.',
            'data_publicacao.date' => 'A data de publicação é inválida.',
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