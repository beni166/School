<?php

namespace App\Http\Controllers\Secretary;

use App\Models\AnneeScolaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnneeScolaireController extends Controller
{
    /**
     * Afficher la liste des années scolaires.
     */
    public function index()
    {
        $annees = AnneeScolaire::orderBy('id', 'desc')->get();

        return view('secretariat.AnneeScolaire.index', compact('annees'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('secretariat.AnneeScolaire.create');
    }

    /**
     * Enregistrer une nouvelle année scolaire.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => [
                'required',
                'string',
                'max:30',
                'unique:annees_scolaires,libelle',
            ],
            'date_debut' => [
                'required',
                'date',
            ],
            'date_fin' => [
                'required',
                'date',
                'after:date_debut',
            ],
        ]);

        $data['active'] = false;

        AnneeScolaire::create($data);

        return redirect()
            ->route('secretariat.annees-scolaires.index')
            ->with('success', 'Année scolaire ajoutée avec succès.');
    }

    /**
     * Afficher une année scolaire.
     */
    public function show(AnneeScolaire $annees_scolaire)
    {
        return view('secretariat.AnneeScolaire.show', [
            'anneeScolaire' => $annees_scolaire,
        ]);
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(AnneeScolaire $annees_scolaire)
    {
        return view('secretariat.AnneeScolaire.edit', [
            'anneeScolaire' => $annees_scolaire,
        ]);
    }

    /**
     * Mettre à jour une année scolaire.
     */
    public function update(Request $request, AnneeScolaire $annees_scolaire)
    {
        $data = $request->validate([
            'libelle' => [
                'required',
                'string',
                'max:30',
                'unique:annees_scolaires,libelle,' . $annees_scolaire->id,
            ],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
        ]);

        $data['active'] = $request->boolean('active');

        $annees_scolaire->update($data);
        return redirect()
            ->route('secretariat.annees-scolaires.index')
            ->with('success', 'Année scolaire modifiée avec succès.');
    }

    /**
     * Supprimer une année scolaire.
     */
    public function destroy(AnneeScolaire $annees_scolaire)
    {
        $annees_scolaire->delete();

        return redirect()
            ->route('secretariat.annees-scolaires.index')
            ->with('success', 'Année scolaire supprimée avec succès.');
    }
}
