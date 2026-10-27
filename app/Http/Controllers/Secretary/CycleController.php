<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Cycle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CycleController extends Controller
{
    public function index()
    {
        $cycles = Cycle::with('niveaux')
            ->orderBy('nom')
            ->paginate(15);

        return view('secretariat.Cycle.index', compact('cycles'));
    }

    public function create()
    {
        return view('secretariat.Cycle.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100', 'unique:cycles,nom'],
        ]);

        Cycle::create($data);

        return redirect()->route('secretariat.cycles.index')
            ->with('success', 'Cycle créé.');
    }

    public function show(Cycle $cycle)
    {
        $cycle->load('niveaux.classes');

        return view('secretariat.Cycle.show', compact('cycle'));
    }

    public function edit(Cycle $cycle)
    {
        return view('secretariat.Cycle.edit', compact('cycle'));
    }

    public function update(Request $request, Cycle $cycle)
    {
        $data = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cycles', 'nom')->ignore($cycle->id),
            ],
        ]);

        $cycle->update($data);

        return redirect()->route('secretariat.cycles.index')
            ->with('success', 'Cycle modifié.');
    }

    public function destroy(Cycle $cycle)
    {
        if ($cycle->niveaux()->exists()) {
            return back()->with(
                'error',
                'Impossible de supprimer un cycle qui contient des niveaux.'
            );
        }

        $cycle->delete();

        return redirect()->route('secretariat.cycles.index')
            ->with('success', 'Cycle supprimé.');
    }
}
