<?php

namespace App\Http\Controllers;

use App\Models\etudiants;
use App\Models\professeurs;
use App\Models\soutenances;
use App\Models\Document;
use App\Models\Remarque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProfessorController extends Controller
{
    // Afficher le tableau de bord du professeur
    public function dashboard()
    {
        $professeur = $this->getAuthenticatedProfesseur();
        if (!$professeur) {
            return redirect()->route('professor.login');
        }

        // Récupérer les étudiants encadrés
        $etudiantsEncadres = [];
        if ($professeur->role_prof === 'enseignant') {
            $etudiantsEncadres = etudiants::where('encadrant_id', $professeur->id)->get();
        }

        // Récupérer les rapports à évaluer
        $rapportsAEvaluer = [];
        if ($professeur->role_prof === 'rapporteur') {
            $rapportsAEvaluer = Document::where('type', 'rapport')
                ->where('statut', 'soumis')
                ->whereHas('etudiant', function ($query) use ($professeur) {
                    $query->where('rapporteur_id', $professeur->id);
                })
                ->with('etudiant')
                ->get();
        }

        // Récupérer les soutenances à venir où le professeur est membre du jury
        $soutenancesAvenir = $professeur->soutenances()
            ->where('Date_Sout', '>=', now())
            ->with('etudiant')
            ->orderBy('Date_Sout', 'asc')
            ->get();

        return view('professor.dashboard', compact(
            'professeur',
            'etudiantsEncadres',
            'rapportsAEvaluer',
            'soutenancesAvenir'
        ));
    }

    // Afficher le formulaire de connexion professeur
    public function showLogin()
    {
        return view('professor.login');
    }

    // Traiter la connexion professeur
    public function login(Request $request)
    {
        $request->validate([
            'email_prof' => 'required|email',
            'password_prof' => 'required',
        ]);

        $professeur = professeurs::where('email_prof', $request->email_prof)->first();

        if ($professeur && Hash::check($request->password_prof, $professeur->password_prof)) {
            session(['professeur_id' => $professeur->id]);
            return redirect()->route('professor.dashboard');
        }

        return back()->withErrors(['email_prof' => 'Identifiants invalides']);
    }

    // Déconnexion professeur
    public function logout()
    {
        session()->forget('professeur_id');
        return redirect()->route('professor.login');
    }

    // Afficher les détails d'un étudiant encadré
    public function showEtudiant($id)
    {
        $professeur = $this->getAuthenticatedProfesseur();
        if (!$professeur) {
            return redirect()->route('professor.login');
        }

        $etudiant = etudiants::findOrFail($id);
        
        // Vérifier que le professeur est bien l'encadrant ou le rapporteur de l'étudiant
        if ($professeur->role_prof === 'enseignant' && $etudiant->encadrant_id !== $professeur->id) {
            abort(403, 'Accès non autorisé.');
        }
        
        if ($professeur->role_prof === 'rapporteur' && $etudiant->rapporteur_id !== $professeur->id) {
            abort(403, 'Accès non autorisé.');
        }

        $documents = $etudiant->documents()->latest()->get();
        $remarques = $etudiant->remarques()->latest()->get();
        $soutenance = $etudiant->soutenance;

        return view('professor.etudiant.show', compact('etudiant', 'documents', 'remarques', 'soutenance'));
    }

    // Afficher un document étudiant
    public function showDocument($etudiantId, $documentId)
    {
        $professeur = $this->getAuthenticatedProfesseur();
        if (!$professeur) {
            return redirect()->route('professor.login');
        }

        $document = Document::where('id', $documentId)
            ->where('etudiant_id', $etudiantId)
            ->firstOrFail();
            
        $etudiant = $document->etudiant;
        
        // Vérifier que le professeur est bien l'encadrant ou le rapporteur de l'étudiant
        if (($professeur->role_prof === 'enseignant' && $etudiant->encadrant_id !== $professeur->id) ||
            ($professeur->role_prof === 'rapporteur' && $etudiant->rapporteur_id !== $professeur->id)) {
            abort(403, 'Accès non autorisé.');
        }

        $filePath = storage_path('app/' . $document->chemin);
        
        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé.');
        }

        return response()->file($filePath);
    }

    // Ajouter une remarque sur un document
    public function addRemarque(Request $request, $etudiantId)
    {
        $professeur = $this->getAuthenticatedProfesseur();
        if (!$professeur) {
            return redirect()->route('professor.login');
        }

        $etudiant = etudiants::findOrFail($etudiantId);
        
        // Vérifier que le professeur est bien l'encadrant ou le rapporteur de l'étudiant
        if (($professeur->role_prof === 'enseignant' && $etudiant->encadrant_id !== $professeur->id) ||
            ($professeur->role_prof === 'rapporteur' && $etudiant->rapporteur_id !== $professeur->id)) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'contenu' => 'required|string|max:1000',
        ]);

        $document = Document::findOrFail($request->document_id);
        
        // Vérifier que le document appartient bien à l'étudiant
        if ($document->etudiant_id != $etudiantId) {
            abort(403, 'Document non trouvé pour cet étudiant.');
        }

        $remarque = new Remarque([
            'professeur_id' => $professeur->id,
            'document_id' => $document->id,
            'contenu' => $request->contenu,
            'statut' => 'nouveau',
        ]);

        $etudiant->remarques()->save($remarque);

        // Mettre à jour le statut du document si c'est un rapport et que le professeur est le rapporteur
        if ($document->type === 'rapport' && $professeur->role_prof === 'rapporteur') {
            $document->statut = 'en_relecture';
            $document->save();
        }

        return back()->with('success', 'Remarque ajoutée avec succès.');
    }

    // Valider un document (rapport)
    public function validerDocument($documentId)
    {
        $professeur = $this->getAuthenticatedProfesseur();
        if (!$professeur) {
            return redirect()->route('professor.login');
        }

        $document = Document::findOrFail($documentId);
        $etudiant = $document->etudiant;
        
        // Vérifier que le professeur est bien le rapporteur de l'étudiant
        if ($professeur->role_prof !== 'rapporteur' || $etudiant->rapporteur_id !== $professeur->id) {
            abort(403, 'Action non autorisée.');
        }

        // Vérifier que le document est un rapport
        if ($document->type !== 'rapport') {
            return back()->with('error', 'Seuls les rapports peuvent être validés via cette interface.');
        }

        $document->statut = 'valide';
        $document->save();

        return back()->with('success', 'Rapport validé avec succès.');
    }

    // Noter une soutenance
    public function noterSoutenance(Request $request, $soutenanceId)
    {
        $professeur = $this->getAuthenticatedProfesseur();
        if (!$professeur) {
            return redirect()->route('professor.login');
        }

        $soutenance = soutenances::findOrFail($soutenanceId);
        
        // Vérifier que le professeur est bien membre du jury de cette soutenance
        $estMembreJury = $soutenance->juryMembers()->where('professeurs.id', $professeur->id)->exists();
        
        if (!$estMembreJury) {
            abort(403, 'Vous ne faites pas partie du jury de cette soutenance.');
        }

        $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        // Enregistrer la note et le commentaire
        $soutenance->juryMembers()->updateExistingPivot($professeur->id, [
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        // Mettre à jour la note finale si tous les membres du jury ont noté
        $this->mettreAJourNoteFinale($soutenance);

        return back()->with('success', 'Note enregistrée avec succès.');
    }

    // Méthode utilitaire pour mettre à jour la note finale d'une soutenance
    private function mettreAJourNoteFinale(soutenances $soutenance)
    {
        $notes = $soutenance->juryMembers()
            ->wherePivot('note', '!=', null)
            ->pluck('jury_membres.note')
            ->toArray();

        if (count($notes) === $soutenance->juryMembers()->count()) {
            $moyenne = array_sum($notes) / count($notes);
            $soutenance->Note_finale = round($moyenne, 2);
            $soutenance->save();
        }
    }

    // Méthode utilitaire pour obtenir le professeur authentifié
    private function getAuthenticatedProfesseur()
    {
        if (!session('professeur_id')) {
            return null;
        }

        return professeurs::find(session('professeur_id'));
    }
}
