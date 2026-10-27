<?php

namespace App\Http\Controllers\Secretary;

use App\Models\AffectationProfesseur;
use App\Http\Controllers\Controller;
use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use Illuminate\Http\Request;

class AffectationProfesseurController extends Controller
{
    public function index()
    {
        $affectations = AffectationProfesseur::with([
            'anneeScolaire', 'classe', 'matiere', 'professeur'
        ])->paginate(15);

        return view('secretariat.AffectationsProf.index', compact('affectations'));
    }

    public function create()
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        $matieres = Matiere::orderBy('nom')->get();
        $professeurs = Professeur::orderBy('nom')->get();

        return view('secretariat.AffectationsProf.create', compact(
            'annees', 'classes', 'matieres', 'professeurs'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'classe_id' => ['required', 'exists:classes,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'professeur_id' => ['required', 'exists:professeurs,id'],
        ]);

        $exists = AffectationProfesseur::where('annee_scolaire_id', $data['annee_scolaire_id'])
            ->where('classe_id', $data['classe_id'])
            ->where('matiere_id', $data['matiere_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'matiere_id' => 'Un professeur est déjà affecté à cette matière, dans cette classe et cette année.',
            ]);
        }

        AffectationProfesseur::create($data);

        return redirect()->route('secretary.affectations.index')
            ->with('success', 'Affectation créée.');
    }

    public function show(AffectationProfesseur $affectation)
    {
        $affectation->load('anneeScolaire', 'classe', 'matiere', 'professeur');

        return view('secretariat.AffectationsProf.show', compact('affectation'));
    }

    public function edit(AffectationProfesseur $affectation)
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        $matieres = Matiere::orderBy('nom')->get();
        $professeurs = Professeur::orderBy('nom')->get();

        return view('secretariat.AffectationsProf.edit', compact(
            'affectation', 'annees', 'classes', 'matieres', 'professeurs'
        ));
    }

    public function update(Request $request, AffectationProfesseur $affectation)
    {
        $data = $request->validate([
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'classe_id' => ['required', 'exists:classes,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'professeur_id' => ['required', 'exists:professeurs,id'],
        ]);

        $exists = AffectationProfesseur::where('annee_scolaire_id', $data['annee_scolaire_id'])
            ->where('classe_id', $data['classe_id'])
            ->where('matiere_id', $data['matiere_id'])
            ->where('id', '!=', $affectation->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'matiere_id' => 'Cette matière possède déjà une affectation pour cette classe et cette année.',
            ]);
        }

        $affectation->update($data);

        return redirect()->route('secretary.affectations.index')
            ->with('success', 'Affectation modifiée.');
    }

    public function destroy(AffectationProfesseur $affectation)
    {
        $affectation->delete();

        return redirect()->route('secretary.affectations.index')
            ->with('success', 'Affectation supprimée.');
    }
}
