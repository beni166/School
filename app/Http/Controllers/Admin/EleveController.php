<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Http\Controllers\Controller;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EleveController extends Controller
{
    public function index(Request $request)
{
    $request->validate([
        'recherche' => ['nullable', 'string', 'max:100'],
        'classe_id' => ['nullable', 'integer', 'exists:classes,id'],
    ]);

    $query = Eleve::with([
        'inscriptions.classe',
        'inscriptions.anneeScolaire',
    ]);

    // Recherche par nom, prénom ou matricule
    if ($request->filled('recherche')) {
        $recherche = trim($request->recherche);

        $query->where(function ($q) use ($recherche) {
            $q->where('nom', 'like', "%{$recherche}%")
              ->orWhere('prenom', 'like', "%{$recherche}%")
              ->orWhere('matricule', 'like', "%{$recherche}%");
        });
    }

    // Filtre par classe à travers les inscriptions
    if ($request->filled('classe_id')) {
        $query->whereHas('inscriptions', function ($q) use ($request) {
            $q->where('classe_id', $request->classe_id);
        });
    }

    $eleves = $query
        ->orderBy('nom')
        ->orderBy('prenom')
        ->paginate(15)
        ->withQueryString();

    $classes = Classe::orderBy('nom')->get();

    return view('Eleve.index', compact('eleves', 'classes'));
}

    public function create()
    {
        return view('Eleve.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricule' => [
                'required',
                'string',
                'max:50',
                'unique:eleves,matricule',
            ],
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:150'],
            'sexe' => ['required', Rule::in(['M', 'F'])],
            'date_naissance' => ['nullable', 'date', 'before_or_equal:today'],
        ]);

        Eleve::create($data);

        return to_route('director.eleves.index')
            ->with('success', 'Élève ajouté avec succès.');
    }

    public function show(Eleve $eleve)
    {
        $eleve->load([
            'inscriptions.anneeScolaire',
            'inscriptions.classe',
            'inscriptions.bulletins',
        ]);

        return view('Eleve.show', compact('eleve'));
    }

    public function edit(Eleve $eleve)
    {
        return view('Eleve.edit', compact('eleve'));
    }

    public function update(Request $request, Eleve $eleve)
    {
        $data = $request->validate([
            'matricule' => [
                'required',
                'string',
                'max:50',
                Rule::unique('eleves', 'matricule')->ignore($eleve->id),
            ],
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:150'],
            'sexe' => ['required', Rule::in(['M', 'F'])],
            'date_naissance' => ['nullable', 'date', 'before_or_equal:today'],
        ]);

        $eleve->update($data);

        return to_route('director.eleves.index')
            ->with('success', 'Informations de l’élève mises à jour.');
    }

    public function destroy(Eleve $eleve)
    {
        if ($eleve->inscriptions()->exists()) {
            return back()->with(
                'error',
                'Impossible de supprimer cet élève : son historique scolaire existe.'
            );
        }

        $eleve->delete();

        return to_route('director.eleves.index')
            ->with('success', 'Élève supprimé avec succès.');
    }
}
