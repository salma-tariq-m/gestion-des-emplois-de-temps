<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $fillable = ['code', 'capacite', 'type'];

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
