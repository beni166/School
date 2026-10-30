<?php

namespace Database\Factories;

use App\Models\Eleve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Eleve>
 */
class EleveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    

    protected $model = Eleve::class;

    public function definition(): array
    {
        $sexe = fake()->randomElement(['M', 'F']);

        $prenomsGarcons = [
            'Koffi', 'Komlan', 'Kodjo', 'Essowè', 'Amouzou',
            'Kossi', 'Yao', 'Messan', 'Kokou', 'Edem',
        ];

        $prenomsFilles = [
            'Ama', 'Akouvi', 'Abla', 'Essohanam', 'Mawunyo',
            'Afi', 'Dédé', 'Yawa', 'Adjovi', 'Efua',
        ];

        $prenoms = $sexe === 'M'
            ? $prenomsGarcons
            : $prenomsFilles;

        return [
            'matricule' => 'ELV-' . fake()->unique()->numerify('######'),
            'nom' => fake()->randomElement([
                'Amouzou', 'Amegan', 'Agbodjan', 'Mensah',
                'Koffi', 'Aklassou', 'Tchalla', 'Lawson',
                'Dossou', 'Afi', 'Kouassi', 'Adjovi',
            ]),
            'prenom' => fake()->randomElement($prenoms),
            'sexe' => $sexe,
            'date_naissance' => fake()->dateTimeBetween(
                '-20 years',
                '-10 years'
            )->format('Y-m-d'),
            'lieu_naissance' => fake()->randomElement([
                'Lomé', 'Tsévié', 'Kpalimé', 'Atakpamé',
                'Sokodé', 'Kara', 'Aného', 'Dapaong',
                'Bassar', 'Notsè',
            ]),
            'adresse' => fake()->randomElement([
                'Agoè', 'Adidogomé', 'Bè', 'Tokoin',
                'Kégué', 'Hédzranawoé', 'Avédji',
                'Baguida', 'Totsi', 'Sagbado',
            ]),
            'telephone_tuteur' => '+228' . fake()->numerify('9#######'),
        ];
    }
}
