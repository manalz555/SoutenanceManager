<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EtudiantAuthMiddleware;
use App\Http\Middleware\ProfessorMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin'         => AdminMiddleware::class,
            'professor'     => ProfessorMiddleware::class,
            'etudiant.auth' => EtudiantAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
