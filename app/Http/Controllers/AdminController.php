<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\etudiants;
use App\Models\professeurs;
use App\Models\soutenances;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Espace administrateur : étudiants, professeurs, assignations, validation des
 * rapports et planification des soutenances (jury inclus).
 * Toutes les routes sont protégées par le middleware "admin".
 */
class AdminController extends Controller
{
    // ------------------------------------------------------------------ Dashboard

    public function dashboard()
    {
        $stats = [
            'etudiants'   => etudiants::count(),
            'professeurs' => professeurs::count(),
            'rapports'    => Document::where('type', 'rapport')->count(),
            'soutenances' => soutenances::count(),
            'en_attente'  => Document::where('statut', 'soumis')->count(),
        ];

        $prochaines = soutenances::with(['etudiant', 'juryMembers'])
            ->where('Date_Sout', '>=', now())
            ->orderBy('Date_Sout')
            ->take(5)
            ->get();

        $documentsEnAttente = Document::with('etudiant.encadrant')
            ->where('statut', 'soumis')
            ->latest('date_soumission')
            ->take(5)
            ->get();

        $totalEtudiants = max($stats['etudiants'], 1);
        $progress = [
            'Rapports validés'       => [Document::where('type', 'rapport')->where('statut', 'valide')->count(), max($stats['rapports'], 1)],
            'Jurys constitués'       => [soutenances::has('juryMembers', '>=', 3)->count(), $totalEtudiants],
            'Soutenances planifiées' => [$stats['soutenances'], $totalEtudiants],
        ];

        return view('admin.dashboard', compact('stats', 'prochaines', 'documentsEnAttente', 'progress'));
    }

    // ------------------------------------------------------------------ Étudiants

    public function students()
    {
        $students = etudiants::with(['encadrant', 'soutenance'])->orderBy('nom')->orderBy('prenom')->get();

        return view('admin.etudiants', compact('students'));
    }

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'nom'                 => 'required|string|max:255',
            'prenom'              => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:etudiants,email',
            'password'            => 'required|string|min:6',
            'date_naissance'      => 'nullable|date',
            'matricule'           => 'nullable|string|max:50|unique:etudiants,matricule',
            'filiere'             => 'nullable|string|max:100',
            'annee_universitaire' => 'nullable|string|max:20',
        ]);

        etudiants::create($validated);

        return redirect()->route('admin.students')->with('success', 'Étudiant ajouté avec succès.');
    }

    public function destroyStudent(int $id)
    {
        etudiants::findOrFail($id)->delete();

        return back()->with('success', 'Étudiant supprimé.');
    }

    // ------------------------------------------------------------------ Professeurs

    public function teachers()
    {
        $teachers = professeurs::withCount(['etudiantsEncadres', 'etudiantsRapportes'])
            ->orderBy('nom_prof')
            ->get();

        return view('admin.professeurs', ['teachers' => $teachers, 'roles' => professeurs::ROLES]);
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'nom_prof'      => 'required|string|max:255',
            'prenom_prof'   => 'required|string|max:255',
            'role_prof'     => ['required', Rule::in(array_keys(professeurs::ROLES))],
            'email_prof'    => 'required|email|max:255|unique:professeurs,email_prof',
            'password_prof' => 'required|string|min:6',
        ]);

        professeurs::create($validated);

        return redirect()->route('admin.teachers')->with('success', 'Professeur ajouté avec succès.');
    }

    public function destroyTeacher(int $id)
    {
        professeurs::findOrFail($id)->delete();

        return back()->with('success', 'Professeur supprimé.');
    }

    // ------------------------------------------------------------------ Assignations

    public function assignations()
    {
        $students = etudiants::with(['encadrant', 'rapporteur'])->orderBy('nom')->get();
        $teachers = professeurs::orderBy('nom_prof')->get();

        return view('admin.assignations', compact('students', 'teachers'));
    }

    public function updateAssignation(Request $request, int $id)
    {
        $etudiant = etudiants::findOrFail($id);

        $validated = $request->validate([
            'encadrant_id'  => 'nullable|exists:professeurs,id',
            'rapporteur_id' => 'nullable|exists:professeurs,id|different:encadrant_id',
        ], [
            'rapporteur_id.different' => 'Le rapporteur doit être différent de l\'encadrant.',
        ]);

        $etudiant->update($validated);

        return back()->with('success', "Assignation enregistrée pour {$etudiant->full_name}.");
    }

    // ------------------------------------------------------------------ Validation des rapports

    public function validation()
    {
        $documents = Document::with(['etudiant.encadrant', 'etudiant.rapporteur'])
            ->latest('date_soumission')
            ->get();

        return view('admin.validation', compact('documents'));
    }

    public function validerDocument(int $id)
    {
        Document::findOrFail($id)->update(['statut' => 'valide']);

        return back()->with('success', 'Rapport validé.');
    }

    public function rejeterDocument(Request $request, int $id)
    {
        $data = $request->validate(['commentaire' => 'nullable|string|max:1000']);

        Document::findOrFail($id)->update(['statut' => 'rejete', 'commentaire' => $data['commentaire'] ?? null]);

        return back()->with('success', 'Rapport rejeté.');
    }

    // ------------------------------------------------------------------ Soutenances

    public function defenses()
    {
        $defenses = soutenances::with(['etudiant.encadrant', 'juryMembers'])->orderBy('Date_Sout')->get();

        return view('admin.soutenances', compact('defenses'));
    }

    public function createDefense()
    {
        $students = etudiants::doesntHave('soutenance')->with(['encadrant', 'rapporteur'])->orderBy('nom')->get();
        $teachers = professeurs::orderBy('nom_prof')->get();

        return view('admin.planification', compact('students', 'teachers'));
    }

    public function storeDefense(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id'    => 'required|exists:etudiants,id|unique:soutenances,etudiant_id',
            'date'           => 'required|date',
            'heure'          => 'required|date_format:H:i',
            'salle'          => 'required|string|max:50',
            'president_id'   => 'required|exists:professeurs,id',
            'encadrant_id'   => 'required|exists:professeurs,id|different:president_id',
            'rapporteur_id'  => 'required|exists:professeurs,id|different:president_id|different:encadrant_id',
            'examinateur_id' => 'nullable|exists:professeurs,id|different:president_id|different:encadrant_id|different:rapporteur_id',
        ], [
            'etudiant_id.unique' => 'Cet étudiant a déjà une soutenance planifiée.',
            'different'          => 'Un même professeur ne peut pas occuper deux rôles dans le jury.',
        ]);

        $soutenance = soutenances::create([
            'etudiant_id' => $validated['etudiant_id'],
            'Date_Sout'   => $validated['date'].' '.$validated['heure'],
            'Salle_Sout'  => $validated['salle'],
        ]);

        $jury = [
            $validated['president_id']  => ['role' => 'president'],
            $validated['encadrant_id']  => ['role' => 'encadrant'],
            $validated['rapporteur_id'] => ['role' => 'rapporteur'],
        ];
        if (! empty($validated['examinateur_id'])) {
            $jury[$validated['examinateur_id']] = ['role' => 'examinateur'];
        }
        $soutenance->juryMembers()->attach($jury);

        return redirect()->route('admin.defenses')->with('success', 'Soutenance planifiée et jury constitué.');
    }

    public function showDefense(int $id)
    {
        $defense = soutenances::with(['etudiant.documents', 'juryMembers'])->findOrFail($id);

        return view('admin.soutenance-show', compact('defense'));
    }

    public function destroyDefense(int $id)
    {
        soutenances::findOrFail($id)->delete();

        return redirect()->route('admin.defenses')->with('success', 'Soutenance annulée.');
    }
}
