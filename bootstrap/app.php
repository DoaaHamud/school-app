<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // استثناء الخروج فقط حتى لا يمنع انتهاء رمز CSRF إنهاء الجلسة.
        $middleware->validateCsrfTokens(except: ['logout']);

        // حل مشكلة التوجيه لمنع حلقة التكرار ERR_TOO_MANY_REDIRECTS
        $middleware->redirectTo(
            guests: '/login',
            users: function () {
                if (Auth::check()) {
                    return match (Auth::user()->role) {
                        'admin'   => route('admin.dashboard'),
                        'manager' => route('manager.dashboard'),
                        'teacher' => route('teacher.dashboard'),
                        default   => route('mother.dashboard'),
                    };
                }
                return route('login');
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
