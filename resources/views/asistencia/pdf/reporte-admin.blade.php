<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Administrativo de Asistencias</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0A8CB3;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #0A8CB3;
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 9px;
        }

        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .info-section h3 {
            margin: 0 0 10px 0;
            color: #0A8CB3;
            font-size: 12px;
            font-weight: bold;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 3px 10px 3px 0;
            width: 120px;
            font-size: 9px;
        }

        .info-value {
            display: table-cell;
            padding: 3px 0;
            font-size: 9px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 8px;
        }

        .table th {
            background-color: #0A8CB3;
            color: white;
            padding: 8px 4px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }

        .table td {
            padding: 6px 4px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f5f5f5;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 7px;
            font-weight: bold;
            border-radius: 3px;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8px;
            color: #666;
        }

        .page-break {
            page-break-before: always;
        }

        .summary-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            background-color: #f8f9fa;
        }

        .summary-title {
            font-weight: bold;
            color: #0A8CB3;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .summary-stats {
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            flex-wrap: nowrap;
        }

        .stat-item {
            text-align: center;
            flex: 1;
            min-width: 60px;
            margin: 0 5px;
        }

        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #0A8CB3;
            display: block;
        }

        .stat-label {
            font-size: 8px;
            color: #666;
            margin-top: 2px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mt-0 {
            margin-top: 0;
        }

        .filters-info {
            background-color: #E0F7FA;
            border: 1px solid #86D2E3;
            border-radius: 5px;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 8px;
        }

        .filters-info strong {
            color: #0A8CB3;
        }

        .context-info {
            background-color: #FFF3CD;
            border: 1px solid #FFEAA7;
            border-radius: 5px;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 9px;
        }

        .context-info strong {
            color: #856404;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .summary-table td {
            border: none;
            padding: 5px;
            text-align: center;
            background-color: transparent;
        }

        .stat-cell {
            border-right: 1px solid #ddd;
        }

        .stat-cell:last-child {
            border-right: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte Administrativo de Asistencias</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistema Eduka Perú - Gestión Académica</p>
    </div>

    <!-- Información de filtros aplicados -->
    @if(request()->hasAny(['profesor_id', 'curso_id', 'asignatura_id', 'tipo_asistencia_id', 'fecha_desde', 'fecha_hasta', 'estado', 'buscar']))
        <div class="filters-info">
            <strong>Filtros aplicados:</strong><br>
            @if(request('profesor_id'))
                <span>Profesor: {{ \App\Models\InfDocente::find(request('profesor_id'))?->nombres ?? 'N/A' }} {{ \App\Models\InfDocente::find(request('profesor_id'))?->apellidos ?? '' }}</span><br>
            @endif
            @if(request('curso_id'))
                <span>Curso: {{ \App\Models\InfCurso::with(['grado', 'seccion'])->find(request('curso_id'))?->grado->nombre ?? 'N/A' }} - {{ \App\Models\InfCurso::with(['grado', 'seccion'])->find(request('curso_id'))?->seccion->nombre ?? '' }}</span><br>
            @endif
            @if(request('asignatura_id'))
                <span>Asignatura: {{ \App\Models\InfAsignatura::find(request('asignatura_id'))?->nombre ?? 'N/A' }}</span><br>
            @endif
            @if(request('tipo_asistencia_id'))
                <span>Tipo Asistencia: {{ \App\Models\TipoAsistencia::find(request('tipo_asistencia_id'))?->nombre ?? 'N/A' }}</span><br>
            @endif
            @if(request('fecha_desde') || request('fecha_hasta'))
                <span>Rango de fechas: {{ request('fecha_desde') ?: 'Sin límite' }} - {{ request('fecha_hasta') ?: 'Sin límite' }}</span><br>
            @endif
            @if(request('estado'))
                <span>Estado: {{ request('estado') }}</span><br>
            @endif
            @if(request('buscar'))
                <span>Búsqueda: "{{ request('buscar') }}"</span>
            @endif
        </div>
    @endif

    <div class="summary-box">
        <div class="summary-title">Resumen General</div>
        <table class="summary-table">
            <tr>
                <td class="stat-cell">
                    <div class="stat-number">{{ $asistencias->count() }}</div>
                    <div class="stat-label">Total Registros</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-number">{{ $asistencias->where('tipoAsistencia.codigo', 'A')->count() }}</div>
                    <div class="stat-label">Presentes</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-number">{{ $asistencias->where('tipoAsistencia.codigo', 'F')->count() }}</div>
                    <div class="stat-label">Ausentes</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-number">{{ $asistencias->where('tipoAsistencia.codigo', 'T')->count() }}</div>
                    <div class="stat-label">Tardanzas</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-number">{{ $asistencias->where('tipoAsistencia.codigo', 'J')->count() }}</div>
                    <div class="stat-label">Justificadas</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Fecha</th>
                <th>Estudiante</th>
                <th>DNI</th>
                <th>Asignatura</th>
                <th>Profesor</th>
                <th>Asistencia</th>
                <th>Estado</th>
                <th>Justificación</th>
                <th>Hora Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistencias as $index => $asistencia)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                    <td>
                        {{ $asistencia->matricula->estudiante->nombres }}<br>
                        <small>{{ $asistencia->matricula->estudiante->apellidos }}</small>
                    </td>
                    <td>{{ $asistencia->matricula->estudiante->dni }}</td>
                    <td>{{ $asistencia->cursoAsignatura->asignatura->nombre }}</td>
                    <td>
                        {{ $asistencia->cursoAsignatura->profesor->nombres }}<br>
                        <small>{{ $asistencia->cursoAsignatura->profesor->apellidos }}</small>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $asistencia->tipoAsistencia->codigo == 'A' ? 'success' : ($asistencia->tipoAsistencia->codigo == 'F' ? 'danger' : ($asistencia->tipoAsistencia->codigo == 'T' ? 'warning' : 'secondary')) }}">
                            {{ $asistencia->tipoAsistencia->nombre }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $asistencia->estado == 'Registrada' ? 'success' : 'info' }}">
                            {{ $asistencia->estado }}
                        </span>
                    </td>
                    <td>
                        @if($asistencia->justificacion)
                            <small>{{ Str::limit($asistencia->justificacion, 30) }}</small>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $asistencia->hora_registro->format('H:i') }}<br>
                        <small>{{ $asistencia->hora_registro->format('d/m/Y') }}</small>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado por el Sistema Eduka Perú - {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Este documento es confidencial y está destinado únicamente para uso administrativo.</p>
    </div>
</body>
</html>
