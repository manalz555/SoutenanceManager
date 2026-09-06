<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EtudiantAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('etudiant_id')) {
            return redirect()->route('etudiant.login');
        }

        return $next($request);
    }
}
