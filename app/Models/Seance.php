<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = ['groupe_id', 'formateur_id', 'salle_id', 'date', 'jour', 'creneau'];

    protected $casts = [
        'date' => 'date',
    ];

    public static function boot()
    {
        parent::boot();
        
        // Auto-fill 'jour' based on 'date' if provided
        static::saving(function ($seance) {
            if ($seance->date) {
                $days = [
                    0 => 'Dimanche',
                    1 => 'Lundi',
                    2 => 'Mardi',
                    3 => 'Mercredi',
                    4 => 'Jeudi',
                    5 => 'Vendredi',
                    6 => 'Samedi',
                ];
                $seance->jour = $days[$seance->date->dayOfWeek] ?? $seance->jour;
            }
        });
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public static function getHoraires()
    {
        return [
            1 => '08h30 - 11h00',
            2 => '11h00 - 13h30',
            3 => '13h30 - 16h00',
            4 => '16h00 - 18h30',
        ];
    }
    
    public function getHoraireAttribute()
    {
        return self::getHoraires()[$this->creneau] ?? '';
    }
}