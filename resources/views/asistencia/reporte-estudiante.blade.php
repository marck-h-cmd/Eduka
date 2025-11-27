{{-- resources/views/asistencia/reporte-estudiante.blade.php --}}
@extends('cplantilla.bprincipal')

@section('titulo', 'Reporte de Asistencia del Estudiante')

@section('contenidoplantilla')
    <style>
        .form-bordered {
            margin: 0;
            border: none;
            padding-top: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eaedf1;
        }

        .card-body.info {
            background: #f3f3f3;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            border-top: 1px solid rgba(0, 0, 0, .125);
            color: #F59D24;
        }

        .card-body.info p {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 600;
            color: #004a92;
        }

        .estilo-info {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
        }

        .btn-primary {
            margin-top: 1rem;
            background: #007bff !important;
            border: none;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
        }

        .btn-primary:hover {
            background-color: #0056b3 !important;
            transform: scale(1.01);
        }

        .stats-card {
            border-radius: 15px;
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            margin-bottom: 1rem;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 1rem;
        }

        .chart-container canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .table-custom tbody tr:nth-of-type(odd) {
            background-color: #f5f5f5;
        }

        .table-custom tbody tr:nth-of-type(even) {
            background-color: #e0e0e0;
        }

        .table-hover tbody tr:hover {
            background-color: #eeffe7 !important;
        }

        .badge-racha {
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timeline-item {
            position: relative;
            padding-left: 40px;
            padding-bottom: 1.5rem;
            border-left: 2px solid #e9ecef;
        }

        .timeline-item:last-child {
            border-left: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -8px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 2px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin: 1rem 0;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid #dee2e6;
            min-height: 40px;
        }

        .calendar-day:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .calendar-header {
            text-align: center;
            font-weight: bold;
            color: #0A8CB3;
            margin-bottom: 1rem;
        }

        #loaderPrincipal[style*="display: flex"] {
            display: flex !important;
            justify-content: center;
            align-items: center;
            position: absolute !important;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 2000;
        }

        .student-header {
            background: linear-gradient(135deg, #0A8CB3 0%, #368569 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.3;
        }
    </style>

    <div class="container-fluid" id="contenido-principal" style="position: relative;">
        @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])

        <div class="row mt-4 ml-1 mr-1">
            <div class="col-12">
                <div class="box_block">
                    <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                        data-toggle="collapse" data-target="#collapseReporte" aria-expanded="true"
                        style="background: #0A8CB3 !important; font-weight: bold; color: white;">
                        <i class="fas fa-chart-bar m-1"></i>&nbsp;Reporte de Asistencia del Estudiante
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>

                    <div class="card-body info">
                        <div class="d-flex">
                            <div>
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                            <div class="p-2 flex-fill">
                                <p>
                                    Consulta detallada del registro de asistencia del estudiante, incluyendo estadísticas,
                                    tendencias y calendario de asistencia.
                                </p>
                                <p>
                                    Este reporte muestra el desempeño del estudiante durante el período académico
                                    seleccionado.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="collapse show" id="collapseReporte">
                        <div class="card card-body rounded-0 border-0 pt-3 pb-2"
                            style="background-color: #fcfffc !important">

                            <!-- Header del Estudiante -->
                            <div class="student-header">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center">
                                        <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                            style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                                            {{ substr($estudiante->nombres, 0, 1) }}{{ substr($estudiante->apellidos, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h3 class="mb-1">{{ $estudiante->nombres }}
                                            {{ $estudiante->apellidos }}</h3>
                                        <div>
                                            <span class="me-3"><i class="fas fa-id-card"></i>
                                                {{ $estudiante->documento }}</span>
                                            <span class="me-3"><i class="fas fa-graduation-cap"></i>
                                                {{ $todasMatriculas->count() }} curso{{ $todasMatriculas->count() > 1 ? 's' : '' }} matriculado{{ $todasMatriculas->count() > 1 ? 's' : '' }}</span>
                                        </div>
                                        <div class="mt-1">
                                            <span><i class="far fa-calendar"></i> {{ $fechaInicio->format('d/m/Y') }} -
                                                {{ $fechaFin->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-white-50">
                                                <i class="fas fa-info-circle"></i>
                                                Este reporte muestra la asistencia del estudiante en {{ $cursoFiltro ? 'el curso seleccionado' : 'todos sus cursos' }}.
                                                Use el filtro de cursos para ver asistencia específica por asignatura.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <span class="badge-racha">
                                            <i class="fas fa-fire"></i>
                                            <span>Racha: {{ $estadisticas['racha_actual'] }} días</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro de Cursos -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <form method="GET" action="{{ route('asistencia.detalle-estudiante', $matricula->matricula_id) }}" class="row g-3 align-items-end">
                                                <div class="col-md-4">
                                                    <label for="curso_id" class="form-label estilo-info">
                                                        <i class="fas fa-graduation-cap text-primary"></i> Filtrar por Curso
                                                    </label>
                                                    <select name="curso_id" id="curso_id" class="form-control">
                                                        <option value="">Todos los cursos</option>
                                                        @foreach($todasMatriculas as $mat)
                                                            @php
                                                                $asignaturasCurso = \App\Models\CursoAsignatura::where('curso_id', $mat->curso_id)
                                                                    ->with('asignatura')
                                                                    ->get()
                                                                    ->pluck('asignatura.nombre')
                                                                    ->unique()
                                                                    ->values();
                                                            @endphp
                                                            <option value="{{ $mat->curso_id }}" {{ $cursoFiltro == $mat->curso_id ? 'selected' : '' }}>
                                                                {{ $mat->grado->nivel->nombre }} {{ $mat->grado->nombre }} - {{ $mat->seccion->nombre }}
                                                                @if($asignaturasCurso->count() > 0)
                                                                    ({{ $asignaturasCurso->implode(', ') }})
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="fecha_inicio" class="form-label estilo-info">
                                                        <i class="fas fa-calendar-alt text-primary"></i> Fecha Inicio
                                                    </label>
                                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                                           value="{{ $fechaInicio->format('Y-m-d') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="fecha_fin" class="form-label estilo-info">
                                                        <i class="fas fa-calendar-alt text-primary"></i> Fecha Fin
                                                    </label>
                                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                                                           value="{{ $fechaFin->format('Y-m-d') }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="fas fa-search"></i> Filtrar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Estadísticas Principales -->
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <div class="card stats-card" style="background: #667eea; color: white;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Total Registros</h6>
                                                    <h2 class="mb-0">{{ $estadisticas['total'] }}</h2>
                                                </div>
                                                <i class="fas fa-calendar-check stat-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 mb-2">
                                    <div class="card stats-card" style="background: #28a745; color: white;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">% Asistencia</h6>
                                                    <h2 class="mb-0">{{ $estadisticas['porcentaje_asistencia'] }}%</h2>
                                                    <small>
                                                        @if ($estadisticas['tendencia'] == 'mejorando')
                                                            <i class="fas fa-arrow-up"></i> Mejorando
                                                        @elseif($estadisticas['tendencia'] == 'empeorando')
                                                            <i class="fas fa-arrow-down"></i> Atención
                                                        @else
                                                            <i class="fas fa-minus"></i> Estable
                                                        @endif
                                                    </small>
                                                </div>
                                                <i class="fas fa-chart-line stat-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 mb-2">
                                    <div class="card stats-card" style="background: #dc3545; color: white;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Ausencias</h6>
                                                    <h2 class="mb-0">{{ $estadisticas['por_tipo'][2] ?? 0 }}</h2>
                                                    <small>{{ $estadisticas['por_tipo'][4] ?? 0 }} justificadas</small>
                                                </div>
                                                <i class="fas fa-times-circle stat-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 mb-2">
                                    <div class="card stats-card" style="background: #ffc107; color: white;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Tardanzas</h6>
                                                    <h2 class="mb-0">{{ $estadisticas['por_tipo'][3] ?? 0 }}</h2>
                                                </div>
                                                <i class="fas fa-clock stat-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Estadísticas por Asignatura -->
                            @if($estadisticasPorAsignatura->count() > 1)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info"><i class="fas fa-book text-primary"></i>
                                                Rendimiento por Asignatura</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($estadisticasPorAsignatura as $asignatura => $stats)
                                                <div class="col-lg-3 col-md-6 mb-3">
                                                    <div class="card h-100 border-left-primary">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <h6 class="card-title mb-0 text-truncate" title="{{ $asignatura }}">
                                                                    {{ Str::limit($asignatura, 20) }}
                                                                </h6>
                                                                <span class="badge"
                                                                    style="background-color: {{ $stats['porcentaje'] >= 80 ? '#28a745' : ($stats['porcentaje'] >= 60 ? '#ffc107' : '#dc3545') }};">
                                                                    {{ $stats['porcentaje'] }}%
                                                                </span>
                                                            </div>
                                                            <div class="row text-center">
                                                                <div class="col-4">
                                                                    <div class="text-success">
                                                                        <i class="fas fa-check-circle fa-lg"></i>
                                                                        <br><small>{{ $stats['presentes'] }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="text-danger">
                                                                        <i class="fas fa-times-circle fa-lg"></i>
                                                                        <br><small>{{ $stats['ausencias'] }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="text-warning">
                                                                        <i class="fas fa-clock fa-lg"></i>
                                                                        <br><small>{{ $stats['tardanzas'] }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress mt-2" style="height: 6px;">
                                                                <div class="progress-bar bg-success"
                                                                     style="width: {{ $stats['total'] > 0 ? ($stats['presentes'] / $stats['total']) * 100 : 0 }}%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Gráficos -->
                            <div class="row mb-3">
                                <div class="col-lg-8 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info"><i class="fas fa-chart-area text-primary"></i>
                                                Tendencia de Asistencia</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="tendenciaChart" width="400" height="300"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info"><i class="fas fa-chart-pie text-primary"></i>
                                                Distribución</h6>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="chart-container">
                                                <canvas id="distribucionChart" width="400" height="300"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Calendario de Asistencia -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header d-flex justify-content-between align-items-center"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <button id="mes-anterior" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <h6 class="mb-0 estilo-info"><i class="fas fa-calendar-alt text-primary"></i>
                                                Calendario de Asistencia</h6>
                                            <button id="mes-siguiente" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div id="calendario-asistencia" class="p-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Historial y Alertas -->
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card shadow-sm">
                                        <div class="card-header d-flex justify-content-between align-items-center"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info"><i class="fas fa-history text-primary"></i>
                                                Historial Detallado</h6>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-file-pdf"></i> Exportar PDF
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#" onclick="exportarPDFGeneral()">
                                                        <i class="fas fa-file-pdf text-danger"></i> Reporte General
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <h6 class="dropdown-header">Por Asignatura</h6>
                                                    @php
                                                        $asignaturasUnicas = $asistencias->groupBy('cursoAsignatura.asignatura.nombre')->keys();
                                                    @endphp
                                                    @foreach($asignaturasUnicas as $asignaturaNombre)
                                                        <a class="dropdown-item" href="#" onclick="exportarPDFAsignatura('{{ $asignaturaNombre }}')">
                                                            <i class="fas fa-book text-primary"></i> {{ $asignaturaNombre }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                                            <div class="timeline">
                                                @foreach ($asistencias as $asistencia)
                                                    <div class="timeline-item">
                                                        <div class="timeline-dot"
                                                            style="box-shadow: 0 0 0 2px {{ getColorTipo(optional($asistencia->tipoAsistencia)->codigo) }}; 
                                                            background-color: {{ getColorTipo(optional($asistencia->tipoAsistencia)->codigo) }}">
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h6 class="mb-1 estilo-info">
                                                                    {{ Carbon\Carbon::parse($asistencia->fecha)->isoFormat('dddd, D [de] MMMM') }}
                                                                </h6>
                                                                <p class="text-muted mb-1">
                                                                    <strong>{{ $asistencia->cursoAsignatura->asignatura->nombre }}</strong>
                                                                </p>
                                                            </div>
                                                            <span class="badge"
                                                                style="background-color: {{ getColorTipo(optional($asistencia->tipoAsistencia)->codigo) }}">
                                                                {{ optional($asistencia->tipoAsistencia)->nombre }}
                                                            </span>
                                                        </div>

                                                        @if ($asistencia->justificacion && optional($asistencia->tipoAsistencia)->codigo !== 'A')
                                                            <div class="alert alert-light mb-2">
                                                                <small><i class="fas fa-comment"></i>
                                                                    {{ $asistencia->justificacion }}</small>
                                                            </div>
                                                        @endif

                                                        @if ($asistencia->documento_justificacion)
                                                            <a href="{{ asset('storage/justificaciones/' . $asistencia->documento_justificacion) }}"
                                                                target="_blank" class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-file-pdf"></i> Ver documento
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info"><i class="fas fa-bell text-warning"></i> Alertas
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $mostrarAlertas = false;
                                                $alertas = [];
                                            @endphp

                                            @if ($estadisticas['porcentaje_asistencia'] < 75)
                                                @php
                                                    $mostrarAlertas = true;
                                                    $alertas[] = [
                                                        'tipo' => 'danger',
                                                        'icono' => 'fas fa-exclamation-triangle',
                                                        'titulo' => 'Atención',
                                                        'mensaje' => 'Asistencia por debajo del 75%'
                                                    ];
                                                @endphp
                                            @endif

                                            @if (($estadisticas['por_tipo'][2] ?? 0) >= 3)
                                                @php
                                                    $mostrarAlertas = true;
                                                    $alertas[] = [
                                                        'tipo' => 'warning',
                                                        'icono' => 'fas fa-info-circle',
                                                        'titulo' => 'Ausencias',
                                                        'mensaje' => ($estadisticas['por_tipo'][2] ?? 0) . ' ausencias registradas'
                                                    ];
                                                @endphp
                                            @endif

                                            @if ($estadisticas['racha_actual'] >= 10)
                                                @php
                                                    $mostrarAlertas = true;
                                                    $alertas[] = [
                                                        'tipo' => 'success',
                                                        'icono' => 'fas fa-trophy',
                                                        'titulo' => '¡Excelente!',
                                                        'mensaje' => $estadisticas['racha_actual'] . ' días consecutivos'
                                                    ];
                                                @endphp
                                            @endif

                                            @if ($estadisticas['porcentaje_asistencia'] >= 90)
                                                @php
                                                    $mostrarAlertas = true;
                                                    $alertas[] = [
                                                        'tipo' => 'success',
                                                        'icono' => 'fas fa-star',
                                                        'titulo' => '¡Excelente rendimiento!',
                                                        'mensaje' => 'Asistencia sobresaliente (' . $estadisticas['porcentaje_asistencia'] . '%)'
                                                    ];
                                                @endphp
                                            @endif

                                            @if (!$mostrarAlertas)
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i>
                                                    <strong>Información:</strong> No hay alertas activas para este período.
                                                    <br><small>Asistencia actual: {{ $estadisticas['porcentaje_asistencia'] }}% | Ausencias: {{ $estadisticas['por_tipo'][2] ?? 0 }} | Racha: {{ $estadisticas['racha_actual'] }} días</small>
                                                </div>
                                            @else
                                                @foreach($alertas as $alerta)
                                                    <div class="alert alert-{{ $alerta['tipo'] }}">
                                                        <i class="{{ $alerta['icono'] }}"></i>
                                                        <strong>{{ $alerta['titulo'] }}:</strong> {{ $alerta['mensaje'] }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card shadow-sm">
                                        <div class="card-header"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info"><i class="fas fa-users text-info"></i>
                                                Comparativa</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <small class="text-muted">Tu asistencia</small>
                                                <div class="progress" style="height: 25px;">
                                                    <div class="progress-bar bg-success"
                                                        style="width: {{ $estadisticas['porcentaje_asistencia'] }}%">
                                                        {{ $estadisticas['porcentaje_asistencia'] }}%
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted">Promedio del curso</small>
                                                <div class="progress" style="height: 25px;">
                                                    <div class="progress-bar bg-info" style="width: 85%">
                                                        85%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        let mesActualCalendario = null; // Variable global para el mes actual del calendario

        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('loaderPrincipal');
            if (loader) loader.style.display = 'none';

            // Datos para gráficos
            const datosGrafico = @json($datosGrafico);

            // Debug: verificar que los datos se carguen
            console.log('Datos del gráfico:', datosGrafico);
            console.log('Asistencias:', @json($asistencias));
            console.log('Estadísticas:', @json($estadisticas));

            // Gráfico de Tendencia
            const ctxTendencia = document.getElementById('tendenciaChart');
            if (ctxTendencia && datosGrafico.labels && datosGrafico.labels.length > 0) {
                new Chart(ctxTendencia.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: datosGrafico.labels,
                        datasets: [{
                            label: '% Asistencia',
                            data: Object.values(datosGrafico.datasets.asistencias),
                            borderColor: '#0A8CB3',
                            backgroundColor: 'rgba(10, 140, 179, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 10,
                                ticks: {
                                    callback: function(value) {
                                        return value;
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Gráfico de Distribución
            const ctxDistribucion = document.getElementById('distribucionChart');
            if (ctxDistribucion) {
                new Chart(ctxDistribucion.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Presentes', 'Ausentes', 'Tardanzas'],
                        datasets: [{
                            data: [
                                {{ $estadisticas['por_tipo'][1] ?? 0 }},
                                {{ $estadisticas['por_tipo'][2] ?? 0 }},
                                {{ $estadisticas['por_tipo'][3] ?? 0 }}
                            ],
                            backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            // Generar Calendario inicial
            generarCalendario();

            // Configurar navegación del calendario
            configurarNavegacionCalendario();
        });

        function configurarNavegacionCalendario() {
            const btnMesAnterior = document.getElementById('mes-anterior');
            const btnMesSiguiente = document.getElementById('mes-siguiente');

            if (btnMesAnterior && btnMesSiguiente) {
                btnMesAnterior.addEventListener('click', function() {
                    if (mesActualCalendario) {
                        // Crear nueva fecha basada en el mes actual
                        const nuevoMes = new Date(mesActualCalendario.getFullYear(), mesActualCalendario.getMonth() - 1, 1);
                        generarCalendario(nuevoMes);
                    }
                });

                btnMesSiguiente.addEventListener('click', function() {
                    if (mesActualCalendario) {
                        // Crear nueva fecha basada en el mes actual
                        const nuevoMes = new Date(mesActualCalendario.getFullYear(), mesActualCalendario.getMonth() + 1, 1);
                        generarCalendario(nuevoMes);
                    }
                });
            }
        }

        function generarCalendario(mesForzado = null) {
            const calendario = document.getElementById('calendario-asistencia');
            const asistencias = @json($asistencias);

            if (!calendario) {
                return;
            }

            // Crear mapa detallado de asistencias por fecha
            const asistenciasMap = {};
            const asistenciasPorDia = {};

            asistencias.forEach(a => {
                // Convertir fecha ISO a YYYY-MM-DD si es necesario
                let fechaKey = a.fecha;
                if (fechaKey.includes('T')) {
                    fechaKey = fechaKey.split('T')[0]; // Extraer solo YYYY-MM-DD
                }

                const codigo = a.tipo_asistencia ? a.tipo_asistencia.codigo : (a.tipoAsistencia ? a.tipoAsistencia.codigo : null);
                const asignatura = a.cursoAsignatura ? a.cursoAsignatura.asignatura.nombre : 'Sin asignatura';

                // Mapa simple para colores
                asistenciasMap[fechaKey] = codigo;

                // Mapa detallado para información del día
                if (!asistenciasPorDia[fechaKey]) {
                    asistenciasPorDia[fechaKey] = {
                        tipos: {},
                        asignaturas: [],
                        total: 0
                    };
                }

                asistenciasPorDia[fechaKey].tipos[codigo] = (asistenciasPorDia[fechaKey].tipos[codigo] || 0) + 1;
                asistenciasPorDia[fechaKey].asignaturas.push(asignatura);
                asistenciasPorDia[fechaKey].total++;
            });

            // Determinar el mes a mostrar
            const fechaInicio = new Date('{{ $fechaInicio->format('Y-m-d') }}');
            const fechaFin = new Date('{{ $fechaFin->format('Y-m-d') }}');

            if (mesForzado) {
                mesActualCalendario = new Date(mesForzado);
            } else if (!mesActualCalendario) {
                // Inicializar con el mes más reciente que tenga datos, o el mes actual
                if (asistencias.length > 0) {
                    const ultimaAsistencia = asistencias[0]; // Ya están ordenadas por fecha descendente
                    mesActualCalendario = new Date(ultimaAsistencia.fecha);
                } else {
                    mesActualCalendario = new Date(fechaFin.getFullYear(), fechaFin.getMonth(), 1);
                }
            }

            const primerDiaMes = new Date(mesActualCalendario.getFullYear(), mesActualCalendario.getMonth(), 1);
            const ultimoDiaMes = new Date(mesActualCalendario.getFullYear(), mesActualCalendario.getMonth() + 1, 0);

            let html = `<h6 class="text-center mb-3 calendar-header">${mesActualCalendario.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' }).toUpperCase()}</h6>`;
            html += '<div class="calendar-grid">';

            // Días de la semana
            ['L', 'M', 'M', 'J', 'V', 'S', 'D'].forEach(dia => {
                html += `<div class="text-center fw-bold text-muted">${dia}</div>`;
            });

            // Espacios vacíos para alinear con el primer día del mes
            for (let i = 0; i < primerDiaMes.getDay(); i++) {
                html += '<div></div>';
            }

            // Días del mes
            for (let d = new Date(primerDiaMes); d <= ultimoDiaMes; d.setDate(d.getDate() + 1)) {
                const fechaStr = d.toISOString().split('T')[0]; // YYYY-MM-DD format
                const codigo = asistenciasMap[fechaStr];
                const detalleDia = asistenciasPorDia[fechaStr];

                let color = '#f8f9fa';
                let textColor = '#6c757d';
                let title = `${fechaStr}: Sin registro`;
                let contenidoDia = d.getDate();
                let clasesExtra = '';

                if (codigo) {
                    // Determinar el color basado en el tipo más frecuente o más grave
                    const tiposOrden = ['F', 'T', 'J', 'A']; // Orden de prioridad: Ausente > Tardanza > Justificada > Presente
                    let tipoPrincipal = 'A'; // Default a presente

                    for (const tipo of tiposOrden) {
                        if (detalleDia && detalleDia.tipos[tipo]) {
                            tipoPrincipal = tipo;
                            break;
                        }
                    }

                    switch (tipoPrincipal) {
                        case 'A':
                            color = '#28a745';
                            textColor = 'white';
                            break;
                        case 'F':
                            color = '#dc3545';
                            textColor = 'white';
                            break;
                        case 'T':
                            color = '#ffc107';
                            textColor = 'black';
                            break;
                        case 'J':
                            color = '#6c757d';
                            textColor = 'white';
                            break;
                    }

                    // Construir título detallado
                    title = `${fechaStr}\n`;
                    if (detalleDia) {
                        title += `Total: ${detalleDia.total} registro${detalleDia.total > 1 ? 's' : ''}\n`;

                        const tiposInfo = [];
                        if (detalleDia.tipos['A']) tiposInfo.push(`${detalleDia.tipos['A']} presente${detalleDia.tipos['A'] > 1 ? 's' : ''}`);
                        if (detalleDia.tipos['F']) tiposInfo.push(`${detalleDia.tipos['F']} ausente${detalleDia.tipos['F'] > 1 ? 's' : ''}`);
                        if (detalleDia.tipos['T']) tiposInfo.push(`${detalleDia.tipos['T']} tardanza${detalleDia.tipos['T'] > 1 ? 's' : ''}`);
                        if (detalleDia.tipos['J']) tiposInfo.push(`${detalleDia.tipos['J']} justificada${detalleDia.tipos['J'] > 1 ? 's' : ''}`);

                        if (tiposInfo.length > 0) {
                            title += tiposInfo.join(', ') + '\n';
                        }

                        // Mostrar asignaturas (limitado a 3)
                        const asignaturasUnicas = [...new Set(detalleDia.asignaturas)].slice(0, 3);
                        if (asignaturasUnicas.length > 0) {
                            title += '\nAsignaturas:\n' + asignaturasUnicas.join('\n');
                            if (detalleDia.asignaturas.length > 3) {
                                title += `\n...y ${detalleDia.asignaturas.length - 3} más`;
                            }
                        }
                    }

                    // Mostrar número de registros si hay más de uno
                    if (detalleDia && detalleDia.total > 1) {
                        contenidoDia = `${d.getDate()}<br><small style="font-size: 0.6em; opacity: 0.8;">${detalleDia.total}</small>`;
                    }
                }

                // Verificar si la fecha está dentro del rango de consulta
                const fechaActual = new Date(fechaStr);
                const estaEnRango = fechaActual >= fechaInicio && fechaActual <= fechaFin;

                if (!estaEnRango) {
                    color = '#e9ecef';
                    textColor = '#adb5bd';
                    title += '\n(fuera del rango de consulta)';
                    clasesExtra = 'opacity-50';
                }

                html += `<div class="calendar-day ${clasesExtra}"
                 style="background-color: ${color}; color: ${textColor}; border: 2px solid ${codigo ? '#fff' : '#dee2e6'};"
                 title="${title}">
                ${contenidoDia}
             </div>`;
            }

            html += '</div>';

            // Leyenda mejorada con estadísticas
            const totalDias = asistencias.length;
            const diasPresente = asistencias.filter(a => (a.tipo_asistencia || a.tipoAsistencia)?.codigo === 'A').length;
            const diasAusente = asistencias.filter(a => (a.tipo_asistencia || a.tipoAsistencia)?.codigo === 'F').length;
            const diasTardanza = asistencias.filter(a => (a.tipo_asistencia || a.tipoAsistencia)?.codigo === 'T').length;
            const diasJustificada = asistencias.filter(a => (a.tipo_asistencia || a.tipoAsistencia)?.codigo === 'J').length;

            html += `
                <div class="mt-3">
                    <div class="row text-center mb-2">
                        <div class="col-3">
                            <small class="text-muted d-block">Presente</small>
                            <span class="badge bg-success">${diasPresente}</span>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">Ausente</small>
                            <span class="badge bg-danger">${diasAusente}</span>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">Tardanza</small>
                            <span class="badge bg-warning text-dark">${diasTardanza}</span>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">Justificada</small>
                            <span class="badge bg-secondary">${diasJustificada}</span>
                        </div>
                    </div>
                    <small class="text-muted text-center d-block">
                        <strong>Total de registros en ${mesActualCalendario.toLocaleDateString('es-ES', { month: 'long' })}:</strong> ${totalDias}
                    </small>
                </div>
            `;

            calendario.innerHTML = html;
        }

        function exportarPDFGeneral() {
            // Redirigir a la ruta de exportación PDF general
            window.location.href = '{{ route('asistencia.exportar-pdf', $matricula->matricula_id) }}';
        }

        function exportarPDFAsignatura(asignaturaNombre) {
            // Redirigir a la ruta de exportación PDF por asignatura
            const url = '{{ route('asistencia.exportar-pdf', $matricula->matricula_id) }}' +
                       '?asignatura=' + encodeURIComponent(asignaturaNombre) +
                       '&fecha_inicio={{ $fechaInicio->format('Y-m-d') }}' +
                       '&fecha_fin={{ $fechaFin->format('Y-m-d') }}';
            window.location.href = url;
        }
    </script>

@endsection
