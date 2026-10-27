<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presence extends Model
{
    protected $fillable = [
        'inscription_id',
        'date_presence',
        'statut',
        'heure_arrivee',
        'motif',
        'enregistre_par',
    ];

    protected function casts(): array
    {
        return [
            'date_presence' => 'date',
        ];
    }

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'enregistre_par'
        );
    }
}
