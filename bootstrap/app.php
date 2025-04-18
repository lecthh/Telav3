<?php

use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\ProductionAdmin;
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
        $middleware->append([
            PreventBackHistory::class,
        ]);
        $middleware->alias([
            'ProductionAdminOnly' => ProductionAdmin::class,
            'CustomerOnly' => \App\Http\Middleware\Customer::class,
            'DesignerOnly' => \App\Http\Middleware\DesignerOnly::class,
            'SuperAdminOnly' => \App\Http\Middleware\SuperAdminOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
