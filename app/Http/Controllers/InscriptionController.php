<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with([
            'eleve',
            'classe',
            'anneeScolaire'
        ])->latest()->paginate(15);

        return view('inscriptions.index', compact('inscriptions'));
    }

    public function create()
    {
        $eleves = Eleve::orderBy('nom')->get();
        $classes = Classe::orderBy('nom')->get();
        $annees = AnneeScolaire::orderByDesc('date_debut')->get();

        return view('inscriptions.create', compact(
            'eleves',
            'classes',
            'annees'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'eleve_id' => ['required', 'exists:eleves,id'],
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'classe_id' => ['required', 'exists:classes,id'],
            'numero_inscription' => ['required', 'string', 'max:50'],
            'date_inscription' => ['required', 'date'],
        ]);

        $exists = Inscription::where('eleve_id', $data['eleve_id'])
            ->where('annee_scolaire_id', $data['annee_scolaire_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'eleve_id' => 'Cet élève possède déjà une inscription pour cette année scolaire.',
            ]);
        }

        Inscription::create($data);

        return redirect()->route('director.inscriptions.index')
            ->with('success', 'Inscription enregistrée.');
    }

    public function show(Inscription $inscription)
    {
        $inscription->load([
            'eleve',
            'classe',
            'anneeScolaire',
            'bulletins',
            'decisionScolaire',
        ]);

        return view('inscriptions.show', compact('inscription'));
    }

    public function edit(Inscription $inscription)
    {
        $classes = Classe::orderBy('nom')->get();

        return view('inscriptions.edit', compact('inscription', 'classes'));
    }

    public function update(Request $request, Inscription $inscription)
    {
        // L'élève et l'année restent inchangés pour préserver l'historique.
        $data = $request->validate([
            'classe_id' => ['required', 'exists:classes,id'],
            'numero_inscription' => [
                'required',
                'string',
                'max:50',
                Rule::unique('inscriptions', 'numero_inscription')
                    ->ignore($inscription->id),
            ],
            'date_inscription' => ['required', 'date'],
        ]);

        if ($inscription->bulletins()->where('statut', 'valide')->exists()) {
            return back()->with(
                'error',
                'Cette inscription possède un bulletin validé. Toute modification doit suivre une procédure contrôlée.'
            );
        }

        $inscription->update($data);

        return redirect()->route('director.inscriptions.index')
            ->with('success', 'Inscription modifiée.');
    }

    public function destroy(Inscription $inscription)
    {
        if (
            $inscription->notes()->exists()
            || $inscription->bulletins()->exists()
            || $inscription->decisionScolaire()->exists()
        ) {
            return back()->with(
                'error',
                'Cette inscription possède un historique scolaire et ne peut pas être supprimée.'
            );
        }

        $inscription->delete();

        return redirect()->route('director.inscriptions.index')
            ->with('success', 'Inscription supprimée.');
    }
}
