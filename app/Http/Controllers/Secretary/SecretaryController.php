<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
      public function index()
    {
        // Nombre total d'élèves
        $totalEleves = Eleve::count();

        // Nombre total de classes
        $totalClasses = Classe::count();

        // Inscriptions en attente de validation
        $inscriptionsEnAttente = Inscription::where(
            'statut',
            'en_attente'
        )->count();

        // Nombre de bulletins encore en brouillon
        $bulletinsBrouillon = Bulletin::where(
            'statut',
            'brouillon'
        )->count();

        // Dernières inscriptions
        $inscriptionsRecentes = Inscription::with([
            'eleve',
            'classe',
            'anneeScolaire',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('secretariat.dashboard', compact(
            'totalEleves',
            'totalClasses',
            'inscriptionsEnAttente',
            'bulletinsBrouillon',
            'inscriptionsRecentes'
        ));
    }
}
