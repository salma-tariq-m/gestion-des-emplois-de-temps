<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Seance;

class StoreSeanceRequest extends FormRequest
{
    use \App\Traits\SeanceConflictTrait;

    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'groupe_id' => 'required|exists:groupes,id',
            'formateur_id' => 'required|exists:formateurs,id',
            'salle_id' => 'required|exists:salles,id',
            'date' => 'required|date',
            'creneau' => 'required|integer|in:1,2,3,4',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $date = \Carbon\Carbon::parse($this->date);
            $days = [
                0 => 'Dimanche',
                1 => 'Lundi',
                2 => 'Mardi',
                3 => 'Mercredi',
                4 => 'Jeudi',
                5 => 'Vendredi',
                6 => 'Samedi',
            ];
            $jour = $days[$date->dayOfWeek];

            $data = [
                'groupe_id' => (int) $this->groupe_id,
                'formateur_id' => (int) $this->formateur_id,
                'salle_id' => (int) $this->salle_id,
                'jour' => $jour,
                'creneau' => (int) $this->creneau,
            ];
            
            $seance_id = $this->route('seance');
            if ($seance_id instanceof Seance) {
                $seance_id = $seance_id->id;
            }

            $conflits = $this->checkAllConflicts($data, $seance_id);

            if ($conflits['groupe']) {
                $validator->errors()->add('groupe_id', "Ce groupe a déjà une séance prévue le $jour à ce créneau (Emploi du temps statique).");
            }

            if ($conflits['formateur']) {
                $validator->errors()->add('formateur_id', "Ce formateur est déjà occupé le $jour sur ce créneau (Emploi du temps statique).");
            }

            if ($conflits['salle']) {
                $validator->errors()->add('salle_id', "Cette salle est déjà réservée le $jour sur ce créneau (Emploi du temps statique).");
            }
        });
    }
}
