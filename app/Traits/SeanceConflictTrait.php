<?php

namespace App\Traits;

use App\Models\Seance;

trait SeanceConflictTrait
{
    /**
     * Vérifier s'il y a un conflit pour le groupe à ce créneau.
     * 
     * @param int $groupeId
     * @param string $date (YYYY-MM-DD)
     * @param int $creneau (1, 2, 3, ou 4)
     * @param int|null $excludeId (ID de la séance à exclure, pour les modifications)
     * @return bool
     */
    protected function checkConflitGroupe(int $groupeId, string $jour, int $creneau, ?int $excludeId = null): bool
    {
        $query = Seance::where('groupe_id', $groupeId)
                       ->where('jour', $jour)
                       ->where('creneau', $creneau);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Vérifier s'il y a un conflit pour le formateur à ce créneau.
     * 
     * @param int $formateurId
     * @param string $jour (Lundi, Mardi, ...)
     * @param int $creneau (1, 2, 3, ou 4)
     * @param int|null $excludeId (ID de la séance à exclure, pour les modifications)
     * @return bool
     */
    protected function checkConflitFormateur(int $formateurId, string $jour, int $creneau, ?int $excludeId = null): bool
    {
        $query = Seance::where('formateur_id', $formateurId)
                       ->where('jour', $jour)
                       ->where('creneau', $creneau);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Vérifier s'il y a un conflit pour la salle à ce créneau.
     * 
     * @param int $salleId
     * @param string $jour (Lundi, Mardi, ...)
     * @param int $creneau (1, 2, 3, ou 4)
     * @param int|null $excludeId (ID de la séance à exclure, pour les modifications)
     * @return bool
     */
    protected function checkConflitSalle(int $salleId, string $jour, int $creneau, ?int $excludeId = null): bool
    {
        $query = Seance::where('salle_id', $salleId)
                       ->where('jour', $jour)
                       ->where('creneau', $creneau);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Vérifier tous les conflits à la fois.
     * Retourne un tableau avec les conflits trouvés.
     * 
     * @param array $data (groupe_id, formateur_id, salle_id, jour, creneau)
     * @param int|null $excludeId (ID de la séance à exclure, pour les modifications)
     * @return array Exemple: ['groupe' => true, 'formateur' => false, 'salle' => true]
     */
    protected function checkAllConflicts(array $data, ?int $excludeId = null): array
    {
        $conflits = [
            'groupe' => false,
            'formateur' => false,
            'salle' => false,
        ];

        if ($this->checkConflitGroupe($data['groupe_id'], $data['jour'], $data['creneau'], $excludeId)) {
            $conflits['groupe'] = true;
        }

        if ($this->checkConflitFormateur($data['formateur_id'], $data['jour'], $data['creneau'], $excludeId)) {
            $conflits['formateur'] = true;
        }

        if ($this->checkConflitSalle($data['salle_id'], $data['jour'], $data['creneau'], $excludeId)) {
            $conflits['salle'] = true;
        }

        return $conflits;
    }
}