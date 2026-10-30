<?php

use App\Http\Controllers\Admin\AffectationProfesseurController;
use App\Http\Controllers\Admin\AnneeScolaireController as AdminAnneeScolaireController;
use App\Http\Controllers\Admin\BulletinController;
use App\Http\Controllers\Admin\BulletinDetailController;
use App\Http\Controllers\Admin\ClasseController;
use App\Http\Controllers\Admin\CycleController;
use App\Http\Controllers\Admin\DecisionScolaireController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\EleveController;
use App\Http\Controllers\Admin\InscriptionController;
use App\Http\Controllers\Admin\MatiereController;
use App\Http\Controllers\Admin\NiveauController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\ProfesseurController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProgrammeClasseController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'isDirector'], 'prefix' => 'director', 'as' => "director."], function () {
    Route::get('Dashboard', [DirectorController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get(
        '/bulletins/{bulletin}/pdf',
        [BulletinController::class, 'pdf']
    )->name('bulletins.pdf');
    Route::resource('annees-scolaires', AdminAnneeScolaireController::class);
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
    Route::get(
        'classes/{classe}/annees/{anneeScolaire}/liste-eleves/pdf',
        [ClasseController::class, 'exporterListeElevesPdf']
    )->name('classes.liste-eleves.pdf');

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
});
