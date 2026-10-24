<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CycleController extends Controller
{
    public function index()
    {
        $cycles = Cycle::with('niveaux')
            ->orderBy('nom')
            ->paginate(15);

        return view('cycle.index', compact('cycles'));
    }

    public function create()
    {
        return view('cycle.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100', 'unique:cycles,nom'],
        ]);

        Cycle::create($data);

        return redirect()->route('director.cycle.index')
            ->with('success', 'Cycle créé.');
    }

    public function show(Cycle $cycle)
    {
        $cycle->load('niveaux.classes');

        return view('cycle.show', compact('cycle'));
    }

    public function edit(Cycle $cycle)
    {
        return view('cycle.edit', compact('cycle'));
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

        return redirect()->route('director.cycle.index')
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

        return redirect()->route('director.cycle.index')
            ->with('success', 'Cycle supprimé.');
    }
}
