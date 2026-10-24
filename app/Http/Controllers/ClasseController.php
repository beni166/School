<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::with('niveau.cycle')
            ->orderBy('nom')
            ->paginate(15);

        return view('classe.index', compact('classes'));
    }

    public function create()
    {
        $niveaux = Niveau::with('cycle')->orderBy('nom')->get();

        return view('classe.create', compact('niveaux'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'niveau_id' => ['required', 'exists:niveaux,id'],
        ]);

        Classe::create($data);

        return redirect()->route('director.classes.index')
            ->with('success', 'Classe créée avec succès.');
    }

    public function show(Classe $class)
    {
        $class->load([
            'niveau.cycle',
            'inscriptions.eleve',
            'programmesClasses.matiere',
            'affectations.professeur',
            'affectations.matiere',
        ]);

        return view('classe.show', ['classe' => $class]);
    }


    public function edit(Classe $class)
    {
        $niveaux = Niveau::with('cycle')
            ->orderBy('nom')
            ->get();

        return view('classe.edit', [
            'classes' => $class,
            'niveaux' => $niveaux,
        ]);
    }

    public function update(Request $request, Classe $class)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'niveau_id' => ['required', 'exists:niveaux,id'],
        ]);

        $class->update($data);

        return redirect()->route('director.classes.index')
            ->with('success', 'Classe modifiée avec succès.');
    }


    public function destroy(Classe $class)
    {
        if (
            $class->inscriptions()->exists()
            || $class->programmesClasses()->exists()
            || $class->affectations()->exists()
        ) {
            return back()->with(
                'error',
                'Cette classe est utilisée dans l’historique scolaire.'
            );
        }

        $class->delete();

        return redirect()->route('director.classes.index')
            ->with('success', 'Classe supprimée.');
    }
}
