<?php

namespace App\Http\Controllers\Api\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected function success($data = null, string $message = 'Operação realizada com sucesso.', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => []
        ], $code);
    }

    protected function error(string $message = 'Erro na requisição.', array $errors = [], int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ], $code);
    }
}