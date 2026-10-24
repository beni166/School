<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $fillable = [
        'matricule', 'nom', 'prenom', 'sexe',
        'date_naissance', 'lieu_naissance',
        'adresse', 'telephone_tuteur',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function inscriptionActive()
    {
        return $this->hasOne(Inscription::class)
            ->whereHas('anneeScolaire', function ($query) {
                $query->where('active', true);
            });
    }
}
