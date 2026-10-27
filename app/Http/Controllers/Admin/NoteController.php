<?php

namespace App\Http\Controllers\Admin;

use App\Models\Note;
use App\Models\Inscription;
use App\Models\Periode;
use App\Models\Matiere;
use App\Models\ProgrammeClasse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with([
            'inscription.eleve',
            'inscription.classe',
            'periode',
            'matiere',
        ])->latest()->paginate(20);

        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        $inscriptions = Inscription::with('eleve', 'classe')
            ->get();

        $periodes = Periode::where('cloturee', false)->get();
        $matieres = Matiere::orderBy('nom')->get();

        return view('notes.create', compact(
            'inscriptions', 'periodes', 'matieres'
        ));
    }

    private function validerContexte(array $data): void
    {
        $inscription = Inscription::with('classe')
            ->findOrFail($data['inscription_id']);

        $periode = Periode::findOrFail($data['periode_id']);

        if ($inscription->annee_scolaire_id !== $periode->annee_scolaire_id) {
            abort(422, 'La période ne correspond pas à l’année scolaire de l’inscription.');
        }

        $programmeExiste = ProgrammeClasse::where(
            'annee_scolaire_id',
            $inscription->annee_scolaire_id
        )
            ->where('classe_id', $inscription->classe_id)
            ->where('matiere_id', $data['matiere_id'])
            ->exists();

        if (! $programmeExiste) {
            abort(422, 'Cette matière ne figure pas au programme de la classe.');
        }

        if ($periode->cloturee) {
            abort(422, 'Cette période est clôturée.');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inscription_id' => ['required', 'exists:inscriptions,id'],
            'periode_id' => ['required', 'exists:periodes,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'interrogation_1' => ['required', 'numeric', 'min:0', 'max:20'],
            'interrogation_2' => ['required', 'numeric', 'min:0', 'max:20'],
            'devoir' => ['required', 'numeric', 'min:0', 'max:20'],
            'composition' => ['required', 'numeric', 'min:0', 'max:20'],
        ]);

        $this->validerContexte($data);

        $exists = Note::where('inscription_id', $data['inscription_id'])
            ->where('periode_id', $data['periode_id'])
            ->where('matiere_id', $data['matiere_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'matiere_id' => 'Les notes de cette matière sont déjà enregistrées pour cette période.',
            ]);
        }

        Note::create($data);

        return redirect()->route('director.notes.index')
            ->with('success', 'Notes enregistrées.');
    }

    public function edit(Note $note)
    {
        if ($note->periode->cloturee) {
            return back()->with('error', 'Cette période est clôturée.');
        }

        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        if ($note->periode->cloturee) {
            return back()->with('error', 'Cette période est clôturée.');
        }

        $data = $request->validate([
            'interrogation_1' => ['required', 'numeric', 'min:0', 'max:20'],
            'interrogation_2' => ['required', 'numeric', 'min:0', 'max:20'],
            'devoir' => ['required', 'numeric', 'min:0', 'max:20'],
            'composition' => ['required', 'numeric', 'min:0', 'max:20'],
        ]);

        $bulletinValide = DB::table('bulletins')
            ->where('inscription_id', $note->inscription_id)
            ->where('periode_id', $note->periode_id)
            ->where('statut', 'valide')
            ->exists();

        if ($bulletinValide) {
            return back()->with('error',
                'Un bulletin est déjà validé pour cette période. Une rectification contrôlée est nécessaire.'
            );
        }

        $note->update($data);

        return redirect()->route('director.notes.index')
            ->with('success', 'Notes modifiées.');
    }

    public function destroy(Note $note)
    {
        if ($note->periode->cloturee) {
            return back()->with('error', 'Cette période est clôturée.');
        }

        $bulletinValide = DB::table('bulletins')
            ->where('inscription_id', $note->inscription_id)
            ->where('periode_id', $note->periode_id)
            ->where('statut', 'valide')
            ->exists();

        if ($bulletinValide) {
            return back()->with('error',
                'Impossible de supprimer une note utilisée dans un bulletin validé.'
            );
        }

        $note->delete();

        return redirect()->route('director.notes.index')
            ->with('success', 'Note supprimée.');
    }
}
