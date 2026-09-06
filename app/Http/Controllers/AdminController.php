<?php

namespace App\Http\Controllers;

use App\Models\etudiants;
use App\Models\professeurs;
use App\Models\soutenances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // Afficher le tableau de bord administrateur
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $totalStudents = etudiants::count();
        $totalTeachers = professeurs::count();
        $totalDefenses = soutenances::count();
        $upcomingDefenses = soutenances::where('Date_Sout', '>=', now())
            ->orderBy('Date_Sout', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalStudents', 'totalTeachers', 'totalDefenses', 'upcomingDefenses'));
    }

    // Afficher le formulaire de connexion administrateur
    public function showLogin()
    {
        return view('admin.login');
    }

    // Traiter la connexion administrateur
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Vérification des identifiants (à personnaliser selon votre logique d'authentification admin)
        if ($request->email === 'admin@example.com' && $request->password === 'admin123') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants invalides']);
    }

    // Déconnexion administrateur
    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    // Gestion des étudiants
    public function students()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $students = etudiants::all();
        return view('admin.students.index', compact('students'));
    }

    // Afficher le formulaire d'ajout d'étudiant
    public function createStudent()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.students.create');
    }

    // Enregistrer un nouvel étudiant
    public function storeStudent(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'email' => 'required|string|email|max:255|unique:etudiants',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
            'niveau_etude' => 'required|string|max:50',
            'filiere' => 'required|string|max:100',
            'specialite' => 'nullable|string|max:100',
            'matricule' => 'required|string|max:50|unique:etudiants',
            'annee_universitaire' => 'required|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        etudiants::create($validated);

        return redirect()->route('admin.students')->with('success', 'Étudiant ajouté avec succès');
    }

    // Afficher les détails d'un étudiant
    public function showStudent($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $student = etudiants::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    // Gestion des professeurs
    public function teachers()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $teachers = professeurs::all();
        return view('admin.teachers.index', compact('teachers'));
    }

    // Afficher le formulaire d'ajout de professeur
    public function createTeacher()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.teachers.create');
    }

    // Enregistrer un nouveau professeur
    public function storeTeacher(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'nom_prof' => 'required|string|max:255',
            'prenom_prof' => 'required|string|max:255',
            'role_prof' => 'required|string|in:enseignant,rapporteur,examinateur,president',
            'email_prof' => 'required|string|email|max:255|unique:professeurs',
            'password_prof' => 'required|string|min:8|confirmed',
        ]);

        $validated['password_prof'] = Hash::make($validated['password_prof']);
        
        professeurs::create([
            'nom_prof' => $validated['nom_prof'],
            'prenom_prof' => $validated['prenom_prof'],
            'role_prof' => $validated['role_prof'],
            'email_prof' => $validated['email_prof'],
            'password_prof' => $validated['password_prof'],
        ]);

        return redirect()->route('admin.teachers')->with('success', 'Professeur ajouté avec succès');
    }

    // Gestion des soutenances
    public function defenses()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $defenses = soutenances::with(['etudiant', 'juryMembers'])->get();
        return view('admin.defenses.index', compact('defenses'));
    }

    // Afficher le formulaire de planification d'une soutenance
    public function createDefense()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $students = etudiants::all();
        $teachers = professeurs::all();
        
        return view('admin.defenses.create', compact('students', 'teachers'));
    }

    // Enregistrer une nouvelle soutenance
    public function storeDefense(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'date_soutenance' => 'required|date|after:today',
            'salle' => 'required|string|max:50',
            'jury_members' => 'required|array|min:3',
            'jury_members.*' => 'exists:professeurs,id',
        ]);

        // Créer la soutenance
        $soutenance = soutenances::create([
            'etudiant_id' => $validated['etudiant_id'],
            'Date_Sout' => $validated['date_soutenance'],
            'Salle_Sout' => $validated['salle'],
            'Note_finale' => 0, // Note initiale à 0
        ]);

        // Attacher les membres du jury à la soutenance
        $soutenance->juryMembers()->attach($validated['jury_members']);

        return redirect()->route('admin.defenses')->with('success', 'Soutenance planifiée avec succès');
    }

    // Afficher les détails d'une soutenance
    public function showDefense($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $defense = soutenances::with(['etudiant', 'juryMembers'])->findOrFail($id);
        return view('admin.defenses.show', compact('defense'));
    }
}
