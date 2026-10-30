<?php

namespace Database\Factories;

use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Professeur>
 */
class ProfesseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Professeur::class;

    public function definition(): array
    {
        $nom = fake()->randomElement([
            'Amouzou', 'Mensah', 'Agbodjan', 'Lawson',
            'Tchalla', 'Amegan', 'Kouassi', 'Dossou',
            'Adjovi', 'Aklassou', 'Koffi', 'Akakpo',
        ]);

        $prenom = fake()->randomElement([
            'Komlan', 'Kossi', 'Kokou', 'Kodjo',
            'Yao', 'Edem', 'Ama', 'Akouvi',
            'Abla', 'Afi', 'Mawunyo', 'Messan',
        ]);

        return [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => fake()->unique()->safeEmail(),
            'telephone' => '+228' . fake()->numerify('9#######'),
        ];
    }
}
