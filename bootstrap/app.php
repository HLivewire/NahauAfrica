<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust the load balancer in front of the app (Laravel Cloud / proxies).
        $middleware->trustProxies(at: '*');

        // Route middleware alias used by the admin area: role:super-admin,admin,...
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'nlocale' => \App\Http\Middleware\SetNahauLocale::class,
        ]);

        // Guests are sent to the admin login page (same behaviour as before).
        $middleware->redirectGuestsTo(fn (Request $request) => route('login'));
        $middleware->redirectUsersTo('/');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Keep the original JSON error format for the mobile API.
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Record not found.',
                    'status' => false,
                ], 404);
            }
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'errors' => $e->errors(),
                    'status' => false,
                ], $e->status);
            }
        });
    })->create();
