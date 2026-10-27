<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


class ProfesseurController extends Controller
{
    public function index()
    {
        $professeurs = Professeur::with('affectations')
            ->orderBy('nom')
            ->paginate(15);

        return view('secretariat.Professeur.index', compact('professeurs'));
    }

    public function create()
    {
        return view('secretariat.Professeur.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:150'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:professeurs,email',
            ],
            'telephone' => ['nullable', 'string', 'max:30'],
        ]);

        Professeur::create($data);

        return to_route('secretariat.professeurs.index')
            ->with('success', 'Professeur ajouté avec succès.');
    }

    public function show(Professeur $professeur)
    {
        $professeur->load([
            'affectations.anneeScolaire',
            'affectations.classe',
            'affectations.matiere',
        ]);

        return view('secretariat.Professeur.show', compact('professeur'));
    }

    public function edit(Professeur $professeur)
    {
        return view('secretariat.Professeur.edit', compact('professeur'));
    }

    public function update(Request $request, Professeur $professeur)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:150'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('professeurs', 'email')->ignore($professeur->id),
            ],
            'telephone' => ['nullable', 'string', 'max:30'],
        ]);

        $professeur->update($data);

        return to_route('secretariat.professeurs.index')
            ->with('success', 'Informations du professeur mises à jour.');
    }

    public function destroy(Professeur $professeur)
    {
        if ($professeur->affectations()->exists()) {
            return back()->with(
                'error',
                'Impossible de supprimer ce professeur : des affectations existent.'
            );
        }

        $professeur->delete();

        return to_route('secretariat.professeurs.index')
            ->with('success', 'Professeur supprimé avec succès.');
    }
}
