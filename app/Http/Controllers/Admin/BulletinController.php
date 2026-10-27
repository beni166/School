<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bulletin;
use App\Models\BulletinDetail;
use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\Periode;
use App\Models\ProgrammeClasse;
use App\Models\AffectationProfesseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BulletinController extends Controller
{
    /**
     * Liste des bulletins.
     */
    public function index()
    {
        $bulletins = Bulletin::with([
            'inscription.eleve',
            'inscription.classe',
            'inscription.anneeScolaire',
            'periode',
        ])
            ->latest()
            ->paginate(15);

        return view('bulletin.index', compact('bulletins'));
    }

    /**
     * Formulaire de création d'un bulletin.
     */
    public function create()
    {
        $inscriptions = Inscription::with([
            'eleve',
            'classe',
            'anneeScolaire',
        ])
            ->where('statut', 'inscrit')
            ->orderByDesc('id')
            ->get();

        $periodes = Periode::with('anneeScolaire')
            ->orderByDesc('id')
            ->get();

        return view('bulletin.create', compact(
            'inscriptions',
            'periodes'
        ));
    }

    /**
     * Enregistre un bulletin en brouillon.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => [
                'required',
                'integer',
                'exists:inscriptions,id',
            ],
            'periode_id' => [
                'required',
                'integer',
                'exists:periodes,id',
            ],
        ]);

        $inscription = Inscription::with([
            'eleve',
            'classe',
            'anneeScolaire',
        ])->findOrFail($validated['inscription_id']);

        $periode = Periode::findOrFail($validated['periode_id']);

        if (
            (int) $inscription->annee_scolaire_id
            !== (int) $periode->annee_scolaire_id
        ) {
            throw ValidationException::withMessages([
                'periode_id' =>
                'La période ne correspond pas à l’année scolaire de l’inscription.',
            ]);
        }

        if ($periode->cloturee) {
            throw ValidationException::withMessages([
                'periode_id' =>
                'Cette période est clôturée. Impossible de créer un bulletin.',
            ]);
        }

        $bulletin = Bulletin::firstOrCreate(
            [
                'inscription_id' => $inscription->id,
                'periode_id' => $periode->id,
            ],
            [
                'nom_eleve' => $inscription->eleve->nom,
                'prenom_eleve' => $inscription->eleve->prenom,
                'classe_libelle' => $inscription->classe->libelle
                    ?? $inscription->classe->nom,
                'annee_libelle' => $inscription->anneeScolaire->libelle,
                'statut' => 'brouillon',
            ]
        );

        if (
            $bulletin->wasRecentlyCreated === false
            && $bulletin->statut === 'valide'
        ) {
            return redirect()
                ->route('director.bulletins.show', $bulletin)
                ->with('info', 'Ce bulletin existe déjà et est validé.');
        }

        return redirect()
            ->route('director.bulletins.index', $bulletin)
            ->with('success', 'Bulletin créé en brouillon.');
    }

    /**
     * Affiche un bulletin.
     */
    public function show(Bulletin $bulletin)
    {
        $bulletin->load([
            'inscription.eleve',
            'inscription.classe',
            'inscription.anneeScolaire',
            'periode',
            'details.matiere',
            'details.professeur',
        ]);

        return view('bulletin.show', compact('bulletin'));
    }

    /**
     * Calcule et enregistre les détails d'un bulletin.
     */
    public function generer(Bulletin $bulletin)
    {
        if ($bulletin->statut === 'valide') {
            return back()->withErrors([
                'bulletin' => 'Un bulletin validé ne peut plus être régénéré.',
            ]);
        }

        $bulletin->load([
            'inscription.eleve',
            'inscription.classe',
            'inscription.anneeScolaire',
            'periode',
        ]);

        $inscription = $bulletin->inscription;
        $periode = $bulletin->periode;

        if (
            (int) $inscription->annee_scolaire_id
            !== (int) $periode->annee_scolaire_id
        ) {
            throw ValidationException::withMessages([
                'bulletin' => 'L’année scolaire de la période ne correspond pas à celle de l’inscription.',
            ]);
        }

        if ($periode->cloturee) {
            throw ValidationException::withMessages([
                'bulletin' => 'Cette période est clôturée.',
            ]);
        }

        $notes = $inscription->notes()
            ->where('periode_id', $periode->id)
            ->with('matiere')
            ->get();

        if ($notes->isEmpty()) {
            throw ValidationException::withMessages([
                'bulletin' => 'Aucune note n’a été enregistrée pour cette période.',
            ]);
        }

        DB::transaction(function () use (
            $bulletin,
            $inscription,
            $periode,
            $notes
        ) {
            $details = [];
            $totalPoints = 0;
            $totalCoefficients = 0;

            foreach ($notes as $note) {
                $scores = [
                    $note->interrogation_1,
                    $note->interrogation_2,
                    $note->devoir,
                    $note->composition,
                ];

                foreach ($scores as $score) {
                    if ($score === null) {
                        throw ValidationException::withMessages([
                            'bulletin' =>
                            'Toutes les notes doivent être renseignées avant de générer le bulletin.',
                        ]);
                    }

                    if (!is_numeric($score) || $score < 0 || $score > 20) {
                        throw ValidationException::withMessages([
                            'bulletin' =>
                            'Chaque note doit être comprise entre 0 et 20.',
                        ]);
                    }
                }

                $matiere = $note->matiere;

                if (!$matiere) {
                    throw ValidationException::withMessages([
                        'bulletin' => 'Une matière liée à une note est introuvable.',
                    ]);
                }

                $programme = ProgrammeClasse::where(
                    'annee_scolaire_id',
                    $inscription->annee_scolaire_id
                )
                    ->where('classe_id', $inscription->classe_id)
                    ->where('matiere_id', $note->matiere_id)
                    ->first();

                if (!$programme) {
                    throw ValidationException::withMessages([
                        'bulletin' =>
                        "Aucun coefficient n’est configuré pour la matière {$matiere->nom}.",
                    ]);
                }

                $coefficient = (float) $programme->coefficient;

                if ($coefficient <= 0) {
                    throw ValidationException::withMessages([
                        'bulletin' =>
                        "Le coefficient de {$matiere->nom} doit être supérieur à zéro.",
                    ]);
                }

                $moyenne = (
                    (float) $note->interrogation_1
                    + (float) $note->interrogation_2
                    + (float) $note->devoir
                    + (float) $note->composition
                ) / 4;

                $points = $moyenne * $coefficient;

                // Affectation du professeur pour cette classe,
                // cette matière et cette année scolaire.
                $affectation = AffectationProfesseur::with('professeur')
                    ->where(
                        'annee_scolaire_id',
                        $inscription->annee_scolaire_id
                    )
                    ->where('classe_id', $inscription->classe_id)
                    ->where('matiere_id', $note->matiere_id)
                    ->first();

                $professeur = $affectation?->professeur;

                $details[] = [
                    'bulletin_id' => $bulletin->id,
                    'matiere_id' => $matiere->id,
                    'professeur_id' => $professeur?->id,
                    'note_id' => $note->id,
                    'matiere_libelle' => $matiere->nom,
                    'professeur_libelle' => $professeur
                        ? trim($professeur->prenom . ' ' . $professeur->nom)
                        : null,
                    'interrogation_1' => $note->interrogation_1,
                    'interrogation_2' => $note->interrogation_2,
                    'devoir' => $note->devoir,
                    'composition' => $note->composition,
                    'coefficient' => $coefficient,
                    'moyenne_matiere' => round($moyenne, 2),
                    'points_coefficientes' => round($points, 2),
                    'rang_matiere' => null,
                    'appreciation' => $this->appreciation($moyenne),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $totalPoints += $points;
                $totalCoefficients += $coefficient;
            }

            if ($totalCoefficients <= 0) {
                throw ValidationException::withMessages([
                    'bulletin' => 'Impossible de calculer la moyenne générale.',
                ]);
            }

            // Les détails précédents sont remplacés uniquement
            // si le bulletin est encore en brouillon.
            $bulletin->details()->delete();

            BulletinDetail::insert($details);

            $moyenneGenerale = $totalPoints / $totalCoefficients;

            $bulletin->update([
                'nom_eleve' => $inscription->eleve->nom,
                'prenom_eleve' => $inscription->eleve->prenom,
                'classe_libelle' => $inscription->classe->libelle
                    ?? $inscription->classe->nom,
                'annee_libelle' => $inscription->anneeScolaire->libelle,
                'moyenne_generale' => round($moyenneGenerale, 2),
                'appreciation_generale' => $this->appreciation(
                    $moyenneGenerale
                ),
            ]);
        });

        return redirect()
            ->route('director.bulletins.show', $bulletin)
            ->with('success', 'Bulletin généré avec succès.');
    }

    /**
     * Valide définitivement un bulletin.
     */
    public function valider(Bulletin $bulletin)
    {
        if ($bulletin->statut === 'valide') {
            return back()->with('info', 'Ce bulletin est déjà validé.');
        }

        if (
            $bulletin->details()->count() === 0
            || $bulletin->moyenne_generale === null
        ) {
            return back()->withErrors([
                'bulletin' =>
                'Génère le bulletin avant de le valider.',
            ]);
        }

        if ($bulletin->periode()->value('cloturee')) {
            return back()->withErrors([
                'bulletin' =>
                'La période est clôturée. Vérifie les règles de validation de ton établissement.',
            ]);
        }

        $bulletin->update([
            'statut' => 'valide',
            'valide_le' => now(),
        ]);

        return redirect()
            ->route('director.bulletins.show', $bulletin)
            ->with('success', 'Bulletin validé avec succès.');
    }

    /**
     * Supprime uniquement un bulletin en brouillon.
     */
    public function destroy(Bulletin $bulletin)
    {
        if ($bulletin->statut === 'valide') {
            return back()->withErrors([
                'bulletin' => 'Un bulletin validé ne peut pas être supprimé.',
            ]);
        }

        $bulletin->delete();

        return redirect()
            ->route('director.bulletins.index')
            ->with('success', 'Bulletin supprimé.');
    }

    /**
     * Appréciation indicative selon la moyenne sur 20.
     */
    private function appreciation(float $moyenne): string
    {
        return match (true) {
            $moyenne >= 16 => 'Très bien',
            $moyenne >= 14 => 'Bien',
            $moyenne >= 12 => 'Assez bien',
            $moyenne >= 10 => 'Passable',
            default => 'Insuffisant',
        };
    }
}
