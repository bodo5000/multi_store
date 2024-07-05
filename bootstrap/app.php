<?php

use App\Http\Middleware\CheckApiToken;
use App\Http\Middleware\MarkNotificationAsReaded;
use App\Http\Middleware\SetAppLocal;
use App\Http\Middleware\UserLastActiveAt;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        channels: __DIR__ . '/../routes/channels.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.type' => \App\Http\Middleware\CheckUserType::class,
        ]);

        $middleware->api(
            append: [
                CheckApiToken::class
            ]
        );

        $middleware->web(append: [
            UserLastActiveAt::class,
            MarkNotificationAsReaded::class,
            SetAppLocal::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (QueryException $e, $request) {
            if ($e->getCode() == 23000) {
                $message = 'can\'t delete the category cause it has products please delete all related products first';
            } else {
                $message = 'there is some thing miss';
            }
            return redirect()->back()->withInput()->withErrors(
                [
                    'message' => $e->getMessage()
                ]
            )->with('info', $message);
        });

        $exceptions->reportable(function (QueryException $e) {
            if ($e->getCode() == 23000) {
                Log::channel('sql')->warning($e->getMessage());
                return false;
            }
            return true;
        });
    })->create();
