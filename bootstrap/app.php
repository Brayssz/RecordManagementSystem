<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfNotApplicant;
use App\Http\Middleware\RedirectIfNotEmployee;
use App\Http\Middleware\RedirectIfNotEmployer;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'applicant' => RedirectIfNotApplicant::class,
            'employee' => RedirectIfNotEmployee::class,
            'employer' => RedirectIfNotEmployer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
