<?php

namespace Database\Seeders;

use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::query()->get();
        $classes = Classe::query()->get();

        $annee = AnneeScolaire::where('active', true)->first();

        if ($eleves->isEmpty()) {
            $this->command->error('Aucun élève trouvé.');
            return;
        }

        if ($classes->isEmpty()) {
            $this->command->error('Aucune classe trouvée.');
            return;
        }

        if (!$annee) {
            $this->command->error(
                'Aucune année scolaire active. Active une année scolaire avant de continuer.'
            );
            return;
        }

        DB::transaction(function () use ($eleves, $classes, $annee) {
            foreach ($eleves as $eleve) {

                // Éviter les doublons pour la même année scolaire.
                $existe = Inscription::where('eleve_id', $eleve->id)
                    ->where('annee_scolaire_id', $annee->id)
                    ->exists();

                if ($existe) {
                    continue;
                }

                Inscription::create([
                    'eleve_id' => $eleve->id,
                    'classe_id' => $classes->random()->id,
                    'annee_scolaire_id' => $annee->id,

                    // Numéro unique pour chaque inscription.
                    'numero_inscription' => 'INS-'
                        . $annee->id . '-'
                        . str_pad($eleve->id, 5, '0', STR_PAD_LEFT),

                    'date_inscription' => now()->toDateString(),

                    // Vérifie que cette valeur existe dans ton ENUM
                    // ou parmi les valeurs autorisées par ta colonne.
                    'statut' => 'inscrit',
                ]);
            }
        });

        $this->command->info(
            'Les inscriptions des élèves ont été générées avec succès.'
        );
    }
}
