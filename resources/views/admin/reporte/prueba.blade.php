<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Asistencias Técnicas</title>
    <style>
        @page {
            margin: 15px 25px 45px 25px; /* Margen inferior ajustado sin bloque de firmas */
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        /* Pie de página fijo únicamente con numeración */
        .footer-page {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 20px;
            width: 100%;
            text-align: right;
            font-size: 10px;
            font-weight: bold;
            color: #475569;
        }
        .header-banner {
            text-align: center;
            margin-bottom: 10px;
        }
        .header-banner img {
            max-width: 100%;
            height: auto;
            max-height: 110px;
        }
        .title-box {
            text-align: center;
            margin-bottom: 12px;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 6px;
        }
        .title-box h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            font-size: 10px;
        }
        .meta-box td {
            padding: 5px 10px;
            border: 1px solid #e2e8f0;
        }
        .meta-label {
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
        }
        .meta-value {
            font-weight: bold;
            color: #0f172a;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .table-data th {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 7px 8px;
            text-transform: uppercase;
            border: 1px solid #0f172a;
            font-size: 9.5px;
        }
        .table-data td {
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .table-data tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center {
            text-align: center;
        }
        .badge-state {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8.5px;
            font-weight: bold;
            border-radius: 4px;
            text-align: center;
            text-transform: uppercase;
        }
        .state-1 { background-color: #d97706; color: #ffffff; } /* En Espera */
        .state-2 { background-color: #16a34a; color: #ffffff; } /* En Proceso */
        .state-4 { background-color: #2563eb; color: #ffffff; } /* Finalizado */
        .state-9 { background-color: #eab308; color: #0f172a; } /* Pendiente */
        .summary-footer {
            margin-top: 10px;
            text-align: right;
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
        }
    </style>
</head>
<body>

    <!-- Pie de página con numeración de páginas -->
    <footer class="footer-page">
        Página <script type="php">echo $PAGE_NUM . " de " . $PAGE_COUNT;</script>
    </footer>

    @if(file_exists(storage_path('images/MUVHOF.jpg')))
        <div class="header-banner">
            <img src="{{ storage_path('images/MUVHOF.jpg') }}" alt="Encabezado MUVH">
        </div>
    @endif

    <div class="title-box">
        <h2>REPORTE DE ASISTENCIAS TÉCNICAS</h2>
    </div>

    <!-- Filtros / Metadatos del Informe -->
    <table class="meta-box">
        <tr>
            <td width="15%"><span class="meta-label">FECHA DESDE:</span></td>
            <td width="20%"><span class="meta-value">{{ $filtros['inicio'] }}</span></td>
            <td width="15%"><span class="meta-label">FECHA HASTA:</span></td>
            <td width="20%"><span class="meta-value">{{ $filtros['fin'] }}</span></td>
            <td width="15%"><span class="meta-label">TOTAL REGISTROS:</span></td>
            <td width="15%"><span class="meta-value">{{ $contar }}</span></td>
        </tr>
        <tr>
            <td><span class="meta-label">TÉCNICO:</span></td>
            <td colspan="2"><span class="meta-value">{{ $filtros['user_name'] }}</span></td>
            <td><span class="meta-label">ESTADO:</span></td>
            <td colspan="2"><span class="meta-value">{{ $filtros['state_name'] }}</span></td>
        </tr>
    </table>

    <!-- Tabla Principal de Asistencias -->
    <table class="table-data">
        <thead>
            <tr>
                <th width="5%" class="text-center">N°</th>
                <th width="20%">TÉCNICO ASIGNADO</th>
                <th width="45%">ACCIÓN REALIZADA / SOLUCIÓN</th>
                <th width="15%" class="text-center">FECHA</th>
                <th width="15%" class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dhelps as $item)
                <tr>
                    <td class="text-center"><b>#{{ $item->help_id }}</b></td>
                    <td><b>{{ $item->user ? trim($item->user->first_name . ' ' . $item->user->last_name) : 'Sin asignar' }}</b></td>
                    <td style="white-space: pre-line;">{{ $item->solution }}</td>
                    <td class="text-center">{{ optional($item->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                    <td class="text-center">
                        @if($item->state_id == 1)
                            <span class="badge-state state-1">{{ optional($item->state)->name ?? 'EN ESPERA' }}</span>
                        @elseif($item->state_id == 2)
                            <span class="badge-state state-2">{{ optional($item->state)->name ?? 'EN PROCESO' }}</span>
                        @elseif($item->state_id == 4)
                            <span class="badge-state state-4">{{ optional($item->state)->name ?? 'FINALIZADO' }}</span>
                        @elseif($item->state_id == 9)
                            <span class="badge-state state-9">{{ optional($item->state)->name ?? 'PENDIENTE' }}</span>
                        @else
                            <span class="badge-state">{{ optional($item->state)->name ?? '-' }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-footer">
        TOTAL DE ASISTENCIAS: {{ $contar }}
    </div>

</body>
</html>
