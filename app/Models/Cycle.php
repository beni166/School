<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cycle extends Model
{
    protected $fillable = ['nom'];

    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }
}
