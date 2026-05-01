<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    protected $fillable = ['user_id', 'matricule', 'nom', 'prenom', 'email', 'telephone', 'specialite'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groupes()
    {
        return $this->belongsToMany(Groupe::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}
