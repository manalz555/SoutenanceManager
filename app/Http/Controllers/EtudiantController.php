<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\etudiants;
use App\Models\Remarque;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Espace étudiant : inscription, tableau de bord, dépôt des documents,
 * suivi des remarques et consultation de la soutenance.
 * Les routes (hors inscription) sont protégées par le middleware "etudiant.auth".
 */
class EtudiantController extends Controller
{
    private function etudiant(): etudiants
    {
        return etudiants::findOrFail(session('etudiant_id'));
    }

    // ------------------------------------------------------------------ Inscription

    public function showRegister()
    {
        return view('etudiant.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom'                 => 'required|string|max:255',
            'prenom'              => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:etudiants,email',
            'password'            => 'required|string|min:6|confirmed',
            'date_naissance'      => 'nullable|date',
            'matricule'           => 'nullable|string|max:50|unique:etudiants,matricule',
            'filiere'             => 'nullable|string|max:100',
            'annee_universitaire' => 'nullable|string|max:20',
        ]);

        $etudiant = etudiants::create($validated);

        $request->session()->regenerate();
        session(['etudiant_id' => $etudiant->id]);

        return redirect()->route('etudiant.dashboard')->with('success', 'Bienvenue, votre compte est créé.');
    }

    // ------------------------------------------------------------------ Dashboard

    public function dashboard()
    {
        $etudiant = $this->etudiant()->load(['documents', 'remarques.professeur', 'soutenance.juryMembers', 'encadrant', 'rapporteur']);

        $rapport = $etudiant->dernierRapport();
        $dossier = $etudiant->documents->firstWhere('type', 'dossier_stage');
        $soutenance = $etudiant->soutenance;

        $joursAvant = $soutenance && $soutenance->Date_Sout->isFuture()
            ? (int) now()->startOfDay()->diffInDays($soutenance->Date_Sout->startOfDay())
            : null;

        return view('etudiant.dashboard', compact('etudiant', 'rapport', 'dossier', 'soutenance', 'joursAvant'));
    }

    // ------------------------------------------------------------------ Dépôt

    public function depot(Request $request)
    {
        $etudiant = $this->etudiant();

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'type'                 => ['required', Rule::in(array_keys(Document::TYPES))],
                'titre'                => 'required|string|max:255',
                'entreprise'           => 'nullable|string|max:255',
                'document'             => 'required|file|mimes:pdf|max:10240',
                'est_version_corrigee' => 'nullable|boolean',
            ]);

            $file = $request->file('document');
            $path = $file->store('documents/'.$etudiant->id, 'local');

            $titre = $data['titre'];
            if (! empty($data['entreprise'])) {
                $titre .= ' — '.$data['entreprise'];
            }

            Document::create([
                'etudiant_id'          => $etudiant->id,
                'type'                 => $data['type'],
                'titre'                => $titre,
                'chemin_fichier'       => $path,
                'nom_fichier_original' => $file->getClientOriginalName(),
                'extension'            => strtolower($file->getClientOriginalExtension()),
                'taille_mo'            => round($file->getSize() / 1048576, 2),
                'est_version_corrigee' => (bool) ($data['est_version_corrigee'] ?? false),
            ]);

            return redirect()->route('etudiant.depot')->with('success', 'Document déposé avec succès.');
        }

        $documents = $etudiant->documents()->get();

        return view('etudiant.depot', compact('etudiant', 'documents'));
    }

    // ------------------------------------------------------------------ Remarques

    public function remarques()
    {
        $etudiant = $this->etudiant();
        $remarques = $etudiant->remarques()->with(['professeur', 'document'])->get();

        return view('etudiant.remarques', compact('etudiant', 'remarques'));
    }

    public function traiterRemarque(int $id)
    {
        $remarque = Remarque::where('etudiant_id', session('etudiant_id'))->findOrFail($id);
        $remarque->marquerTraitee();

        return back()->with('success', 'Remarque marquée comme traitée.');
    }

    // ------------------------------------------------------------------ Soutenance

    public function soutenance()
    {
        $etudiant = $this->etudiant()->load('soutenance.juryMembers');

        return view('etudiant.soutenance', ['etudiant' => $etudiant, 'soutenance' => $etudiant->soutenance]);
    }

    // ------------------------------------------------------------------ Profil

    public function updateProfile(Request $request)
    {
        $etudiant = $this->etudiant();

        $validated = $request->validate([
            'nom'            => 'sometimes|string|max:255',
            'prenom'         => 'sometimes|string|max:255',
            'email'          => 'sometimes|email|max:255|unique:etudiants,email,'.$etudiant->id,
            'telephone'      => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'password'       => 'nullable|string|min:6|confirmed',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $etudiant->update($validated);

        return back()->with('success', 'Profil mis à jour.');
    }
}
