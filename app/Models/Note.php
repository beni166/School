<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'inscription_id',
        'periode_id',
        'matiere_id',
        'interrogation_1',
        'interrogation_2',
        'devoir',
        'composition',
    ];

    protected $casts = [
        'interrogation_1' => 'decimal:2',
        'interrogation_2' => 'decimal:2',
        'devoir' => 'decimal:2',
        'composition' => 'decimal:2',
    ];


    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }
}
