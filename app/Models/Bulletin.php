<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bulletin extends Model
{
    protected $fillable = [
        'inscription_id',
        'periode_id',
        'nom_eleve',
        'prenom_eleve',
        'classe_libelle',
        'annee_libelle',
        'moyenne_generale',
        'rang',
        'appreciation_generale',
        'statut',
        'valide_le',
    ];

    protected function casts(): array
    {
        return [
            'moyenne_generale' => 'decimal:2',
            'valide_le' => 'datetime',
        ];
    }

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(BulletinDetail::class);
    }

    public function estValide(): bool
    {
        return $this->statut === 'valide';
    }
}
