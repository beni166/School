<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\DecisionScolaire;
use App\Models\Inscription;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DecisionScolaireController extends Controller
{
    public function index()
    {
        $decisions = DecisionScolaire::with([
            'inscription.eleve',
            'inscription.classe',
            'classeSuivante',
        ])->latest()->paginate(15);

        return view('secretariat.DecisionScolaire.index', compact('decisions'));
    }

    public function create()
    {
        $inscriptions = Inscription::with('eleve', 'classe')
            ->get();

        $classes = Classe::orderBy('nom')->get();

        return view('secretariat.DecisionScolaire.create', compact(
            'inscriptions', 'classes'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inscription_id' => [
                'required',
                'exists:inscriptions,id',
                'unique:decisions_scolaires,inscription_id',
            ],
            'decision' => [
                'required',
                Rule::in(['admis', 'ajourne', 'redoublement', 'transfert']),
            ],
            'classe_suivante_id' => [
                'nullable',
                'exists:classes,id',
            ],
            'observation' => ['nullable', 'string', 'max:1000'],
        ]);

        if (in_array($data['decision'], ['admis', 'redoublement'])
            && empty($data['classe_suivante_id'])) {
            return back()->withInput()->withErrors([
                'classe_suivante_id' => 'Sélectionne la classe suivante ou la classe de redoublement.',
            ]);
        }

        DecisionScolaire::create($data);

        return redirect()->route('secretariat.decisions-scolaires.index')
            ->with('success', 'Décision scolaire enregistrée.');
    }

    public function show(DecisionScolaire $decisionScolaire)
    {
        $decisionScolaire->load([
            'inscription.eleve',
            'inscription.classe',
            'classeSuivante',
        ]);

        return view('secretariat.DecisionScolaire.show', [
            'decision' => $decisionScolaire,
        ]);
    }

    public function edit(DecisionScolaire $decisionScolaire)
    {
        $classes = Classe::orderBy('nom')->get();

        return view('secretariat.DecisionScolaire.edit', [
            'decision' => $decisionScolaire,
            'classes' => $classes,
        ]);
    }

    public function update(
        Request $request,
        DecisionScolaire $decisionScolaire
    ) {
        $data = $request->validate([
            'decision' => [
                'required',
                Rule::in(['admis', 'ajourne', 'redoublement', 'transfert']),
            ],
            'classe_suivante_id' => [
                'nullable',
                'exists:classes,id',
            ],
            'observation' => ['nullable', 'string', 'max:1000'],
        ]);

        if (in_array($data['decision'], ['admis', 'redoublement'])
            && empty($data['classe_suivante_id'])) {
            return back()->withInput()->withErrors([
                'classe_suivante_id' => 'Une classe doit être sélectionnée.',
            ]);
        }

        $decisionScolaire->update($data);

        return redirect()->route('secretariat.decisions-scolaires.index')
            ->with('success', 'Décision modifiée.');
    }

    public function destroy(DecisionScolaire $decisionScolaire)
    {
        $decisionScolaire->delete();

        return redirect()->route('secretariat.decisions-scolaires.index')
            ->with('success', 'Décision supprimée.');
    }
}
