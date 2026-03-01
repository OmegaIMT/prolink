<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {

            $statusCode = 500;
            $message = 'Erro interno no servidor.';
            $errors = [];

            switch (true) {

                case $exception instanceof \Illuminate\Validation\ValidationException:
                    $statusCode = 422;
                    $message = 'Erro de validação.';
                    $errors = $exception->errors();
                    break;

                case $exception instanceof \Illuminate\Auth\AuthenticationException:
                    $statusCode = 401;
                    $message = 'Não autenticado.';
                    break;

                case $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException:
                    $statusCode = 404;
                    $message = 'Rota não encontrada.';
                    break;

                case $exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException:
                    $statusCode = 405;
                    $message = 'Método não permitido.';
                    break;

                case $exception instanceof \Exception:
                    $statusCode = 400;
                    $message = $exception->getMessage();
                    break;
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'data' => null,
                'errors' => $errors
            ], $statusCode);
        }

        return parent::render($request, $exception);
    }
}
