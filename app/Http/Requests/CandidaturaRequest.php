<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CandidaturaRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'vaga_id' => 'required|exists:vagas,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'link_acompanhamento' => 'nullable|string',
            'salario_proposto' => 'nullable|numeric|min:0',
            'data_aplicacao' => 'required|date',
            'status' => 'nullable|in:aplicado,entrevista,proposta,aprovado,recusado',
            'observacao' => 'nullable|string',
            'beneficios' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'vaga_id.required' => 'A vaga é obrigatória.',
            'vaga_id.exists' => 'Vaga inválida.',
            'profissional_id.required' => 'O profissional é obrigatório.',
            'profissional_id.exists' => 'Profissional inválido.',
            'data_aplicacao.required' => 'A data de aplicação é obrigatória.',
            'status.in' => 'Status inválido.'
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