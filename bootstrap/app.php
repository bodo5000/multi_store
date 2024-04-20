<?php

use App\Http\Middleware\UserLastActiveAt;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.type' => \App\Http\Middleware\CheckUserType::class,
        ]);

        $middleware->web(append: [
            UserLastActiveAt::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
