<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = ['niveau_id', 'nom'];

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function programmesClasses()
    {
        return $this->hasMany(ProgrammeClasse::class);
    }
    public function affectations()
    {
        return $this->hasMany(AffectationProfesseur::class);
    }
    
}
