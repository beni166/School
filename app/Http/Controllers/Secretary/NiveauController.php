<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Cycle;
use App\Models\Niveau;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NiveauController extends Controller
{
    public function index()
    {
        $niveaux = Niveau::with('cycle', 'classes')
            ->orderBy('nom')
            ->paginate(15);

        return view('secretariat.Niveau.index', compact('niveaux'));
    }

    public function create()
    {
        $cycles = Cycle::orderBy('nom')->get();

        return view('secretariat.Niveau.create', compact('cycles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'ordre' => ['nullable', 'integer', 'min:0'],
            'cycle_id' => ['required', 'exists:cycles,id'],
        ]);
        Niveau::create($data);

        return redirect()->route('director.niveau.index')
            ->with('success', 'Niveau créé.');
    }

    public function show(Niveau $niveau)
    {
        $niveau->load('cycle', 'classes');

        return view('secretariat.Niveau.show', compact('niveau'));
    }

    public function edit(Niveau $niveau)
    {
        $cycles = Cycle::orderBy('nom')->get();

        return view('secretariat.Niveau.edit', compact('niveau', 'cycles'));
    }

    public function update(Request $request, Niveau $niveau)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'cycle_id' => ['required', 'exists:cycles,id'],
        ]);

        $niveau->update($data);

        return redirect()->route('secretariat.niveaux.index')
            ->with('success', 'Niveau modifié.');
    }

    public function destroy(Niveau $niveau)
    {
        if ($niveau->classes()->exists()) {
            return back()->with(
                'error',
                'Impossible de supprimer un niveau qui possède des classes.'
            );
        }

        $niveau->delete();

        return redirect()->route('secretariat.niveaux.index')
            ->with('success', 'Niveau supprimé.');
    }
}
