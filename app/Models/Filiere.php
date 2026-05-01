<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nom', 'niveau', 'option'];

    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }

    // Attribut nomComplet utilisé dans les vues
    public function getNomCompletAttribute(): string
    {
        return $this->nom;
    }
}