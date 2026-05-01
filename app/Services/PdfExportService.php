<?php

namespace App\Services;

use App\Models\Groupe;
use App\Models\Formateur;
use App\Models\Salle;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportService
{
    /**
     * Export planning groupe to PDF.
     */
    public function exportPlanningGroupe(Groupe $groupe, Carbon $dateDebutSemaine, array $planningData)
    {
        $data = [
            'titre' => "Planning du groupe {$groupe->code}",
            'soustitre' => "Filière: {$groupe->filiere->nom}" . ($groupe->filiere->option ? " ({$groupe->filiere->option})" : "") . " - Année {$groupe->annee}",
            'dateDebutSemaine' => $dateDebutSemaine,
            'planningData' => $planningData,
            'type' => 'groupe',
        ];

        return $this->generatePdf($data, "planning_groupe_{$groupe->code}_{$dateDebutSemaine->format('Y-m-d')}.pdf");
    }

    /**
     * Export planning formateur to PDF.
     */
    public function exportPlanningFormateur(Formateur $formateur, Carbon $dateDebutSemaine, array $planningData)
    {
        $data = [
            'titre' => "Planning de {$formateur->user->name}",
            'soustitre' => "Spécialité: {$formateur->specialite} - Matricule: {$formateur->matricule}",
            'dateDebutSemaine' => $dateDebutSemaine,
            'planningData' => $planningData,
            'type' => 'formateur',
            'afficherGroupe' => true,
        ];

        return $this->generatePdf($data, "planning_formateur_{$formateur->user->name}_{$dateDebutSemaine->format('Y-m-d')}.pdf");
    }

    /**
     * Export planning salle to PDF.
     */
    public function exportPlanningSalle(Salle $salle, Carbon $dateDebutSemaine, array $planningData)
    {
        $data = [
            'titre' => "Planning de la salle {$salle->code}",
            'soustitre' => "Type: {$salle->type}" . ($salle->capacite ? " - Capacité: {$salle->capacite}" : ''),
            'dateDebutSemaine' => $dateDebutSemaine,
            'planningData' => $planningData,
            'type' => 'salle',
            'afficherGroupe' => true,
        ];

        return $this->generatePdf($data, "planning_salle_{$salle->code}_{$dateDebutSemaine->format('Y-m-d')}.pdf");
    }

    /**
     * Generate PDF from data.
     */
    private function generatePdf(array $data, string $filename)
    {
        $html = $this->generateHtml($data);

        $pdf = Pdf::loadHTML($html)
                  ->setPaper('a4', 'landscape')
                  ->setOption('margin-top', 10)
                  ->setOption('margin-right', 10)
                  ->setOption('margin-bottom', 10)
                  ->setOption('margin-left', 10)
                  ->setOption('isPhpEnabled', true);

        return $pdf->download($filename);
    }

    /**
     * Generate HTML content for PDF.
     * Structure identique à la vue planning.blade.php
     */
    private function generateHtml(array $data): string
    {
        $titre = $data['titre'];
        $soustitre = $data['soustitre'];
        $dateDebutSemaine = $data['dateDebutSemaine'];
        $dateFinSemaine = $dateDebutSemaine->copy()->addDays(5);
        $planningData = $data['planningData'];
        $afficherGroupe = $data['afficherGroupe'] ?? false;

        // Construire le HTML
        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{$titre}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }
        
        .container {
            padding: 20px;
        }
        
        .header {
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #1a202c;
        }
        
        .header p {
            font-size: 11px;
            color: #666;
            margin-bottom: 3px;
        }
        
        .week-info {
            background-color: #e6f2ff;
            border-left: 4px solid #2563eb;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 10px;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }
        
        thead {
            background-color: #f3f4f6;
            border-bottom: 2px solid #999;
        }
        
        thead th {
            padding: 10px 5px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            border-right: 1px solid #ccc;
            word-wrap: break-word;
        }
        
        tbody td {
            padding: 8px 5px;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            vertical-align: top;
            height: 60px;
            font-size: 9px;
        }
        
        tbody td:first-child {
            background-color: #f9fafb;
            font-weight: bold;
            text-align: left;
            width: 80px;
        }
        
        .seance {
            background-color: #dbeafe;
            border-left: 4px solid #2563eb;
            padding: 6px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .seance h3 {
            font-weight: bold;
            font-size: 9px;
            margin-bottom: 3px;
            word-wrap: break-word;
        }
        
        .seance p {
            font-size: 8px;
            margin: 1px 0;
            color: #333;
        }
        
        .seance .groupe-badge {
            background-color: #ddd;
            color: #333;
            font-size: 7px;
            padding: 2px 4px;
            border-radius: 3px;
            display: inline-block;
            margin-top: 3px;
        }
        
        .libre {
            text-align: center;
            color: #999;
            font-style: italic;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
        }
        
        .horaire {
            color: #666;
            font-size: 8px;
            margin-top: 2px;
        }
        
        .legend {
            margin-top: 15px;
            font-size: 9px;
            color: #666;
        }
        
        .legend-item {
            margin-right: 20px;
            display: inline-block;
        }
        
        .legend-box {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-left: 3px solid #2563eb;
            background-color: #dbeafe;
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>{$titre}</h1>
            <p>{$soustitre}</p>
            <div class="week-info">
                Semaine du {$dateDebutSemaine->format('d/m/Y')} au {$dateFinSemaine->format('d/m/Y')}
            </div>
        </div>

        <!-- Tableau planning -->
        <table>
            <thead>
                <tr>
                    <th>Créneau</th>
                    <th>Lundi<br/>{$dateDebutSemaine->format('d/m')}</th>
                    <th>Mardi<br/>{$dateDebutSemaine->copy()->addDay()->format('d/m')}</th>
                    <th>Mercredi<br/>{$dateDebutSemaine->copy()->addDays(2)->format('d/m')}</th>
                    <th>Jeudi<br/>{$dateDebutSemaine->copy()->addDays(3)->format('d/m')}</th>
                    <th>Vendredi<br/>{$dateDebutSemaine->copy()->addDays(4)->format('d/m')}</th>
                    <th>Samedi<br/>{$dateDebutSemaine->copy()->addDays(5)->format('d/m')}</th>
                </tr>
            </thead>
            <tbody>
HTML;

        // Générer les lignes de créneaux
        $horaires = [
            1 => '08h30 - 11h00',
            2 => '11h00 - 13h30',
            3 => '13h30 - 16h00',
            4 => '16h00 - 18h30',
        ];

        foreach ($horaires as $creneau => $horaire) {
            $html .= <<<HTML
                <tr>
                    <td>
                        Séance {$creneau}<br/>
                        <span class="horaire">{$horaire}</span>
                    </td>
HTML;

            // Générer les cellules pour chaque jour
            foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour) {
                if (isset($planningData[$jour][$creneau])) {
                    $seance = $planningData[$jour][$creneau];
                    $titre_seance = htmlspecialchars($seance->titre, ENT_QUOTES);
                    $formateur = htmlspecialchars($seance->formateur->user->name, ENT_QUOTES);
                    $salle = htmlspecialchars($seance->salle->nom, ENT_QUOTES);
                    $description = $seance->description ? htmlspecialchars($seance->description, ENT_QUOTES) : '';
                    
                    $html .= <<<HTML
                    <td>
                        <div class="seance">
                            <div>
                                <h3>{$titre_seance}</h3>
                                <p><strong>Formateur:</strong> {$formateur}</p>
                                <p><strong>Salle:</strong> {$salle}</p>
HTML;
                    
                    if ($description) {
                        $html .= "<p style=\"font-style: italic;\">{$description}</p>";
                    }
                    
                    if ($afficherGroupe) {
                        $groupe_code = htmlspecialchars($seance->groupe->code, ENT_QUOTES);
                        $html .= <<<HTML
                                <span class="groupe-badge">{$groupe_code}</span>
HTML;
                    }
                    
                    $html .= <<<HTML
                            </div>
                        </div>
                    </td>
HTML;
                } else {
                    $html .= <<<HTML
                    <td>
                        <div class="libre">Libre</div>
                    </td>
HTML;
                }
            }

            $html .= <<<HTML
                </tr>
HTML;
        }

        $html .= <<<HTML
            </tbody>
        </table>

        <!-- Légende -->
        <div class="legend">
            <div class="legend-item">
                <span class="legend-box"></span>
                Séance planifiée
            </div>
            <div class="legend-item">
                Créneau libre = pas de cours
            </div>
        </div>
    </div>
</body>
</html>
HTML;

        return $html;
    }
}