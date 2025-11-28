<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    $middleware->alias('superadmin', \App\Http\Middleware\Permission\SuperAdmin::class);
    $middleware->alias('cashier', \App\Http\Middleware\Permission\Cashier::class);
    $middleware->alias('kitchen', \App\Http\Middleware\Permission\Kitchen::class);
    $middleware->alias('branch_supervisor', \App\Http\Middleware\Permission\BranchSupervisor::class);
    $middleware->alias('waiter', \App\Http\Middleware\Permission\Waiter::class);

    

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
