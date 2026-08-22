<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $exception, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            return response()
                ->view('errors.404', [
                    'metaTitle' => 'Page Not Found | HilDes',
                    'metaDescription' => 'The page you are looking for could not be found.',
                    'metaKeywords' => '404, page not found, hildes',
                    'metaRobots' => 'noindex,nofollow',
                    'canonicalUrl' => url()->current(),
                ], 404)
                ->header('X-Robots-Tag', 'noindex, nofollow');
        });
    })->create();
