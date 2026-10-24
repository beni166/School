<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professeur extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
    ];

    public function affectations(): HasMany
    {
        return $this->hasMany(AffectationProfesseur::class);
    }
}
