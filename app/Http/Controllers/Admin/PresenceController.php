<?php

namespace App\Http\Controllers\Admin;

use App\Models\Presence;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PresenceController extends Controller
{
    /**
     * Liste des présences avec filtres.
     */
    public function index(Request $request)
    {
        $query = Presence::with([
            'inscription.eleve',
            'inscription.classe',
            'inscription.anneeScolaire',
        ]);

        if ($request->filled('date')) {
            $query->whereDate('date_presence', $request->date);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('inscription_id')) {
            $query->where(
                'inscription_id',
                $request->inscription_id
            );
        }

        $presences = $query
            ->orderByDesc('date_presence')
            ->paginate(15)
            ->withQueryString();

        return view('presences.index', compact('presences'));
    }

    /**
     * Formulaire d'enregistrement.
     */
    public function create()
    {
        $inscriptions = Inscription::with([
            'eleve',
            'classe',
            'anneeScolaire',
        ])
            ->get()
            ->sortBy(function ($inscription) {
                return $inscription->eleve->nom ?? '';
            });

        return view('presences.create', compact('inscriptions'));
    }

    /**
     * Enregistrement d'une présence ou absence.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'inscription_id' => [
                'required',
                'integer',
                'exists:inscriptions,id',
            ],

            'date_presence' => [
                'required',
                'date',
            ],

            'statut' => [
                'required',
                Rule::in([
                    'present',
                    'absent',
                    'retard',
                    'absence_justifiee',
                ]),
            ],

            'heure_arrivee' => [
                'nullable',
                'date_format:H:i',
            ],

            'motif' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $existe = Presence::where(
            'inscription_id',
            $data['inscription_id']
        )
            ->whereDate('date_presence', $data['date_presence'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'inscription_id' =>
                        'Un appel est déjà enregistré pour cet élève à cette date.',
                ]);
        }

        $data['enregistre_par'] = auth()->id();

        Presence::create($data);

        return redirect()
            ->route('director.presences.index')
            ->with('success', 'La présence a été enregistrée.');
    }

    /**
     * Consultation d'un enregistrement.
     */
    public function show(Presence $presence)
    {
        $presence->load([
            'inscription.eleve',
            'inscription.classe',
            'inscription.anneeScolaire',
            'utilisateur',
        ]);

        return view('presences.show', compact('presence'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Presence $presence)
    {
        $presence->load([
            'inscription.eleve',
            'inscription.classe',
        ]);

        return view('presences.edit', compact('presence'));
    }

    /**
     * Modification d'un enregistrement.
     */
    public function update(Request $request, Presence $presence)
    {
        $data = $request->validate([
            'statut' => [
                'required',
                Rule::in([
                    'present',
                    'absent',
                    'retard',
                    'absence_justifiee',
                ]),
            ],

            'heure_arrivee' => [
                'nullable',
                'date_format:H:i',
            ],

            'motif' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $presence->update($data);

        return redirect()
            ->route('director.presences.index')
            ->with('success', 'L’enregistrement a été modifié.');
    }

    /**
     * Suppression d'un enregistrement erroné.
     */
    public function destroy(Presence $presence)
    {
        $presence->delete();

        return redirect()
            ->route('director.presences.index')
            ->with('success', 'L’enregistrement a été supprimé.');
    }

    /**
     * Enregistrement de l'appel pour toute une classe.
     *
     * Le formulaire doit envoyer :
     * date_presence et presences[INSCRIPTION_ID][statut],
     * éventuellement heure_arrivee et motif.
     */
    public function enregistrerAppel(Request $request)
    {
        $data = $request->validate([
            'date_presence' => [
                'required',
                'date',
            ],

            'presences' => [
                'required',
                'array',
                'min:1',
            ],

            'presences.*.inscription_id' => [
                'required',
                'integer',
                'exists:inscriptions,id',
            ],

            'presences.*.statut' => [
                'required',
                Rule::in([
                    'present',
                    'absent',
                    'retard',
                    'absence_justifiee',
                ]),
            ],

            'presences.*.heure_arrivee' => [
                'nullable',
                'date_format:H:i',
            ],

            'presences.*.motif' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use ($data) {
            foreach ($data['presences'] as $ligne) {
                $inscriptionId = $ligne['inscription_id'];

                Presence::updateOrCreate(
                    [
                        'inscription_id' => $inscriptionId,
                        'date_presence' => $data['date_presence'],
                    ],
                    [
                        'statut' => $ligne['statut'],
                        'heure_arrivee' => $ligne['heure_arrivee'] ?? null,
                        'motif' => $ligne['motif'] ?? null,
                        'enregistre_par' => auth()->id(),
                    ]
                );
            }
        });

        return redirect()
            ->route('director.presences.index', [
                'date' => $data['date_presence'],
            ])
            ->with('success', 'L’appel de la classe a été enregistré.');
    }
}
