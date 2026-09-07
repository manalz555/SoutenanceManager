<?php

namespace App\Http\Controllers;

use App\Models\etudiants;
use App\Models\professeurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Connexion unique pour les trois profils (étudiant, professeur, administrateur).
 * L'administrateur est un compte unique défini dans .env (ADMIN_EMAIL / ADMIN_PASSWORD).
 */
class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        $role = $request->query('role', 'etudiant');
        if (! in_array($role, ['etudiant', 'professeur', 'admin'], true)) {
            $role = 'etudiant';
        }

        return view('auth.login', compact('role'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'role'     => 'required|in:etudiant,professeur,admin',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        switch ($data['role']) {
            case 'admin':
                if ($data['email'] === config('soutenance.admin_email')
                    && $data['password'] === config('soutenance.admin_password')) {
                    $request->session()->regenerate();
                    session(['admin_logged_in' => true]);

                    return redirect()->route('admin.dashboard');
                }
                break;

            case 'professeur':
                $professeur = professeurs::where('email_prof', $data['email'])->first();
                if ($professeur && Hash::check($data['password'], $professeur->password_prof)) {
                    $request->session()->regenerate();
                    session(['professeur_id' => $professeur->id]);

                    return redirect()->route('professor.dashboard');
                }
                break;

            case 'etudiant':
                $etudiant = etudiants::where('email', $data['email'])->first();
                if ($etudiant && Hash::check($data['password'], $etudiant->password)) {
                    $request->session()->regenerate();
                    session(['etudiant_id' => $etudiant->id]);

                    return redirect()->route('etudiant.dashboard');
                }
                break;
        }

        return back()
            ->withInput($request->only('email', 'role'))
            ->withErrors(['email' => 'Identifiants invalides.']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_logged_in', 'professeur_id', 'etudiant_id']);
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Vous êtes déconnecté.');
    }
}
