<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulletinDetail extends Model
{
    protected $fillable = [
        'bulletin_id',
        'matiere_id',
        'professeur_id',
        'note_id',
        'matiere_libelle',
        'professeur_libelle',
        'interrogation_1',
        'interrogation_2',
        'devoir',
        'composition',
        'coefficient',
        'moyenne_matiere',
        'points_coefficientes',
        'rang_matiere',
        'appreciation',
    ];

    protected function casts(): array
    {
        return [
            'interrogation_1' => 'decimal:2',
            'interrogation_2' => 'decimal:2',
            'devoir' => 'decimal:2',
            'composition' => 'decimal:2',
            'coefficient' => 'decimal:2',
            'moyenne_matiere' => 'decimal:2',
            'points_coefficientes' => 'decimal:2',
        ];
    }

    public function bulletin(): BelongsTo
    {
        return $this->belongsTo(Bulletin::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function professeur(): BelongsTo
    {
        return $this->belongsTo(Professeur::class);
    }

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
