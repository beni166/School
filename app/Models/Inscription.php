<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inscription extends Model
{
    protected $fillable = [
        'eleve_id',
        'annee_scolaire_id',
        'classe_id',
        'numero_inscription',
        'date_inscription',
        'statut',
    ];

    protected $casts = [
        'date_inscription' => 'date',
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }

    public function decisionScolaire()
    {
        return $this->hasOne(DecisionScolaire::class);
    }

    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);
    }
}
