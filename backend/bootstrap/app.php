<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'auth.sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('*')) {
                return response()->json(
                    [
                        'error' => [
                            'message' => $e->getMessage()
                        ]
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
        });

        $exceptions->render(function (ValidationException $e) {

            return response()->json(
                [
                    'error' => [
                        'message' => $e->getMessage(),
                        'errors' => $e->errors()
                    ]
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        });
    })->create();
