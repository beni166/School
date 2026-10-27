<?php

namespace App\Http\Controllers\Secretary;
use App\Http\Controllers\Controller;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MatiereController extends Controller
{
    public function index()
    {
        $matieres = Matiere::orderBy('nom')->paginate(15);

        return view('secretariat.Matiere.index', compact('matieres'));
    }

    public function create()
    {
        return view('secretariat.Matiere.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100', 'unique:matieres,nom'],
            'code' => ['required', 'string', 'max:10', 'unique:matieres,code'],
        ]);

        Matiere::create($data);

        return redirect()->route('secretariat.matieres.index')
            ->with('success', 'Matière créée.');
    }

    public function show(Matiere $matiere)
    {
        $matiere->load('programmesClasses', 'affectations');

        return view('secretariat.Matiere.show', compact('matiere'));
    }



    public function edit(Matiere $matiere)
    {
        return view('secretariat.Matiere.edit', compact('matiere'));
    }

    public function update(Request $request, Matiere $matiere)
    {
        $data = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:100',
                Rule::unique('matieres', 'nom')->ignore($matiere->id),
            ],
        ]);

        $matiere->update($data);

        return redirect()->route('secretariat.matieres.index')
            ->with('success', 'Matière modifiée avec succès.');
    }


    public function destroy(Matiere $matiere)
    {
        if (
            $matiere->notes()->exists()
            || $matiere->programmesClasses()->exists()
            || $matiere->affectations()->exists()
        ) {
            return back()->with('error', 'Cette matière est utilisée dans des données scolaires.');
        }

        $matiere->delete();

        return redirect()->route('secretariat.matieres.index')
            ->with('success', 'Matière supprimée.');
    }
}
