@extends('cplantilla.bprincipal')

@section('titulo', 'Mis Justificaciones de Asistencia')

@section('contenidoplantilla')
    <style>
        .estilo-info {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
        }

        @media (max-width: 576px) {
            .margen-movil {
                margin-left: -29px !important;
                margin-right: -29px !important;
            }

            .margen-movil-2 {
                margin: 0 !important;
                padding: 0 !important;
            }
        }

        .estado-badge {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
        }

        .justificacion-card {
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .justificacion-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
    </style>

    <div class="container-fluid estilo-info margen-movil-2">
        <div class="row mt-4 ml-1 mr-1">
            <div class="col-12 mb-3">
                <div class="box_block">
                    <button style="background: #0A8CB3 !important; border:none"
                        class="btn btn-primary btn-block text-left rounded-0 btn_header header_6 estilo-info" type="button"
                        data-toggle="collapse" data-target="#collapseJustificaciones" aria-expanded="true"
                        aria-controls="collapseJustificaciones">
                        <i class="fas fa-file-alt"></i>&nbsp;Mis Justificaciones de Asistencia
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>
                </div>
                <div class="collapse show" id="collapseJustificaciones">
                    <div class="card card-body rounded-0 border-0 pt-0"
                        style="padding-left:0.966666666rem;padding-right:0.9033333333333333rem;">
                        <div class="row margen-movil" style="padding:20px;">
                            <div class="col-12">

                                <!-- Filtros -->
                                <div class="card mb-4" style="border: none">
                                    <div
                                        style="background: #E0F7FA; color: #0A8CB3; font-weight: bold; border: 2px solid #86D2E3; border-bottom: 2px solid #86D2E3; padding: 6px 20px; border-radius:4px 4px 0px 0px;">
                                        <i class="fas fa-filter mr-2"></i>
                                        Filtros
                                    </div>
                                    <div class="card-body"
                                        style="border: 2px solid #86D2E3; border-top: none; border-radius: 0px 0px 4px 4px !important;">
                                        <form method="GET" action="{{ route('asistencia.mis-justificaciones') }}" class="row g-3">
                                            <div class="col-md-3">
                                                <label for="estado" class="form-label estilo-info">Estado</label>
                                                <select name="estado" id="estado" class="form-control">
                                                    <option value="">Todos</option>
                                                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                                                    <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobadas</option>
                                                    <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazadas</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="estudiante_id" class="form-label estilo-info">Estudiante</label>
                                                <select name="estudiante_id" id="estudiante_id" class="form-control">
                                                    <option value="">Todos los estudiantes</option>
                                                    @foreach($estudiantes as $estudiante)
                                                        <option value="{{ $estudiante['estudiante_id'] }}" {{ request('estudiante_id') == $estudiante['estudiante_id'] ? 'selected' : '' }}>
                                                            {{ $estudiante['nombre_completo'] }} - {{ $estudiante['grado_seccion'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="fecha_desde" class="form-label estilo-info">Fecha Desde</label>
                                                <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                                                       value="{{ request('fecha_desde') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="fecha_hasta" class="form-label estilo-info">Fecha Hasta</label>
                                                <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                                                       value="{{ request('fecha_hasta') }}">
                                            </div>
                                            <div class="col-md-12 d-flex">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search"></i> Filtrar
                                                </button>
                                                <a href="{{ route('asistencia.mis-justificaciones') }}" class="btn btn-secondary ml-2">
                                                    <i class="fas fa-times"></i> Limpiar
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Estadísticas -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card text-center" style="background: #fff3cd; border: 2px solid #ffc107;">
                                            <div class="card-body">
                                                <h5 class="card-title text-warning">
                                                    <i class="fas fa-clock fa-2x"></i>
                                                </h5>
                                                <h3 class="text-warning">{{ $estadisticas['pendientes'] }}</h3>
                                                <p class="mb-0">Pendientes</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center" style="background: #d1ecf1; border: 2px solid #17a2b8;">
                                            <div class="card-body">
                                                <h5 class="card-title text-info">
                                                    <i class="fas fa-check-circle fa-2x"></i>
                                                </h5>
                                                <h3 class="text-info">{{ $estadisticas['aprobadas'] }}</h3>
                                                <p class="mb-0">Aprobadas</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center" style="background: #f8d7da; border: 2px solid #dc3545;">
                                            <div class="card-body">
                                                <h5 class="card-title text-danger">
                                                    <i class="fas fa-times-circle fa-2x"></i>
                                                </h5>
                                                <h3 class="text-danger">{{ $estadisticas['rechazadas'] }}</h3>
                                                <p class="mb-0">Rechazadas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lista de Justificaciones -->
                                <div class="card" style="border: none">
                                    <div
                                        style="background: #E0F7FA; color: #0A8CB3; font-weight: bold; border: 2px solid #86D2E3; border-bottom: 2px solid #86D2E3; padding: 6px 20px; border-radius:4px 4px 0px 0px;">
                                        <i class="fas fa-list mr-2"></i>
                                        Mis Justificaciones ({{ $justificaciones->total() }})
                                    </div>
                                    <div class="card-body"
                                        style="border: 2px solid #86D2E3; border-top: none; border-radius: 0px 0px 4px 4px !important;">

                                        @if($justificaciones->isEmpty())
                                            <div class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No hay justificaciones para mostrar</h5>
                                                <p class="text-muted">Prueba cambiando los filtros de búsqueda</p>
                                                <a href="{{ route('asistencia.justificar') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus"></i> Crear Nueva Justificación
                                                </a>
                                            </div>
                                        @else
                                            @foreach($justificaciones as $justificacion)
                                                <div class="justificacion-card">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-8">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <h6 class="mb-0 mr-3">
                                                                        {{ $justificacion->matricula->estudiante->nombres }}
                                                                        {{ $justificacion->matricula->estudiante->apellidos }}
                                                                    </h6>
                                                                    <span class="estado-badge badge badge-{{ $justificacion->getEstadoColorAttribute() }}">
                                                                        {{ ucfirst($justificacion->estado) }}
                                                                    </span>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <small class="text-muted">
                                                                            <i class="fas fa-calendar"></i>
                                                                            Fecha: {{ $justificacion->fecha->format('d/m/Y') }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <small class="text-muted">
                                                                            <i class="fas fa-tag"></i>
                                                                            Motivo: {{ $justificacion->motivo }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <small class="text-muted">
                                                                            <i class="fas fa-clock"></i>
                                                                            Enviada: {{ $justificacion->created_at->format('d/m/Y H:i') }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <p class="mb-1"><strong>Descripción:</strong></p>
                                                                    <p class="text-muted mb-0">{{ Str::limit($justificacion->descripcion, 150) }}</p>
                                                                </div>
                                                                @if($justificacion->documento_justificacion)
                                                                    <div class="mt-2">
                                                                        <a href="{{ asset('storage/justificaciones/' . basename($justificacion->documento_justificacion)) }}"
                                                                           target="_blank" class="btn btn-sm btn-outline-primary">
                                                                            <i class="fas fa-file"></i> Ver documento adjunto
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-4">
                                                                @if($justificacion->estado !== 'pendiente')
                                                                    <div class="text-md-right">
                                                                        <small class="text-muted">
                                                                            <strong>Revisado por:</strong><br>
                                                                            {{ $justificacion->usuarioRevisor ? $justificacion->usuarioRevisor->nombres . ' ' . $justificacion->usuarioRevisor->apellidos : 'N/A' }}<br>
                                                                            <i class="fas fa-calendar-check"></i> {{ $justificacion->fecha_revision ? $justificacion->fecha_revision->format('d/m/Y H:i') : 'N/A' }}
                                                                        </small>
                                                                        @if($justificacion->observaciones_revision)
                                                                            <div class="mt-2 p-2 bg-light rounded">
                                                                                <strong>Observaciones del revisor:</strong><br>
                                                                                <small class="text-muted">{{ $justificacion->observaciones_revision }}</small>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="text-center">
                                                                        <div class="alert alert-warning py-2">
                                                                            <i class="fas fa-clock"></i>
                                                                            <small><strong>En revisión</strong><br>Esta justificación está siendo evaluada por un administrador.</small>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Paginación -->
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $justificaciones->links() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Botón para crear nueva justificación -->
                                <div class="text-center mt-4">
                                    <a href="{{ route('asistencia.justificar') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus"></i> Crear Nueva Justificación
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control {
            border: 1px solid #DAA520;
        }
    </style>
@endsection
