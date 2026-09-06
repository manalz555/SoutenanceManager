<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\etudiants;

class EtudiantAuthMiddleware
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
        if (!Session::has('etudiant_id') || !Session::get('etudiant_id')) {
            return redirect()->route('etudiant.login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        $etudiant = etudiants::find(Session::get('etudiant_id'));
        
        if (!$etudiant) {
            Session::forget('etudiant_id');
            return redirect()->route('etudiant.login')
                ->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        // Ajouter l'étudiant à la requête pour y avoir accès dans les contrôleurs
        $request->merge(['etudiant' => $etudiant]);
        view()->share('currentEtudiant', $etudiant);

        return $next($request);
    }
}
