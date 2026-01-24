<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        //
    }

    public function render($request, Throwable $e)
    {
        // Handle API route not found
        if ($e instanceof NotFoundHttpException && $request->is('api/*')) {
            return response()->json([
                'status' => false,
                'message' => 'API Route not found'
            ], 404);
        }

        return parent::render($request, $e);
    }
}
