<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Professeur;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalEleves = Eleve::count();

        $totalProfesseurs = Professeur::count();

        $totalClasses = Classe::count();

        $totalInscriptions = Inscription::count();

        $inscriptionsEnAttente = Inscription::where(
            'statut',
            'en_attente'
        )->count();

        $totalBulletins = Bulletin::count();

        $bulletinsBrouillon = Bulletin::where(
            'statut',
            'brouillon'
        )->count();

        $inscriptionsRecentes = Inscription::with([
            'eleve',
            'classe',
            'anneeScolaire',
        ])
            ->latest()
            ->take(6)
            ->get();

        $bulletinsRecents = Bulletin::with([
            'inscription.eleve',
            'inscription.classe',
            'periode',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('Admin.Dashboard', compact(
            'totalEleves',
            'totalProfesseurs',
            'totalClasses',
            'totalInscriptions',
            'inscriptionsEnAttente',
            'totalBulletins',
            'bulletinsBrouillon',
            'inscriptionsRecentes',
            'bulletinsRecents'
        ));
    }
}
