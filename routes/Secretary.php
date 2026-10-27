<?php

use App\Http\Controllers\Secretary\AffectationProfesseurController;
use App\Http\Controllers\Secretary\AnneeScolaireController;
use App\Http\Controllers\Secretary\BulletinController;
use App\Http\Controllers\Secretary\BulletinDetailController;
use App\Http\Controllers\Secretary\ClasseController;
use App\Http\Controllers\Secretary\CycleController;
use App\Http\Controllers\Secretary\DecisionScolaireController;
use App\Http\Controllers\Secretary\EleveController;
use App\Http\Controllers\Secretary\InscriptionController;
use App\Http\Controllers\Secretary\MatiereController;
use App\Http\Controllers\Secretary\NiveauController;
use App\Http\Controllers\Secretary\NoteController;
use App\Http\Controllers\Secretary\PeriodeController;
use App\Http\Controllers\Secretary\PresenceController;
use App\Http\Controllers\Secretary\ProfesseurController;
use App\Http\Controllers\Secretary\ProfileController;
use App\Http\Controllers\Secretary\ProgrammeClasseController;
use App\Http\Controllers\Secretary\SecretaryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'isSecretary'])
    ->prefix('secretary')
    ->as('secretary.')
    ->group(function () {

      
 Route::get('Dashboard', [SecretaryController::class, 'index'])->name('dashboard');
    Route::resource('annees-scolaires', AnneeScolaireController::class);
    Route::resource('matieres', MatiereController::class);
    Route::resource('programmes-classes', ProgrammeClasseController::class);
    Route::resource('affectations', AffectationProfesseurController::class);
    Route::resource('periodes', PeriodeController::class);
    Route::resource('inscriptions', InscriptionController::class);
    Route::resource('notes', NoteController::class);
    route::post('bulletins/{bulletin}/generer', [BulletinController::class, 'generer'])->name('bulletins.generer');
    route::post('bulletins/{bulletin}/valider', [BulletinController::class, 'valider'])->name('bulletins.valider');
    Route::resource('bulletins', BulletinController::class);
    Route::resource('bulletins-details', BulletinDetailController::class);
    Route::resource('cycle', CycleController::class);
    Route::resource('niveau', NiveauController::class);
    Route::resource('classes', ClasseController::class);
    Route::resource('decisions-scolaires', DecisionScolaireController::class);
    // Route::resource('presence', PresenceController::class);
    Route::resource('professeurs', ProfesseurController::class);
    Route::resource('eleves', EleveController::class)->parameters(['eleves' => 'eleve']);


    Route::get('presences', [
        PresenceController::class,
        'index',
    ])->name('presences.index');

    Route::get('presences/create', [
        PresenceController::class,
        'create',
    ])->name('presences.create');

    Route::post('presences', [
        PresenceController::class,
        'store',
    ])->name('presences.store');

    Route::post('presences/appel', [
        PresenceController::class,
        'enregistrerAppel',
    ])->name('presences.appel');

    Route::get('presences/{presence}', [
        PresenceController::class,
        'show',
    ])->name('presences.show');

    Route::get('presences/{presence}/edit', [
        PresenceController::class,
        'edit',
    ])->name('presences.edit');

    Route::put('presences/{presence}', [
        PresenceController::class,
        'update',
    ])->name('presences.update');

    Route::delete('presences/{presence}', [
        PresenceController::class,
        'destroy',
    ])->name('presences.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    });


// Route::group(['middelware' => ['auth', 'as', 'isSecretary'], 'prefix' => 'secretary', 'as', 'secretary.'], function () {
//    
// });
