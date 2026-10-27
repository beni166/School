<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Periode;
use App\Models\AnneeScolaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::with('anneeScolaire')
            ->orderBy('numero')
            ->paginate(15);

        return view('secretariat.Periode.index', compact('periodes'));
    }

    public function create()
    {
        $annees = AnneeScolaire::all();

        return view('secretariat.Periode.create', compact('annees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'type' => ['required', 'in:trimestre,semestre'],
            'numero' => ['required', 'integer', 'min:1', 'max:3'],
            'libelle' => ['required', 'string', 'max:100'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
        ]);

        if ($data['type'] === 'semestre' && $data['numero'] > 2) {
            return back()->withInput()->withErrors([
                'numero' => 'Un système semestriel comporte au maximum deux semestres.',
            ]);
        }

        $exists = Periode::where('annee_scolaire_id', $data['annee_scolaire_id'])
            ->where('type', $data['type'])
            ->where('numero', $data['numero'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'numero' => 'Cette période existe déjà pour cette année scolaire.',
            ]);
        }

        Periode::create($data);

        return redirect()->route('secretariat.periodes.index')
            ->with('success', 'Période créée.');
    }

    public function show(Periode $periode)
    {
        $periode->load('anneeScolaire');

        return view('secretariat.Periode.show', compact('periode'));
    }

    public function edit(Periode $periode)
    {
        $annees = AnneeScolaire::all();

        return view('secretariat.Periode.edit', compact('periode', 'annees'));
    }

    public function update(Request $request, Periode $periode)
    {
        if ($periode->cloturee) {
            return back()->with('error', 'Une période clôturée ne peut plus être modifiée.');
        }

        $data = $request->validate([
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'type' => ['required', 'in:trimestre,semestre'],
            'numero' => ['required', 'integer', 'min:1', 'max:3'],
            'libelle' => ['required', 'string', 'max:100'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
        ]);

        if ($data['type'] === 'semestre' && $data['numero'] > 2) {
            return back()->withInput()->withErrors([
                'numero' => 'Un semestre porte le numéro 1 ou 2.',
            ]);
        }

        $periode->update($data);

        return redirect()->route('secretariat.periodes.index')
            ->with('success', 'Période modifiée.');
    }

    public function destroy(Periode $periode)
    {
        if ($periode->notes()->exists() || $periode->bulletins()->exists()) {
            return back()->with('error', 'Cette période est déjà utilisée.');
        }

        $periode->delete();

        return redirect()->route('secretariat.periodes.index')
            ->with('success', 'Période supprimée.');
    }
}
