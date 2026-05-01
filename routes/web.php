<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\FormateurEspaceController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PasswordChangeController;

// Redirect accueil → login
Route::get('/', function () {
    return redirect()->route('login');
});

// API pour le chargement dynamique des groupes
Route::get('/api/groupes/{filiere}', [PublicController::class, 'getGroupesByFiliere']);

// Routes authentifiées
Route::middleware(['auth'])->group(function () {

    // Gendarme de redirection par rôle
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->must_change_password) {
            return redirect()->route('password.change');
        }

        return match($user->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'formateur' => redirect()->route('formateur.dashboard'),
            'stagiaire' => redirect()->route('stagiaire.dashboard'),
            default     => redirect('/'),
        };
    })->name('dashboard');

    // Changement de mot de passe
    Route::get('/change-password',  [PasswordChangeController::class, 'showChangeForm'])->name('password.change');
    Route::post('/change-password', [PasswordChangeController::class, 'updatePassword'])->name('password.change.update');

    Route::middleware(['force.password.change'])->group(function () {

        Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // =====================
        // ESPACE ADMIN
        // =====================
        Route::middleware(['check.role:admin'])->prefix('admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

            Route::resource('groupes',    GroupeController::class);
            Route::resource('formateurs', FormateurController::class);
            Route::post('formateurs/{formateur}/reset-password', [FormateurController::class, 'resetPassword'])
                ->name('formateurs.reset-password');
            Route::resource('salles',   SalleController::class);
            Route::resource('seances',  SeanceController::class);

            Route::get('/planning/groupe',    [SeanceController::class, 'planningGroupe'])->name('planning.groupe');
            Route::get('/planning/formateur', [SeanceController::class, 'planningFormateur'])->name('planning.formateur');
            Route::get('/planning/salle',     [SeanceController::class, 'planningSalle'])->name('planning.salle');
            Route::get('/planning/export',    [SeanceController::class, 'exportPdf'])->name('planning.export');
        });

        // =====================
        // ESPACE FORMATEUR
        // =====================
        Route::middleware(['check.role:formateur'])->prefix('formateur')->group(function () {
            Route::get('/dashboard', [FormateurEspaceController::class, 'dashboard'])->name('formateur.dashboard');
            Route::get('/planning/export', [FormateurEspaceController::class, 'exportPdf'])->name('formateur.planning.export');
        });

        // =====================
        // ESPACE STAGIAIRE
        // =====================
        Route::middleware(['check.role:stagiaire'])->prefix('stagiaire')->group(function () {
            Route::get('/dashboard', [StagiaireController::class, 'dashboard'])->name('stagiaire.dashboard');
        });
    });
});

// Export PDF public (accessible sans login pour la page publique)
Route::get('/public/planning/export', [PublicController::class, 'exportPdf'])->name('public.planning.export');

require __DIR__.'/auth.php';