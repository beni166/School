<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgrammeClasse;
use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgrammeClasseController extends Controller
{
    public function index()
    {
        $programmes = ProgrammeClasse::with([
            'anneeScolaire',
            'classe',
            'matiere'
        ])->paginate(15);

        return view('ProgrammesClasse.index', compact('programmes'));
    }

    public function create()
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        $matieres = Matiere::orderBy('nom')->get();

        return view('ProgrammesClasse.create', compact(
            'annees',
            'classes',
            'matieres'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'classe_id' => ['required', 'exists:classes,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'coefficient' => ['required', 'numeric', 'gt:0'],
        ]);

        $exists = ProgrammeClasse::where('annee_scolaire_id', $data['annee_scolaire_id'])
            ->where('classe_id', $data['classe_id'])
            ->where('matiere_id', $data['matiere_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['matiere_id' => 'Cette matière est déjà programmée pour cette classe et cette année.']);
        }

        ProgrammeClasse::create($data);

        return redirect()->route('director.programmes-classes.index')
            ->with('success', 'Programme de classe créé.');
    }

    public function edit(ProgrammeClasse $programmes_classe)
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        $matieres = Matiere::orderBy('nom')->get();

        return view('ProgrammesClasse.edit', [
            'programme' => $programmes_classe,
            'annees' => $annees,
            'classes' => $classes,
            'matieres' => $matieres,
        ]);
    }

    public function update(Request $request, ProgrammeClasse $programmes_classe)
    {
        $data = $request->validate([
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'classe_id' => ['required', 'exists:classes,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'coefficient' => ['required', 'numeric', 'gt:0'],
        ]);

        $exists = ProgrammeClasse::where('annee_scolaire_id', $data['annee_scolaire_id'])
            ->where('classe_id', $data['classe_id'])
            ->where('matiere_id', $data['matiere_id'])
            ->where('id', '!=', $programmes_classe->id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['matiere_id' => 'Cette matière existe déjà dans ce programme.']);
        }

        $programmes_classe->update($data);

        return redirect()->route('director.programmes-classes.index')
            ->with('success', 'Programme modifié.');
    }

    public function destroy(ProgrammeClasse $programmes_classe)
    {
        if ($programmes_classe->anneeScolaire->inscriptions()->exists()) {
            return back()->with('error', 'Vérifie les données scolaires avant de supprimer ce programme.');
        }

        $programmes_classe->delete();

        return redirect()->route('director.programmes-classes.index')
            ->with('success', 'Programme supprimé.');
    }
}
