<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfessorController;
use Illuminate\Support\Facades\Route;

// ---------------------------------------------------------------- Pages publiques
Route::view('/', 'acceuil')->name('home');
Route::redirect('/acceuil', '/');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::redirect('/signup', '/login');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------------------------------------------------- Espace étudiant
Route::prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/register', [EtudiantController::class, 'showRegister'])->name('register');
    Route::post('/register', [EtudiantController::class, 'register']);
    Route::redirect('/login', '/login?role=etudiant')->name('login');

    Route::middleware('etudiant.auth')->group(function () {
        Route::get('/dashboard', [EtudiantController::class, 'dashboard'])->name('dashboard');
        Route::match(['get', 'post'], '/depot', [EtudiantController::class, 'depot'])->name('depot');
        Route::get('/remarques', [EtudiantController::class, 'remarques'])->name('remarques');
        Route::post('/remarques/{id}/traiter', [EtudiantController::class, 'traiterRemarque'])->name('remarques.traiter');
        Route::get('/soutenance', [EtudiantController::class, 'soutenance'])->name('soutenance');
        Route::post('/profile/update', [EtudiantController::class, 'updateProfile'])->name('profile.update');
    });
});

// ---------------------------------------------------------------- Espace administrateur
Route::prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/login', '/login?role=admin')->name('login');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/etudiants', [AdminController::class, 'students'])->name('students');
        Route::post('/etudiants', [AdminController::class, 'storeStudent'])->name('students.store');
        Route::delete('/etudiants/{id}', [AdminController::class, 'destroyStudent'])->name('students.destroy');

        Route::get('/professeurs', [AdminController::class, 'teachers'])->name('teachers');
        Route::post('/professeurs', [AdminController::class, 'storeTeacher'])->name('teachers.store');
        Route::delete('/professeurs/{id}', [AdminController::class, 'destroyTeacher'])->name('teachers.destroy');

        Route::get('/assignations', [AdminController::class, 'assignations'])->name('assignations');
        Route::post('/assignations/{id}', [AdminController::class, 'updateAssignation'])->name('assignations.update');

        Route::get('/validation', [AdminController::class, 'validation'])->name('validation');
        Route::post('/documents/{id}/valider', [AdminController::class, 'validerDocument'])->name('documents.valider');
        Route::post('/documents/{id}/rejeter', [AdminController::class, 'rejeterDocument'])->name('documents.rejeter');

        Route::get('/soutenances', [AdminController::class, 'defenses'])->name('defenses');
        Route::get('/soutenances/planifier', [AdminController::class, 'createDefense'])->name('defenses.create');
        Route::post('/soutenances', [AdminController::class, 'storeDefense'])->name('defenses.store');
        Route::get('/soutenances/{id}', [AdminController::class, 'showDefense'])->name('defenses.show');
        Route::delete('/soutenances/{id}', [AdminController::class, 'destroyDefense'])->name('defenses.destroy');
    });
});

// ---------------------------------------------------------------- Espace professeur
Route::prefix('professeur')->name('professor.')->group(function () {
    Route::redirect('/login', '/login?role=professeur')->name('login');

    Route::middleware('professor')->group(function () {
        Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('dashboard');
        Route::get('/etudiants', [ProfessorController::class, 'etudiants'])->name('etudiants');
        Route::get('/etudiants/{id}', [ProfessorController::class, 'showEtudiant'])->name('etudiant.show');
        Route::get('/etudiants/{etudiantId}/documents/{documentId}', [ProfessorController::class, 'showDocument'])->name('documents.show');
        Route::post('/etudiants/{etudiantId}/remarques', [ProfessorController::class, 'addRemarque'])->name('remarques.store');
        Route::post('/documents/{documentId}/valider', [ProfessorController::class, 'validerDocument'])->name('documents.valider');
        Route::get('/planning', [ProfessorController::class, 'planning'])->name('planning');
        Route::post('/soutenances/{soutenanceId}/noter', [ProfessorController::class, 'noterSoutenance'])->name('soutenances.noter');
    });
});
