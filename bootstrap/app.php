<?php

use App\Http\Middleware\AppLang;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SchoolIsActive;
use App\Http\Middleware\AddNgrokSkipHeader;
use App\Http\Middleware\RedirectBasedOnRole;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RedirectBasedOnRole::class,
            'school.active' => SchoolIsActive::class,
        ]);
        $middleware->web(append:[
            AppLang::class,
            AddNgrokSkipHeader::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
