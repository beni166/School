<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matiere extends Model
{
    protected $fillable = ['nom', 'code'];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function programmesClasses(): HasMany
    {
        return $this->hasMany(ProgrammeClasse::class);
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(AffectationProfesseur::class);
    }
    
}
