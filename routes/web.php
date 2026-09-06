<?php

use App\Http\Controllers\acceuilController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\signupController;
use App\Http\Controllers\etudiantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfessorController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/acceuil', [acceuilController::class, 'acceuil'])->name('home');
Route::get('/signup', [signupController::class, 'signup'])->name('signup');

// Student Authentication Routes
Route::prefix('etudiant')->group(function () {
    // Authentication
    Route::get('/login', [etudiantController::class, 'showLogin'])->name('etudiant.login');
    Route::post('/login', [etudiantController::class, 'login']);
    Route::get('/register', [etudiantController::class, 'showRegister'])->name('etudiant.register');
    Route::post('/register', [etudiantController::class, 'register']);
    Route::post('/logout', [etudiantController::class, 'logout'])->name('etudiant.logout');
    
    // Protected routes (require authentication)
    Route::middleware(['etudiant.auth'])->group(function () {
        Route::get('/dashboard', [etudiantController::class, 'dashboard'])->name('etudiant.dashboard');
        Route::match(['get', 'post'], '/depot', [etudiantController::class, 'depot'])->name('etudiant.depot');
        Route::get('/remarques', [etudiantController::class, 'remarques'])->name('etudiant.remarques');
        Route::get('/soutenance', [etudiantController::class, 'soutenance'])->name('etudiant.soutenance');
        Route::post('/profile/update', [etudiantController::class, 'updateProfile'])->name('etudiant.profile.update');
    });
});

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    // Authentication
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    
    // Protected routes (require admin authentication)
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Gestion des étudiants
        Route::get('/etudiants', [AdminController::class, 'students'])->name('admin.students');
        Route::get('/etudiants/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
        Route::post('/etudiants', [AdminController::class, 'storeStudent'])->name('admin.students.store');
        Route::get('/etudiants/{id}', [AdminController::class, 'showStudent'])->name('admin.students.show');
        
        // Gestion des professeurs
        Route::get('/professeurs', [AdminController::class, 'teachers'])->name('admin.teachers');
        Route::get('/professeurs/create', [AdminController::class, 'createTeacher'])->name('admin.teachers.create');
        Route::post('/professeurs', [AdminController::class, 'storeTeacher'])->name('admin.teachers.store');
        
        // Gestion des soutenances
        Route::get('/soutenances', [AdminController::class, 'defenses'])->name('admin.defenses');
        Route::get('/soutenances/create', [AdminController::class, 'createDefense'])->name('admin.defenses.create');
        Route::post('/soutenances', [AdminController::class, 'storeDefense'])->name('admin.defenses.store');
        Route::get('/soutenances/{id}', [AdminController::class, 'showDefense'])->name('admin.defenses.show');
    });
});

// Professor Authentication Routes
Route::prefix('professeur')->group(function () {
    // Authentication
    Route::get('/login', [ProfessorController::class, 'showLogin'])->name('professor.login');
    Route::post('/login', [ProfessorController::class, 'login']);
    
    // Protected routes (require professor authentication)
    Route::middleware(['professor'])->group(function () {
        Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('professor.dashboard');
        Route::post('/logout', [ProfessorController::class, 'logout'])->name('professor.logout');
        
        // Gestion des étudiants encadrés
        Route::get('/etudiants/{id}', [ProfessorController::class, 'showEtudiant'])->name('professor.etudiant.show');
        
        // Gestion des documents
        Route::get('/etudiants/{etudiantId}/documents/{documentId}', [ProfessorController::class, 'showDocument'])
            ->name('professor.documents.show');
            
        // Gestion des remarques
        Route::post('/etudiants/{etudiantId}/remarques', [ProfessorController::class, 'addRemarque'])
            ->name('professor.remarques.store');
            
        // Validation des documents
        Route::post('/documents/{documentId}/valider', [ProfessorController::class, 'validerDocument'])
            ->name('professor.documents.valider');
            
        // Notation des soutenances
        Route::post('/soutenances/{soutenanceId}/noter', [ProfessorController::class, 'noterSoutenance'])
            ->name('professor.soutenances.noter');
    });
});