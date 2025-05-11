<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e, $request) {
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                $status = $e->getStatusCode();

                return match ($status) {
                    500, 503, 403, 404 => inertia()->render('Error', [
                        'status' => $status,
                        'message' => $e->getMessage() ?? '',
                    ])
                        ->toResponse($request)
                        ->setStatusCode($status),
                    419     => back()->setStatusCode(419)->with('Page Expired', 'Please refresh the page'),
                    default => null,
                };
            }

            return null;
        });

    })->create();
