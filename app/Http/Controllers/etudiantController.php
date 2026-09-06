<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\etudiants;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class etudiantController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('etudiant.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $etudiant = etudiants::where('email', $request->email)->first();

        if ($etudiant && Hash::check($request->password, $etudiant->password)) {
            session(['etudiant_id' => $etudiant->id]);
            return redirect()->route('etudiant.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Show registration form
    public function showRegister()
    {
        return view('etudiant.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:etudiants',
            'password' => 'required|string|min:8|confirmed',
            'date_naissance' => 'required|date',
        ]);

        $etudiant = etudiants::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'date_naissance' => $validated['date_naissance'],
        ]);

        auth()->login($etudiant);
        return redirect()->route('etudiant.dashboard');
    }

    // Logout
    public function logout()
    {
        session()->forget('etudiant_id');
        return redirect()->route('etudiant.login');
    }

    // Dashboard
    public function dashboard()
    {
        $etudiant = $this->getAuthenticatedEtudiant();
        if (!$etudiant) {
            return redirect()->route('etudiant.login');
        }
        
        return view('etudiant.dashboard', compact('etudiant'));
    }
    
    // File upload for depot
    public function depot(Request $request)
    {
        $etudiant = $this->getAuthenticatedEtudiant();
        if (!$etudiant) {
            return redirect()->route('etudiant.login');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
            ]);

            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = time() . '_' . Str::slug($file->getClientOriginalName());
                $path = $file->storeAs('documents/' . $etudiant->id, $filename, 'public');
                
                // Save file info to database if needed
                // $etudiant->documents()->create([...]);
                
                return back()->with('success', 'Document téléversé avec succès!');
            }
        }

        return view('etudiant.depot');
    }
    
    // View remarks
    public function remarques()
    {
        $etudiant = $this->getAuthenticatedEtudiant();
        if (!$etudiant) {
            return redirect()->route('etudiant.login');
        }

        // Fetch remarks for the student
        // $remarques = $etudiant->remarques()->latest()->get();
        $remarques = []; // Replace with actual remarks query
        
        return view('etudiant.remarques', compact('remarques'));
    }
    
    // View defense (soutenance) information
    public function soutenance()
    {
        $etudiant = $this->getAuthenticatedEtudiant();
        if (!$etudiant) {
            return redirect()->route('etudiant.login');
        }

        // Fetch defense information
        // $soutenance = $etudiant->soutenance;
        $soutenance = null; // Replace with actual query
        
        return view('etudiant.soutenance', compact('soutenance'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $etudiant = $this->getAuthenticatedEtudiant();
        if (!$etudiant) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:etudiants,email,' . $etudiant->id,
            'date_naissance' => 'sometimes|date',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $etudiant->update($validated);

        return back()->with('success', 'Profil mis à jour avec succès!');
    }

    // Helper method to get authenticated student
    protected function getAuthenticatedEtudiant()
    {
        $etudiantId = session('etudiant_id');
        return $etudiantId ? etudiants::find($etudiantId) : null;
    }
}