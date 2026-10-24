<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Periode extends Model
{
    protected $fillable = [
        'annee_scolaire_id', 'type', 'numero',
        'libelle', 'date_debut', 'date_fin', 'cloturee',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'cloturee' => 'boolean',
    ];


public function anneeScolaire(): BelongsTo
{
    return $this->belongsTo(AnneeScolaire::class);
}

public function notes(): HasMany
{
    return $this->hasMany(Note::class);
}

public function bulletins(): HasMany
{
    return $this->hasMany(Bulletin::class);
}
}
