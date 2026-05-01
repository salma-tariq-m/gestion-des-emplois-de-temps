<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page { margin: 1cm; size: A4 landscape; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10px; 
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header { 
            margin-bottom: 30px;
            width: 100%;
        }
        .header-table { width: 100%; border: none; }
        .header-table td { border: none; padding: 0; vertical-align: middle; }
        
        .logo-text { font-weight: bold; font-size: 18px; color: #0F172A; }
        .logo-text span { color: #06b6d4; font-style: italic; }
        .institution-details { font-size: 9px; color: #64748b; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }

        .logo-img { height: 80px; width: auto; }
        .logo-container { text-align: center; }
        
        .title-section {
            margin-bottom: 25px;
            text-align: center;
        }
        .title-badge {
            display: inline-block;
            background-color: #f1f5f9;
            padding: 8px 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
        .title { 
            font-size: 14px; 
            font-weight: bold; 
            color: #0F172A;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        table.planning-table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed;
            border: 1px solid #e2e8f0;
        }
        table.planning-table th { 
            background-color: #f8fafc; 
            color: #475569;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 12px 5px;
            border: 1px solid #e2e8f0;
        }
        table.planning-table td { 
            border: 1px solid #e2e8f0; 
            padding: 10px 5px; 
            text-align: center; 
            height: 80px;
            vertical-align: middle;
        }
        
        .time-col { 
            background-color: #f8fafc; 
            font-weight: bold; 
            width: 90px;
            color: #1e293b;
        }
        .time-label { display: block; font-size: 11px; margin-bottom: 2px; }
        .time-range { display: block; font-size: 8px; color: #64748b; font-weight: normal; }

        .seance-card {
            padding: 5px;
        }
        .groupe-tag { 
            display: block;
            font-weight: bold; 
            font-size: 11px;
            color: #0F172A;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .formateur-info {
            display: block;
            font-weight: normal;
            color: #475569;
            margin-bottom: 5px;
            font-size: 10px;
        }
        .salle-badge {
            display: block;
            color: #0891b2;
            font-weight: bold;
            font-size: 9px;
        }
        
        .empty-cell { color: #cbd5e0; font-size: 12px; }

        .footer {
            position: fixed;
            bottom: -0.5cm;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td width="30%">
                    <img src="{{ public_path('images/ofppt-logo.png') }}" class="logo-img" alt="Logo OFPPT">
                </td>
                <td width="40%" style="text-align: center; vertical-align: middle;">
                    <div class="logo-text">EDT Digital <span>&</span> IA</div>
                </td>
                <td width="30%" style="text-align: right;">
                    <img src="{{ public_path('images/cmc-logo.png') }}" class="logo-img" alt="Logo CMC">
                </td>
            </tr>
        </table>
    </div>

    <div class="title-section">
        <div class="title-badge">
            <h2 class="title">{{ $title }}</h2>
        </div>
    </div>

    <table class="planning-table">
        <thead>
            <tr>
                <th class="time-col">CRÉNEAUX</th>
                @php 
                    $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
                @endphp
                @foreach($jours as $j)
                    <th>{{ $j }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php 
                $creneaux = [
                    1 => ['label' => 'S1', 'range' => '08:30 – 11:00'],
                    2 => ['label' => 'S2', 'range' => '11:00 – 13:30'],
                    3 => ['label' => 'S3', 'range' => '13:30 – 16:00'],
                    4 => ['label' => 'S4', 'range' => '16:00 – 18:30']
                ]; 
            @endphp
            @foreach($creneaux as $c => $info)
            <tr>
                <td class="time-col">
                    <span class="time-label">{{ $info['label'] }}</span>
                    <span class="time-range">{{ $info['range'] }}</span>
                </td>
                @foreach($jours as $j)
                    @php 
                        $seance = $seances->where('jour', $j)->where('creneau', $c)->first(); 
                    @endphp
                    <td>
                        @if($seance)
                            <div class="seance-card">
                                @if(isset($type))
                                    @if($type === 'groupe')
                                        <span class="groupe-tag">{{ $seance->formateur->nomComplet ?? 'N/A' }}</span>
                                    @elseif($type === 'formateur')
                                        <span class="groupe-tag">{{ $seance->groupe->code ?? 'N/A' }}</span>
                                    @else
                                        <span class="groupe-tag">{{ $seance->groupe->code ?? 'N/A' }}</span>
                                        <span class="formateur-info">{{ $seance->formateur->nomComplet ?? '' }}</span>
                                    @endif
                                @else
                                    <span class="groupe-tag">{{ $seance->groupe->code ?? 'N/A' }}</span>
                                    <span class="formateur-info">{{ $seance->formateur->nomComplet ?? '' }}</span>
                                @endif
                                <span class="salle-badge">Salle: {{ $seance->salle->code ?? '' }}</span>
                            </div>
                        @else
                            <span class="empty-cell">--</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} OFPPT — Direction de l'Intelligence Artificielle. Ce document est strictement réservé à un usage interne.
    </div>
</body>
</html>