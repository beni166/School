<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Classe;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::with('niveau.cycle')
            ->orderBy('nom')
            ->paginate(15);

        return view('secretariat.Classe.index', compact('classes'));
    }

    public function create()
    {
        $niveaux = Niveau::with('cycle')->orderBy('nom')->get();

        return view('secretariat.Classe.create', compact('niveaux'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'niveau_id' => ['required', 'exists:niveaux,id'],
        ]);

        Classe::create($data);

        return redirect()->route('secretariat.classes.index')
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

        return view('secretariat.Classe.show', ['classe' => $class]);
    }


    public function edit(Classe $class)
    {
        $niveaux = Niveau::with('cycle')
            ->orderBy('nom')
            ->get();

        return view('secretariat.Classe.edit', [
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

        return redirect()->route('secretariat.classes.index')
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

        return redirect()->route('secretariat.classes.index')
            ->with('success', 'Classe supprimée.');
    }
}
