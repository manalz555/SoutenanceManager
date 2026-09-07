<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\etudiants;
use App\Models\professeurs;
use App\Models\Remarque;
use App\Models\soutenances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Espace professeur : étudiants suivis (encadrement / rapport), documents,
 * remarques, planning des soutenances et notation en tant que membre du jury.
 * Toutes les routes sont protégées par le middleware "professor".
 */
class ProfessorController extends Controller
{
    private function professeur(): professeurs
    {
        return professeurs::findOrFail(session('professeur_id'));
    }

    /** Étudiants que le professeur encadre ou dont il est rapporteur. */
    private function mesEtudiantsQuery(professeurs $prof)
    {
        return etudiants::where(function ($q) use ($prof) {
            $q->where('encadrant_id', $prof->id)->orWhere('rapporteur_id', $prof->id);
        });
    }

    /** Rôle du professeur vis-à-vis d'un étudiant (pour l'affichage). */
    private function roleAupres(professeurs $prof, etudiants $etudiant): string
    {
        if ($etudiant->encadrant_id === $prof->id) {
            return 'encadrant';
        }
        if ($etudiant->rapporteur_id === $prof->id) {
            return 'rapporteur';
        }
        $membre = $etudiant->soutenance?->juryMembers->firstWhere('id', $prof->id);

        return $membre?->pivot->role ?? 'jury';
    }

    /** Le professeur peut voir un étudiant s'il l'encadre, le rapporte ou siège dans son jury. */
    private function peutVoir(professeurs $prof, etudiants $etudiant): bool
    {
        if (in_array($prof->id, [$etudiant->encadrant_id, $etudiant->rapporteur_id], true)) {
            return true;
        }

        return $etudiant->soutenance?->juryMembers()->where('professeurs.id', $prof->id)->exists() ?? false;
    }

    // ------------------------------------------------------------------ Dashboard

    public function dashboard()
    {
        $professeur = $this->professeur();

        $etudiants = $this->mesEtudiantsQuery($professeur)->with(['documents', 'soutenance'])->get();

        $documentsRecents = Document::with('etudiant')
            ->whereIn('etudiant_id', $etudiants->pluck('id'))
            ->latest('date_soumission')
            ->take(5)
            ->get();

        $soutenancesAvenir = $professeur->soutenances()
            ->with('etudiant')
            ->where('Date_Sout', '>=', now())
            ->orderBy('Date_Sout')
            ->get();

        $roles = [
            'encadrant'   => $etudiants->where('encadrant_id', $professeur->id)->count(),
            'rapporteur'  => $etudiants->where('rapporteur_id', $professeur->id)->count(),
            'examinateur' => $professeur->soutenances()->wherePivot('role', 'examinateur')->count(),
            'president'   => $professeur->soutenances()->wherePivot('role', 'president')->count(),
        ];

        $stats = [
            'etudiants'   => $etudiants->count(),
            'rapports'    => $etudiants->sum(fn ($e) => $e->documents->where('type', 'rapport')->count()),
            'remarques'   => $professeur->remarques()->count(),
            'soutenances' => $soutenancesAvenir->count(),
        ];

        return view('professeur.dashboard', compact('professeur', 'etudiants', 'documentsRecents', 'soutenancesAvenir', 'roles', 'stats'));
    }

    // ------------------------------------------------------------------ Étudiants

    public function etudiants()
    {
        $professeur = $this->professeur();
        $etudiants = $this->mesEtudiantsQuery($professeur)->with(['documents', 'soutenance'])->orderBy('nom')->get();

        $etudiants->each(fn ($e) => $e->mon_role = $this->roleAupres($professeur, $e));

        return view('professeur.etudiants', compact('professeur', 'etudiants'));
    }

    public function showEtudiant(int $id)
    {
        $professeur = $this->professeur();
        $etudiant = etudiants::with(['documents', 'remarques.professeur', 'soutenance.juryMembers', 'encadrant', 'rapporteur'])->findOrFail($id);

        abort_unless($this->peutVoir($professeur, $etudiant), 403, 'Vous ne suivez pas cet étudiant.');

        $monRole = $this->roleAupres($professeur, $etudiant);

        return view('professeur.etudiant-show', compact('professeur', 'etudiant', 'monRole'));
    }

    public function showDocument(int $etudiantId, int $documentId)
    {
        $professeur = $this->professeur();
        $document = Document::where('etudiant_id', $etudiantId)->findOrFail($documentId);

        abort_unless($this->peutVoir($professeur, $document->etudiant), 403);
        abort_unless(Storage::disk('local')->exists($document->chemin_fichier), 404, 'Fichier introuvable.');

        return Storage::disk('local')->download($document->chemin_fichier, $document->nom_fichier_original);
    }

    public function addRemarque(Request $request, int $etudiantId)
    {
        $professeur = $this->professeur();
        $etudiant = etudiants::findOrFail($etudiantId);

        abort_unless($this->peutVoir($professeur, $etudiant), 403);

        $data = $request->validate([
            'document_id' => 'nullable|exists:documents,id',
            'sujet'       => 'nullable|string|max:255',
            'contenu'     => 'required|string|max:2000',
        ]);

        Remarque::create($data + ['etudiant_id' => $etudiant->id, 'professeur_id' => $professeur->id]);

        return back()->with('success', 'Remarque ajoutée.');
    }

    public function validerDocument(Request $request, int $documentId)
    {
        $professeur = $this->professeur();
        $document = Document::with('etudiant')->findOrFail($documentId);

        abort_unless(
            in_array($professeur->id, [$document->etudiant->encadrant_id, $document->etudiant->rapporteur_id], true),
            403,
            'Seuls l\'encadrant et le rapporteur peuvent valider un document.'
        );

        $data = $request->validate([
            'statut'      => 'required|in:valide,rejete',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $document->update($data);

        return back()->with('success', $data['statut'] === 'valide' ? 'Document validé.' : 'Document rejeté.');
    }

    // ------------------------------------------------------------------ Planning & notation

    public function planning()
    {
        $professeur = $this->professeur();
        $soutenances = $professeur->soutenances()->with(['etudiant', 'juryMembers'])->orderBy('Date_Sout')->get();

        return view('professeur.planning', compact('professeur', 'soutenances'));
    }

    public function noterSoutenance(Request $request, int $soutenanceId)
    {
        $professeur = $this->professeur();
        $soutenance = soutenances::findOrFail($soutenanceId);

        abort_unless(
            $soutenance->juryMembers()->where('professeurs.id', $professeur->id)->exists(),
            403,
            'Vous ne faites pas partie du jury de cette soutenance.'
        );

        $data = $request->validate([
            'note'        => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $soutenance->juryMembers()->updateExistingPivot($professeur->id, $data);
        $soutenance->recalculerNoteFinale();

        return back()->with('success', 'Note enregistrée.');
    }
}
