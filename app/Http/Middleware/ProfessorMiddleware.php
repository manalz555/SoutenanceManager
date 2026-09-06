<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\professeurs;

class ProfessorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('professeur_id') || !Session::get('professeur_id')) {
            return redirect()->route('professor.login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        $professeur = professeurs::find(Session::get('professeur_id'));
        
        if (!$professeur) {
            Session::forget('professeur_id');
            return redirect()->route('professor.login')
                ->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        // Ajouter le professeur à la requête pour y avoir accès dans les contrôleurs
        $request->merge(['professeur' => $professeur]);
        view()->share('currentProfessor', $professeur);

        return $next($request);
    }
}
