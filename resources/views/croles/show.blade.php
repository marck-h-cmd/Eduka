@extends('cplantilla.bprincipal')
@section('titulo', 'Ver Rol')
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

    .text-warning {
        color: #ffc107 !important;
    }

    /* Estilos para validación visual */
    .is-valid {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
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
                    <i class="fas fa-user-shield m-1"></i>&nbsp;Detalles del Rol: {{ $rol->nombre }}
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x" style="color: #0A8CB3;"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p class="mb-0" style="font-size:1.1rem; color:#004a92; font-weight:700;">
                                Información detallada del rol registrado en el sistema.
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
                                    <label class="estilo-info">ID Rol</label>
                                    <div class="detail-value bg-light p-2 rounded">{{ $rol->id_rol }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="estilo-info">Estado</label>
                                    <div class="detail-value">
                                        <span class="badge badge-success badge-detail">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Activo
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="estilo-info">Nombre del Rol</label>
                                    <div class="detail-value bg-light p-2 rounded">{{ $rol->nombre }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="estilo-info">Personas Asignadas</label>
                                    <div class="detail-value bg-light p-2 rounded">
                                        <i class="fas fa-users text-info mr-1"></i>{{ $rol->personas()->count() }} personas
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="estilo-info">Descripción</label>
                            <div class="detail-value bg-light p-3 rounded">
                                @if($rol->descripcion)
                                    <i class="fas fa-quote-left text-muted mr-1"></i>{{ $rol->descripcion }}
                                @else
                                    <i class="fas fa-info-circle text-muted mr-1"></i>Sin descripción
                                @endif
                            </div>
                        </div>

                        @if ($rol->personas->count() > 0)
                            <div class="form-group">
                                <label class="estilo-info">Personas con este Rol</label>
                                <div class="table-responsive mt-2">
                                    <table class="table table-hover table-custom text-center" style="border: 1px solid #0A8CB3; border-radius: 10px; overflow: hidden;">
                                        <thead class="table-hover estilo-info">
                                            <tr>
                                                <th scope="col"><i class="fas fa-id-card mr-1"></i>DNI</th>
                                                <th scope="col"><i class="fas fa-user mr-1"></i>Nombres</th>
                                                <th scope="col"><i class="fas fa-user-friends mr-1"></i>Apellidos</th>
                                                <th scope="col"><i class="fas fa-envelope mr-1"></i>Email</th>
                                                <th scope="col"><i class="fas fa-info-circle mr-1"></i>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rol->personas as $persona)
                                                <tr>
                                                    <td>{{ $persona->dni }}</td>
                                                    <td>{{ $persona->nombres }}</td>
                                                    <td>{{ $persona->apellidos }}</td>
                                                    <td>{{ $persona->email ?: 'No especificado' }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $persona->estado == 'Activo' ? 'success' : 'danger' }} badge-detail">
                                                            <i class="fas fa-{{ $persona->estado == 'Activo' ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                                            {{ $persona->estado }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="estilo-info">Personas con este Rol</label>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    No hay personas asignadas a este rol actualmente.
                                </div>
                            </div>
                        @endif

                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-center">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <a href="{{ route('roles.edit', $rol->id_rol) }}" class="btn btn-warning" style="width: 160px; height: 38px; padding: 6px 12px; display: inline-block; text-align: center; text-decoration: none; line-height: 26px; vertical-align: middle;">
                                        <i class="fas fa-edit"></i> Editar Rol
                                    </a>
                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary" style="width: 180px; height: 38px; padding: 6px 12px; display: inline-block; text-align: center; text-decoration: none; line-height: 26px; vertical-align: middle;">
                                        <i class="fas fa-arrow-left"></i> Volver al Listado
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
        document.querySelectorAll('a[href*="roles.edit"]').forEach(function(link) {
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
        document.querySelectorAll('a[href*="roles.index"]').forEach(function(link) {
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
