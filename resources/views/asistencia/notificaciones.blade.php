@extends('cplantilla.bprincipal')

@section('titulo', 'Notificaciones de Asistencia')

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

        .notificacion-card {
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 1rem;
            position: relative;
        }

        .notificacion-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .notificacion-card.unread {
            border-left: 4px solid #007bff;
            background-color: #f8f9ff;
        }

        .notificacion-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .tipo-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
        }

        .marcar-leida {
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .marcar-leida:hover {
            opacity: 1;
        }
    </style>

    <div class="container-fluid estilo-info margen-movil-2">
        <div class="row mt-4 ml-1 mr-1">
            <div class="col-12 mb-3">
                <div class="box_block">
                    <button style="background: #0A8CB3 !important; border:none"
                        class="btn btn-primary btn-block text-left rounded-0 btn_header header_6 estilo-info" type="button"
                        data-toggle="collapse" data-target="#collapseNotificaciones" aria-expanded="true"
                        aria-controls="collapseNotificaciones">
                        <i class="fas fa-bell"></i>&nbsp;Notificaciones de Asistencia
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>
                </div>
                <div class="collapse show" id="collapseNotificaciones">
                    <div class="card card-body rounded-0 border-0 pt-0"
                        style="padding-left:0.966666666rem;padding-right:0.9033333333333333rem;">
                        <div class="row margen-movil" style="padding:20px;">
                            <div class="col-12">

                                <!-- Estadísticas -->
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="card text-center" style="background: #e3f2fd; border: 2px solid #2196f3;">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">
                                                    <i class="fas fa-envelope fa-2x"></i>
                                                </h5>
                                                <h3 class="text-primary">{{ $estadisticas['total'] }}</h3>
                                                <p class="mb-0">Total</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center" style="background: #fff3e0; border: 2px solid #ff9800;">
                                            <div class="card-body">
                                                <h5 class="card-title text-warning">
                                                    <i class="fas fa-envelope-open fa-2x"></i>
                                                </h5>
                                                <h3 class="text-warning">{{ $estadisticas['no_leidas'] }}</h3>
                                                <p class="mb-0">No Leídas</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center" style="background: #e8f5e8; border: 2px solid #4caf50;">
                                            <div class="card-body">
                                                <h5 class="card-title text-success">
                                                    <i class="fas fa-check-circle fa-2x"></i>
                                                </h5>
                                                <h3 class="text-success">{{ $estadisticas['leidas'] }}</h3>
                                                <p class="mb-0">Leídas</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center" style="background: #ffebee; border: 2px solid #f44336;">
                                            <div class="card-body">
                                                <h5 class="card-title text-danger">
                                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                                </h5>
                                                <h3 class="text-danger">{{ $estadisticas['urgentes'] }}</h3>
                                                <p class="mb-0">Urgentes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filtros y Acciones -->
                                <div class="card mb-4" style="border: none">
                                    <div
                                        style="background: #E0F7FA; color: #0A8CB3; font-weight: bold; border: 2px solid #86D2E3; border-bottom: 2px solid #86D2E3; padding: 6px 20px; border-radius:4px 4px 0px 0px;">
                                        <i class="fas fa-filter mr-2"></i>
                                        Filtros y Acciones
                                    </div>
                                    <div class="card-body"
                                        style="border: 2px solid #86D2E3; border-top: none; border-radius: 0px 0px 4px 4px !important;">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <form method="GET" action="{{ route('asistencia.notificaciones') }}" class="d-flex">
                                                    <select name="estado" class="form-control mr-2" onchange="this.form.submit()">
                                                        <option value="">Todas las notificaciones</option>
                                                        <option value="no_leida" {{ request('estado') == 'no_leida' ? 'selected' : '' }}>No leídas</option>
                                                        <option value="leida" {{ request('estado') == 'leida' ? 'selected' : '' }}>Leídas</option>
                                                    </select>
                                                    <select name="tipo" class="form-control mr-2" onchange="this.form.submit()">
                                                        <option value="">Todos los tipos</option>
                                                        <option value="ausencia" {{ request('tipo') == 'ausencia' ? 'selected' : '' }}>Ausencias</option>
                                                        <option value="tardanza" {{ request('tipo') == 'tardanza' ? 'selected' : '' }}>Tardanzas</option>
                                                        <option value="justificacion" {{ request('tipo') == 'justificacion' ? 'selected' : '' }}>Justificaciones</option>
                                                        <option value="recordatorio" {{ request('tipo') == 'recordatorio' ? 'selected' : '' }}>Recordatorios</option>
                                                    </select>
                                                </form>
                                            </div>
                                            <div class="col-md-6 text-md-right">
                                                @if($notificaciones->where('leida', false)->count() > 0)
                                                    <button type="button" class="btn btn-outline-primary" onclick="marcarTodasLeidas()">
                                                        <i class="fas fa-check-double"></i> Marcar todas como leídas
                                                    </button>
                                                @endif
                                                <a href="{{ route('asistencia.notificaciones') }}" class="btn btn-secondary ml-2">
                                                    <i class="fas fa-sync"></i> Actualizar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lista de Notificaciones -->
                                <div class="card" style="border: none">
                                    <div
                                        style="background: #E0F7FA; color: #0A8CB3; font-weight: bold; border: 2px solid #86D2E3; border-bottom: 2px solid #86D2E3; padding: 6px 20px; border-radius:4px 4px 0px 0px;">
                                        <i class="fas fa-list mr-2"></i>
                                        Notificaciones ({{ $notificaciones->total() }})
                                    </div>
                                    <div class="card-body"
                                        style="border: 2px solid #86D2E3; border-top: none; border-radius: 0px 0px 4px 4px !important;">

                                        @if($notificaciones->isEmpty())
                                            <div class="text-center py-5">
                                                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No tienes notificaciones</h5>
                                                <p class="text-muted">Las notificaciones de asistencia aparecerán aquí</p>
                                            </div>
                                        @else
                                            @foreach($notificaciones as $notificacion)
                                                <div class="notificacion-card {{ $notificacion->leida ? '' : 'unread' }}">
                                                    <div class="card-body">
                                                        <div class="row align-items-start">
                                                            <div class="col-auto">
                                                                <div class="notificacion-icon
                                                                    @if($notificacion->tipo === 'ausencia') bg-danger text-white
                                                                    @elseif($notificacion->tipo === 'tardanza') bg-warning text-dark
                                                                    @elseif($notificacion->tipo === 'justificacion') bg-info text-white
                                                                    @elseif($notificacion->tipo === 'recordatorio') bg-primary text-white
                                                                    @else bg-secondary text-white @endif">
                                                                    @if($notificacion->tipo === 'ausencia')
                                                                        <i class="fas fa-times-circle"></i>
                                                                    @elseif($notificacion->tipo === 'tardanza')
                                                                        <i class="fas fa-clock"></i>
                                                                    @elseif($notificacion->tipo === 'justificacion')
                                                                        <i class="fas fa-file-medical"></i>
                                                                    @elseif($notificacion->tipo === 'recordatorio')
                                                                        <i class="fas fa-bell"></i>
                                                                    @else
                                                                        <i class="fas fa-info-circle"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-1 {{ $notificacion->leida ? 'text-muted' : 'text-dark' }}">
                                                                            {{ $notificacion->titulo }}
                                                                            @if(!$notificacion->leida)
                                                                                <span class="badge badge-primary badge-sm ml-2">Nuevo</span>
                                                                            @endif
                                                                        </h6>
                                                                        <span class="tipo-badge
                                                                            @if($notificacion->tipo === 'ausencia') badge-danger
                                                                            @elseif($notificacion->tipo === 'tardanza') badge-warning
                                                                            @elseif($notificacion->tipo === 'justificacion') badge-info
                                                                            @elseif($notificacion->tipo === 'recordatorio') badge-primary
                                                                            @else badge-secondary @endif">
                                                                            {{ ucfirst($notificacion->tipo) }}
                                                                        </span>
                                                                    </div>
                                                                    <small class="text-muted">
                                                                        {{ $notificacion->created_at->diffForHumans() }}
                                                                    </small>
                                                                </div>
                                                                <p class="mb-2 {{ $notificacion->leida ? 'text-muted' : 'text-dark' }}">
                                                                    {{ $notificacion->mensaje }}
                                                                </p>
                                                                @if($notificacion->datos_adicionales)
                                                                    <div class="mb-2">
                                                                        @if(isset($notificacion->datos_adicionales['estudiante']))
                                                                            <small class="text-muted">
                                                                                <i class="fas fa-user"></i>
                                                                                Estudiante: {{ $notificacion->datos_adicionales['estudiante'] }}
                                                                            </small>
                                                                        @endif
                                                                        @if(isset($notificacion->datos_adicionales['fecha']))
                                                                            <br><small class="text-muted">
                                                                                <i class="fas fa-calendar"></i>
                                                                                Fecha: {{ \Carbon\Carbon::parse($notificacion->datos_adicionales['fecha'])->format('d/m/Y') }}
                                                                            </small>
                                                                        @endif
                                                                        @if(isset($notificacion->datos_adicionales['curso']))
                                                                            <br><small class="text-muted">
                                                                                <i class="fas fa-graduation-cap"></i>
                                                                                Curso: {{ $notificacion->datos_adicionales['curso'] }}
                                                                            </small>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        @if($notificacion->accion_url)
                                                                            <a href="{{ $notificacion->accion_url }}" class="btn btn-sm btn-outline-primary">
                                                                                <i class="fas fa-external-link-alt"></i> Ver detalles
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                    <div class="marcar-leida">
                                                                        @if(!$notificacion->leida)
                                                                            <button type="button" class="btn btn-sm btn-link text-muted"
                                                                                    onclick="marcarLeida({{ $notificacion->id }})">
                                                                                <i class="fas fa-check"></i> Marcar como leída
                                                                            </button>
                                                                        @else
                                                                            <small class="text-muted">
                                                                                <i class="fas fa-check-circle text-success"></i> Leída
                                                                            </small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Paginación -->
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $notificaciones->links() }}
                                            </div>
                                        @endif
                                    </div>
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

@section('scripts')
    <script>
        function marcarLeida(notificacionId) {
            fetch(`{{ route('asistencia.notificaciones') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    notificacion_id: notificacionId,
                    action: 'marcar_leida'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Ocurrió un error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la solicitud');
            });
        }

        function marcarTodasLeidas() {
            if (!confirm('¿Estás seguro de marcar todas las notificaciones como leídas?')) {
                return;
            }

            fetch(`{{ route('asistencia.notificaciones') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'marcar_todas_leidas'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Ocurrió un error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la solicitud');
            });
        }
    </script>
@endsection
