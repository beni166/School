<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\BulletinDetail;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BulletinDetailController extends Controller
{
    /**
     * Afficher les détails d'un bulletin.
     */
    public function index(Bulletin $bulletin)
    {
        $details = $bulletin->details()
            ->orderBy('matiere_libelle')
            ->paginate(20);

        return view('bulletin-details.index', compact(
            'bulletin',
            'details'
        ));
    }

    /**
     * Afficher le formulaire de création d'un détail.
     */
    public function create(Bulletin $bulletin)
    {
        $this->verifierBrouillon($bulletin);

        $matieres = Matiere::orderBy('nom')->get();

        return view('bulletin-details.create', compact(
            'bulletin',
            'matieres'
        ));
    }

    /**
     * Enregistrer un détail de bulletin.
     */
    public function store(Request $request, Bulletin $bulletin)
    {
        $this->verifierBrouillon($bulletin);

        $validated = $request->validate([
            'matiere_id' => [
                'required',
                'integer',
                'exists:matieres,id',
                Rule::unique('bulletin_details', 'matiere_id')
                    ->where(fn($query) => $query->where(
                        'bulletin_id',
                        $bulletin->id
                    )),
            ],

            'professeur_libelle' => [
                'nullable',
                'string',
                'max:255',
            ],

            'interrogation_1' => ['required', 'numeric', 'min:0', 'max:20'],
            'interrogation_2' => ['required', 'numeric', 'min:0', 'max:20'],
            'devoir' => ['required', 'numeric', 'min:0', 'max:20'],
            'composition' => ['required', 'numeric', 'min:0', 'max:20'],
            'coefficient' => ['required', 'numeric', 'gt:0'],

            'rang_matiere' => ['nullable', 'integer', 'min:1'],
            'appreciation' => ['nullable', 'string'],
        ], [
            'matiere_id.required' => 'Veuillez sélectionner une matière.',
            'matiere_id.exists' => 'La matière sélectionnée est introuvable.',
            'matiere_id.unique' => 'Cette matière possède déjà un détail dans ce bulletin.',

            'interrogation_1.required' => 'La première interrogation est obligatoire.',
            'interrogation_2.required' => 'La deuxième interrogation est obligatoire.',
            'devoir.required' => 'Le devoir est obligatoire.',
            'composition.required' => 'La composition est obligatoire.',

            '*.numeric' => 'Cette valeur doit être numérique.',
            '*.min' => 'La note ne peut pas être négative.',
            '*.max' => 'Une note ne peut pas dépasser 20.',
            'coefficient.gt' => 'Le coefficient doit être supérieur à zéro.',
        ]);

        DB::transaction(function () use ($validated, $bulletin) {
            $matiere = Matiere::findOrFail($validated['matiere_id']);

            // Calcul de la moyenne de la matière :
            // (interrogation 1 + interrogation 2 + devoir + composition) / 4
            $moyenne = (
                $validated['interrogation_1']
                + $validated['interrogation_2']
                + $validated['devoir']
                + $validated['composition']
            ) / 4;

            $coefficient = $validated['coefficient'];

            // Points obtenus après application du coefficient.
            $points = $moyenne * $coefficient;

            $bulletin->details()->create([
                'matiere_id' => $matiere->id,
                'matiere_libelle' => $matiere->nom,
                'professeur_libelle' => $validated['professeur_libelle'] ?? null,

                'interrogation_1' => $validated['interrogation_1'],
                'interrogation_2' => $validated['interrogation_2'],
                'devoir' => $validated['devoir'],
                'composition' => $validated['composition'],

                'coefficient' => $coefficient,
                'moyenne_matiere' => round($moyenne, 2),
                'points_coefficientes' => round($points, 2),

                // Le rang sera calculé lorsque les résultats
                // de la classe seront disponibles.
                'rang_matiere' => $validated['rang_matiere'] ?? null,
                'appreciation' => $validated['appreciation'] ?? null,
            ]);
        });

        return redirect()
            ->route('director.bulletins-details.index', $bulletin)
            ->with('success', 'Le détail de la matière a été ajouté avec succès.');
    }

    /**
     * Afficher un détail de bulletin.
     */
    public function show(Bulletin $bulletin, BulletinDetail $detail)
    {
        $this->verifierAppartenance($bulletin, $detail);

        return view('bulletin-details.show', compact(
            'bulletin',
            'detail'
        ));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Bulletin $bulletin, BulletinDetail $detail)
    {
        $this->verifierAppartenance($bulletin, $detail);
        $this->verifierBrouillon($bulletin);

        $matieres = Matiere::orderBy('nom')->get();

        return view('bulletin-details.edit', compact(
            'bulletin',
            'detail',
            'matieres'
        ));
    }

    /**
     * Mettre à jour un détail.
     */
    public function update(
        Request $request,
        Bulletin $bulletin,
        BulletinDetail $detail
    ) {
        $this->verifierAppartenance($bulletin, $detail);
        $this->verifierBrouillon($bulletin);

        $validated = $request->validate([
            'matiere_id' => [
                'required',
                'integer',
                'exists:matieres,id',
                Rule::unique('bulletin_details', 'matiere_id')
                    ->where(fn($query) => $query->where(
                        'bulletin_id',
                        $bulletin->id
                    ))
                    ->ignore($detail->id),
            ],

            'professeur_libelle' => [
                'nullable',
                'string',
                'max:255',
            ],

            'interrogation_1' => ['required', 'numeric', 'min:0', 'max:20'],
            'interrogation_2' => ['required', 'numeric', 'min:0', 'max:20'],
            'devoir' => ['required', 'numeric', 'min:0', 'max:20'],
            'composition' => ['required', 'numeric', 'min:0', 'max:20'],
            'coefficient' => ['required', 'numeric', 'gt:0'],

            'rang_matiere' => ['nullable', 'integer', 'min:1'],
            'appreciation' => ['nullable', 'string'],
        ], [
            'matiere_id.required' => 'Veuillez sélectionner une matière.',
            'matiere_id.exists' => 'La matière sélectionnée est introuvable.',
            'matiere_id.unique' => 'Cette matière possède déjà un détail dans ce bulletin.',

            '*.numeric' => 'Cette valeur doit être numérique.',
            '*.min' => 'La note ne peut pas être négative.',
            '*.max' => 'Une note ne peut pas dépasser 20.',
            'coefficient.gt' => 'Le coefficient doit être supérieur à zéro.',
        ]);

        DB::transaction(function () use ($validated, $detail) {
            $matiere = Matiere::findOrFail($validated['matiere_id']);

            $moyenne = (
                $validated['interrogation_1']
                + $validated['interrogation_2']
                + $validated['devoir']
                + $validated['composition']
            ) / 4;

            $coefficient = $validated['coefficient'];

            $detail->update([
                'matiere_id' => $matiere->id,
                'matiere_libelle' => $matiere->nom,
                'professeur_libelle' => $validated['professeur_libelle'] ?? null,

                'interrogation_1' => $validated['interrogation_1'],
                'interrogation_2' => $validated['interrogation_2'],
                'devoir' => $validated['devoir'],
                'composition' => $validated['composition'],

                'coefficient' => $coefficient,
                'moyenne_matiere' => round($moyenne, 2),
                'points_coefficientes' => round($moyenne * $coefficient, 2),

                'rang_matiere' => $validated['rang_matiere'] ?? null,
                'appreciation' => $validated['appreciation'] ?? null,
            ]);
        });

        return redirect()
            ->route('director.bulletins-details.index', $bulletin)
            ->with('success', 'Le détail du bulletin a été modifié avec succès.');
    }

    /**
     * Supprimer un détail.
     */
    public function destroy(Bulletin $bulletin, BulletinDetail $detail)
    {
        $this->verifierAppartenance($bulletin, $detail);
        $this->verifierBrouillon($bulletin);

        $detail->delete();

        return redirect()
            ->route('director.bulletins-details.index', $bulletin)
            ->with('success', 'Le détail du bulletin a été supprimé avec succès.');
    }

    /**
     * Vérifier que le détail appartient au bulletin.
     */
    private function verifierAppartenance(
        Bulletin $bulletin,
        BulletinDetail $detail
    ): void {
        abort_unless(
            (int) $detail->bulletin_id === (int) $bulletin->id,
            404
        );
    }

    /**
     * Empêcher les modifications des bulletins validés.
     */
    private function verifierBrouillon(Bulletin $bulletin): void
    {
        abort_if(
            $bulletin->statut === 'valide',
            403,
            'Les détails d’un bulletin validé ne peuvent plus être modifiés.'
        );
    }
}
