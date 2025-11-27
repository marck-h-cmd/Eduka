<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asistencia - {{ $matricula->estudiante->nombres }} {{ $matricula->estudiante->apellidos }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #1e5981;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #1e5981;
            margin: 10px 0;
            font-size: 24px;
        }

        .header h2 {
            color: #666;
            margin: 5px 0;
            font-size: 16px;
        }

        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            width: 150px;
            font-weight: bold;
            padding: 5px 10px 5px 0;
            background-color: #f8f9fa;
        }

        .info-value {
            display: table-cell;
            padding: 5px 0;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .stats-grid .stat-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .stats-grid .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #1e5981;
            display: block;
        }

        .stats-grid .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #1e5981;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .table .text-center {
            text-align: center;
        }

        .table .text-right {
            text-align: right;
        }

        .status-presente {
            background-color: #d4edda;
            color: #155724;
        }

        .status-ausente {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-tardanza {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-justificada {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .summary-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .summary-section h3 {
            margin: 0 0 10px 0;
            color: #1e5981;
            font-size: 14px;
        }

        .tipo-asistencia-summary {
            display: table;
            width: 100%;
            margin-top: 10px;
        }

        .tipo-asistencia-summary .tipo-item {
            display: table-cell;
            text-align: center;
            padding: 5px;
        }

        .tipo-asistencia-summary .tipo-label {
            font-size: 10px;
            color: #666;
            display: block;
        }

        .tipo-asistencia-summary .tipo-count {
            font-size: 16px;
            font-weight: bold;
            display: block;
        }

        @page {
            margin: 1cm;
            size: A4;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('imagenes/Imagen1.png') }}" alt="Logo Eduka" class="logo" style="max-width: 120px;">
        <h1>Reporte de Asistencia</h1>
        <h2>{{ $matricula->estudiante->nombres }} {{ $matricula->estudiante->apellidos }}</h2>
        <p><strong>Período:</strong> {{ $fechaInicio->format('d/m/Y') }} - {{ $fechaFin->format('d/m/Y') }}</p>
        @if(isset($asignaturaFiltro) && $asignaturaFiltro)
            <p><strong>Asignatura filtrada:</strong> {{ $asignaturaFiltro }}</p>
        @endif
        @if($asistencias->isEmpty())
            <p style="color: #666; font-size: 10px; margin: 5px 0;">
                <em>Nota: No se encontraron registros de asistencia en el período consultado. Si el estudiante tiene asistencia registrada en otro período, considere ajustar las fechas de búsqueda.</em>
            </p>
            <p style="color: #666; font-size: 9px; margin: 2px 0;">
                <em>Información de depuración: Matrícula ID: {{ $matricula->matricula_id }}, Rango de fechas: {{ $fechaInicio->format('Y-m-d') }} a {{ $fechaFin->format('Y-m-d') }}</em>
            </p>
        @endif
    </div>

    <!-- Información del Estudiante -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Estudiante:</div>
            <div class="info-value">{{ $matricula->estudiante->nombres }} {{ $matricula->estudiante->apellidos }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">DNI:</div>
            <div class="info-value">{{ $matricula->estudiante->dni }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Curso:</div>
            <div class="info-value">
                @if($matricula->grado && $matricula->seccion)
                    {{ $matricula->grado->nombre }}
                    @if($matricula->grado->nivel)
                        {{ $matricula->grado->nivel->nombre }}
                    @endif
                    "{{ $matricula->seccion->nombre }}"
                @else
                    Información no disponible
                @endif
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Año Lectivo:</div>
            <div class="info-value">{{ $matricula->anio_academico ?: 'No especificado' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Matrícula N°:</div>
            <div class="info-value">{{ $matricula->numero_matricula }}</div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="stats-grid">
        <div class="stat-item">
            <span class="stat-value">{{ $estadisticas['total'] }}</span>
            <span class="stat-label">Total de Registros</span>
        </div>
        <div class="stat-item">
            <span class="stat-value">{{ $estadisticas['porcentaje_asistencia'] }}%</span>
            <span class="stat-label">Porcentaje de Asistencia</span>
        </div>
        <div class="stat-item">
            <span class="stat-value">{{ $estadisticas['racha_actual'] }}</span>
            <span class="stat-label">Días Consecutivos Presente</span>
        </div>
        <div class="stat-item">
            <span class="stat-value">
                @if ($estadisticas['tendencia'] === 'mejorando')
                    ↗️ Mejorando
                @elseif($estadisticas['tendencia'] === 'empeorando')
                    ↘️ Empeorando
                @else
                    → Estable
                @endif
            </span>
            <span class="stat-label">Tendencia</span>
        </div>
    </div>

    <!-- Resumen por Tipo de Asistencia -->
    <div class="summary-section">
        <h3>Resumen por Tipo de Asistencia</h3>
        <div class="tipo-asistencia-summary">
            @php
                $tiposAsistencia = \App\Models\TipoAsistencia::where('activo', 1)->get();
            @endphp
            @foreach ($tiposAsistencia as $tipo)
                <div class="tipo-item">
                    <span class="tipo-count">{{ $estadisticas['por_tipo'][$tipo->tipo_asistencia_id] ?? 0 }}</span>
                    <span class="tipo-label">{{ $tipo->nombre }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tabla Detallada de Asistencias -->
    <h3 style="color: #1e5981; margin: 20px 0 10px 0;">Detalle de Asistencias</h3>
    @if($asistencias->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 80px;">Fecha</th>
                    <th style="width: 60px;">Día</th>
                    <th>Asignatura</th>
                    <th style="width: 100px;">Tipo</th>
                    <th>Justificación</th>
                    <th style="width: 80px;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($asistencias as $asistencia)
                    <tr>
                        <td class="text-center">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($asistencia->fecha)->locale('es')->isoFormat('ddd') }}</td>
                        <td>
                            @if($asistencia->cursoAsignatura && $asistencia->cursoAsignatura->asignatura)
                                {{ $asistencia->cursoAsignatura->asignatura->nombre }}
                            @else
                                No especificada
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($asistencia->tipoAsistencia)
                                <span class="status-{{ strtolower($asistencia->tipoAsistencia->codigo) }}">
                                    {{ $asistencia->tipoAsistencia->nombre }}
                                </span>
                            @else
                                <span class="status-ausente">No registrado</span>
                            @endif
                        </td>
                        <td>{{ $asistencia->justificacion ?: '-' }}</td>
                        <td class="text-center">{{ $asistencia->estado ?: 'Registrada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($estadisticas['total'] >= 500)
            <p style="font-size: 10px; color: #666; text-align: center; margin: 10px 0;">
                <em>* Se muestran los últimos 500 registros. Para ver todos los registros, consulte el sistema.</em>
            </p>
        @endif
    @else
        <p style="text-align: center; color: #666; font-style: italic; margin: 20px 0;">
            No se encontraron registros de asistencia para el período seleccionado.
        </p>
    @endif

    <!-- Información Adicional -->
    <div class="summary-section">
        <h3>Información Adicional</h3>
        <ul style="margin: 0; padding-left: 20px; font-size: 11px;">
            <li><strong>Fecha de generación:</strong> {{ \Carbon\Carbon::now()->setTimezone('America/Lima')->format('d/m/Y H:i:s') }}</li>
            <li><strong>Período evaluado:</strong> {{ $fechaInicio->format('d/m/Y') }} al
                {{ $fechaFin->format('d/m/Y') }}</li>
            <li><strong>Total de días lectivos:</strong> {{ $estadisticas['total'] }} días</li>
            <li><strong>Observaciones:</strong>
                @if(isset($asignaturaFiltro) && $asignaturaFiltro)
                    Este reporte incluye únicamente las asistencias de la asignatura "{{ $asignaturaFiltro }}" para el período seleccionado.
                @else
                    Este reporte incluye todas las asistencias registradas en el sistema para el período seleccionado.
                @endif
            </li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Eduka Perú</strong> - Sistema de Gestión Educativa</p>
        <p>Reporte generado automáticamente por el sistema - {{ \Carbon\Carbon::now()->setTimezone('America/Lima')->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
