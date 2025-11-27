{{-- resources/views/asistencia/reporte-curso.blade.php --}}
@extends('cplantilla.bprincipal')

@section('titulo', 'Reporte de Asistencia por Curso')

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
            background: #007bff !important;
            border: none;
            transition: background-color 0.2s ease, transform 0.1s ease;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
        }

        .btn-primary:hover {
            background-color: #0056b3 !important;
            transform: scale(1.01);
        }

        .stats-card {
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.15;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 1rem;
        }

        .table-custom {
            border: 1px solid #0A8CB3;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-custom thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #0A8CB3;
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

        .curso-header {
            background: #0A8CB3;
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .badge-asistencia {
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .progress-bar-custom {
            height: 25px;
            border-radius: 5px;
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

        .filter-section {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .student-row {
            cursor: pointer;
            transition: all 0.2s;
        }

        .student-row:hover {
            background-color: #e3f2fd !important;
        }
    </style>

    <div class="container-fluid" id="contenido-principal" style="position: relative;">
        @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])

        <div class="row mt-4 ml-1 mr-1">
            <div class="col-12">
                <div class="box_block">
                    <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                        data-toggle="collapse" data-target="#collapseReporteCurso" aria-expanded="true"
                        style="background: #0A8CB3 !important; font-weight: bold; color: white;">
                        <i class="fas fa-chart-bar m-1"></i>&nbsp;Reporte de Asistencia por Curso
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>

                    <div class="card-body info">
                        <div class="d-flex">
                            <div>
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                            <div class="p-2 flex-fill">
                                <p>
                                    Consulta el reporte consolidado de asistencia para el curso seleccionado, incluyendo
                                    estadísticas generales y detalle por estudiante.
                                </p>
                                <p>
                                    Utiliza los filtros para personalizar el período de análisis y obtener información
                                    específica.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="collapse show" id="collapseReporteCurso">
                        <div class="card card-body rounded-0 border-0 pt-3 pb-2"
                            style="background-color: #fcfffc !important">

                            <!-- Header del Curso -->
                            <div class="curso-header">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="mb-2">
                                            <i class="fas fa-book-open"></i>
                                            {{ $cursoAsignatura->asignatura->nombre }}
                                        </h4>
                                        <div>
                                            <span class="me-3">
                                                <i class="fas fa-graduation-cap"></i>
                                                {{ $cursoAsignatura->curso->grado->nombre }} -
                                                {{ $cursoAsignatura->curso->seccion->nombre }}
                                            </span>
                                            <span class="me-3">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                                {{ $cursoAsignatura->profesor->nombres }}
                                                {{ $cursoAsignatura->profesor->apellidos }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                                        <button class="btn btn-light" onclick="exportarPDF()">
                                            <i class="fas fa-file-pdf"></i> Exportar PDF
                                        </button>
                                        <button class="btn btn-light" onclick="exportarExcel()">
                                            <i class="fas fa-file-excel"></i> Exportar Excel
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtros -->
                            <div class="filter-section">
                                <form id="formFiltros" method="GET">
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <label class="estilo-info">Fecha Inicio:</label>
                                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                                value="{{ $fechaInicio->format('Y-m-d') }}" onchange="aplicarFiltros()">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="estilo-info">Fecha Fin:</label>
                                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                                                value="{{ $fechaFin->format('Y-m-d') }}" onchange="aplicarFiltros()">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary w-100" onclick="aplicarFiltros()">
                                                <i class="fas fa-filter"></i> Aplicar Filtros
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Estadísticas Generales -->
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <div class="card stats-card" style="background: #495057; color: white;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-1" style="color: rgba(255,255,255,0.8);">Total
                                                        Estudiantes</p>
                                                    <h3 class="mb-0">{{ $estadisticas['total_estudiantes'] }}</h3>
                                                </div>
                                                <i class="fas fa-users stat-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 mb-2">
                                    <div class="card stats-card" style="background: #28a745; color: white;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-1" style="color: rgba(255,255,255,0.8);">% Asistencia</p>
                                                    <h3 class="mb-0">{{ $estadisticas['porcentaje_asistencia'] }}%</h3>
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
                                                    <p class="mb-1" style="color: rgba(255,255,255,0.8);">Total Ausencias
                                                    </p>
                                                    <h3 class="mb-0">{{ $estadisticas['total_ausencias'] }}</h3>
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
                                                    <p class="mb-1" style="color: rgba(255,255,255,0.8);">Total Tardanzas
                                                    </p>
                                                    <h3 class="mb-0">{{ $estadisticas['total_tardanzas'] }}</h3>
                                                </div>
                                                <i class="fas fa-clock stat-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gráficos -->
                            <div class="row mb-3">
                                <div class="col-lg-8 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info">
                                                <i class="fas fa-chart-area text-primary"></i>
                                                Tendencia de Asistencia
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="tendenciaChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info">
                                                <i class="fas fa-chart-pie text-primary"></i>
                                                Distribución
                                            </h6>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="chart-container">
                                                <canvas id="distribucionChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de Estudiantes -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header"
                                            style="background: #f8f9fa; border-bottom: 2px solid #0A8CB3;">
                                            <h6 class="mb-0 estilo-info">
                                                <i class="fas fa-list text-primary"></i>
                                                Detalle por Estudiante
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-custom text-center">
                                                    <thead class="estilo-info">
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Estudiante</th>
                                                            <th scope="col">Documento</th>
                                                            <th scope="col">Presentes</th>
                                                            <th scope="col">Ausencias</th>
                                                            <th scope="col">Tardanzas</th>
                                                            <th scope="col">Justificadas</th>
                                                            <th scope="col">% Asistencia</th>
                                                            <th scope="col">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($estudiantes as $index => $item)
                                                            <tr class="student-row">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td class="text-left">
                                                                    {{ $item['estudiante']->nombres }}
                                                                    {{ $item['estudiante']->apellidos }}
                                                                </td>
                                                                <td>{{ $item['estudiante']->documento }}</td>
                                                                <td>
                                                                    <span class="badge badge-asistencia"
                                                                        style="background: #28a745; color: white;">
                                                                        {{ $item['presentes'] }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-asistencia"
                                                                        style="background: #dc3545; color: white;">
                                                                        {{ $item['ausencias'] }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-asistencia"
                                                                        style="background: #ffc107; color: white;">
                                                                        {{ $item['tardanzas'] }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-asistencia"
                                                                        style="background: #6c757d; color: white;">
                                                                        {{ $item['justificadas'] }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <div class="progress progress-bar-custom">
                                                                        <div class="progress-bar 
                                                                        @if ($item['porcentaje'] >= 90) bg-success
                                                                        @elseif($item['porcentaje'] >= 75) bg-warning
                                                                        @else bg-danger @endif"
                                                                            style="width: {{ $item['porcentaje'] }}%">
                                                                            {{ $item['porcentaje'] }}%
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('asistencia.detalle-estudiante', $item['matricula_id']) }}"
                                                                        class="btn btn-sm btn-primary"
                                                                        title="Ver detalle">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('loaderPrincipal');
            if (loader) loader.style.display = 'none';

            // Datos para gráficos
            const datosGrafico = @json($datosGrafico);

            // Gráfico de Tendencia
            const ctxTendencia = document.getElementById('tendenciaChart').getContext('2d');
            new Chart(ctxTendencia, {
                type: 'line',
                data: {
                    labels: datosGrafico.labels,
                    datasets: [{
                        label: 'Asistencia',
                        data: datosGrafico.asistencias,
                        borderColor: '#0A8CB3',
                        backgroundColor: 'rgba(10, 140, 179, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Gráfico de Distribución
            const ctxDistribucion = document.getElementById('distribucionChart').getContext('2d');
            new Chart(ctxDistribucion, {
                type: 'doughnut',
                data: {
                    labels: ['Presentes', 'Ausencias', 'Tardanzas', 'Justificadas'],
                    datasets: [{
                        data: [
                            datosGrafico.presentes,
                            datosGrafico.ausencias,
                            datosGrafico.tardanzas,
                            datosGrafico.justificadas
                        ],
                        backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#6c757d'],
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
        });

        function aplicarFiltros() {
            const loader = document.getElementById('loaderPrincipal');
            if (loader) loader.style.display = 'flex';

            const form = document.getElementById('formFiltros');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            window.location.href = window.location.pathname + '?' + params.toString();
        }

        function exportarPDF() {
            // Get current filter values
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;

            // Build URL with parameters
            let url = '{{ route('asistencia.exportar-pdf-curso', $cursoAsignatura->curso_asignatura_id) }}';
            if (fechaInicio) url += '?fecha_inicio=' + fechaInicio;
            if (fechaFin) url += (fechaInicio ? '&' : '?') + 'fecha_fin=' + fechaFin;

            // Open in new tab
            window.open(url, '_blank');
        }

        function exportarExcel() {
            const wb = XLSX.utils.book_new();
            const data = @json($estudiantes);

            const wsData = [
                ['Estudiante', 'Documento', 'Presentes', 'Ausencias', 'Tardanzas', 'Justificadas', '% Asistencia']
            ];

            data.forEach(item => {
                wsData.push([
                    item.estudiante.nombres + ' ' + item.estudiante.apellidos,
                    item.estudiante.documento,
                    item.presentes,
                    item.ausencias,
                    item.tardanzas,
                    item.justificadas,
                    item.porcentaje + '%'
                ]);
            });

            const ws = XLSX.utils.aoa_to_sheet(wsData);
            XLSX.utils.book_append_sheet(wb, ws, 'Asistencias');
            XLSX.writeFile(wb, 'reporte_asistencia_curso.xlsx');
        }
    </script>

@endsection
