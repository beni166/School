<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DecisionScolaire extends Model
{
    protected $table = 'decisions_scolaires';
    protected $fillable = [
        'inscription_id',
        'decision',
        'classe_suivante_id',
        'observation',
    ];

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function classeSuivante(): BelongsTo
    {
        return $this->belongsTo(
            Classe::class,
            'classe_suivante_id'
        );
    }
}
