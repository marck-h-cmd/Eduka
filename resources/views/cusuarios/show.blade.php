@extends('cplantilla.bprincipal')
@section('titulo', 'Detalles del Usuario')
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
        margin: 0;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
    }

    .btn-primary:hover {
        background-color: #0056b3 !important;
        transform: scale(1.01);
    }

    .btn-secondary {
        background: #6c757d !important;
        border: none;
        transition: background-color 0.2s ease, transform 0.1s ease;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
    }

    .btn-secondary:hover {
        background-color: #545b62 !important;
        transform: scale(1.01);
    }

    .btn-warning {
        background: #ffc107 !important;
        border: none;
        transition: background-color 0.2s ease, transform 0.1s ease;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
    }

    .btn-warning:hover {
        background-color: #e0a800 !important;
        transform: scale(1.01);
    }

    .detail-label {
        font-weight: 700;
        color: #004a92;
        font-size: 0.9rem;
    }

    .detail-value {
        font-size: 1rem;
        color: #333;
        padding: 8px 0;
    }

    .badge-detail {
        font-size: 0.85rem;
        padding: 6px 12px;
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
</style>
<div class="container-fluid" id="contenido-principal" style="position: relative;">
    @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])
    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12">
            <div class="box_block">
                <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                    data-toggle="collapse" data-target="#collapseExample0" aria-expanded="true"
                    aria-controls="collapseExample"
                    style="background: #0A8CB3 !important; font-weight: bold; color: white;">
                    <i class="fas fa-user m-1"></i>&nbsp;Detalles del Usuario: {{ $usuario->username }}
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x" style="color: #0A8CB3;"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p class="mb-0" style="font-size:1.1rem; color:#004a92; font-weight:700;">
                                Información detallada del usuario registrado en el sistema.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2"
                        style="background-color: #fcfffc !important">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="estilo-info">ID Usuario</label>
                                    <div class="detail-value bg-light p-2 rounded">{{ $usuario->id_usuario }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="estilo-info">Estado</label>
                                    <div class="detail-value">
                                        <span class="badge badge-{{ $usuario->estado == 'Activo' ? 'success' : 'danger' }} badge-detail">
                                            <i class="fas fa-{{ $usuario->estado == 'Activo' ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                            {{ $usuario->estado }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="estilo-info">Nombre de Usuario</label>
                                    <div class="detail-value bg-light p-2 rounded">{{ $usuario->username }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="estilo-info">Email</label>
                                    <div class="detail-value bg-light p-2 rounded">{{ $usuario->email ?: 'No especificado' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="estilo-info">Información de la Persona</label>
                            <div class="detail-value bg-light p-3 rounded">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Nombre:</strong> {{ $usuario->persona->nombres }} {{ $usuario->persona->apellidos }}<br>
                                        <strong>DNI:</strong> {{ $usuario->persona->dni }}<br>
                                        <strong>Email:</strong> {{ $usuario->persona->email ?: 'No especificado' }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Teléfono:</strong> {{ $usuario->persona->telefono ?: 'No especificado' }}<br>
                                        <strong>Estado:</strong>
                                        <span class="badge badge-{{ $usuario->persona->estado == 'Activo' ? 'success' : 'danger' }} ml-1">
                                            {{ $usuario->persona->estado }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="estilo-info">Roles Asignados</label>
                            <div class="detail-value bg-light p-3 rounded">
                                @if($usuario->persona->roles->count() > 0)
                                    @foreach($usuario->persona->roles as $rol)
                                        <span class="badge badge-info mr-2 mb-1">
                                            <i class="fas fa-user-shield mr-1"></i>{{ $rol->nombre }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>No hay roles asignados
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-center">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-warning">
                                        <i class="fas fa-edit mr-2"></i>Editar Usuario
                                    </a>
                                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Loader para editar
        document.querySelectorAll('a[href*="usuarios.edit"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        });

        // Loader para volver
        document.querySelectorAll('a[href*="usuarios.index"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        });
    });
</script>
@endsection
