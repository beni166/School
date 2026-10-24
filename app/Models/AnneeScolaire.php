<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    protected $table = 'annees_scolaires';
    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'active',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'active' => 'boolean',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }

    public function programmesClasses()
    {
        return $this->hasMany(ProgrammeClasse::class);
    }

    public function affectationsProfesseurs()
    {
        return $this->hasMany(AffectationProfesseur::class);
    }
}
