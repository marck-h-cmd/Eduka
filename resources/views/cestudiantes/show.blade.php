@extends('cplantilla.bprincipal')
@section('titulo', 'Detalle del Estudiante')
@section('contenidoplantilla')
<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary { background: #007bff !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .btn-primary:hover { background-color: #0056b3 !important; transform: scale(1.01); }
    .btn-secondary { background: #6c757d !important; border: none; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .info-label { font-weight: 600; color: #004a92; margin-bottom: 5px; }
    .info-value { color: #333; margin-bottom: 15px; padding: 8px; background-color: #f8f9fa; border-left: 3px solid #007bff; }
    #loaderPrincipal[style*="display: flex"] { display: flex !important; justify-content: center; align-items: center; position: absolute !important; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: 2000; }
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
                    <i class="fas fa-user-graduate m-1"></i>&nbsp;Detalle del Estudiante
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex ">
                        <div>
                            <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>
                                Visualización completa de la información del estudiante. Aquí podrás ver todos los datos personales y académicos registrados.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-3 pb-2" style="background-color: #fcfffc !important">
                        
                        <!-- DATOS PERSONALES -->
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-user"></i> Datos Personales</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Nombres Completos</div>
                                        <div class="info-value">{{ $estudiante->persona->nombres }} {{ $estudiante->persona->apellidos }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-label">DNI</div>
                                        <div class="info-value">{{ $estudiante->persona->dni }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-label">Género</div>
                                        <div class="info-value">
                                            {{ $estudiante->persona->genero == 'M' ? 'Masculino' : ($estudiante->persona->genero == 'F' ? 'Femenino' : ($estudiante->persona->genero ?: 'No especificado')) }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Email Personal</div>
                                        <div class="info-value">{{ $estudiante->persona->email ?: 'No especificado' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-label">Teléfono</div>
                                        <div class="info-value">{{ $estudiante->persona->telefono ?: 'No especificado' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-label">Fecha de Nacimiento</div>
                                        <div class="info-value">
                                            {{ $estudiante->persona->fecha_nacimiento ? $estudiante->persona->fecha_nacimiento->format('d/m/Y') : 'No especificado' }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="info-label">Dirección</div>
                                        <div class="info-value">{{ $estudiante->persona->direccion ?: 'No especificado' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- DATOS ACADÉMICOS -->
                        <div class="card mb-3">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Datos Académicos</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Email Universitario</div>
                                        <div class="info-value">{{ $estudiante->emailUniversidad }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Escuela Profesional</div>
                                        <div class="info-value">{{ $estudiante->escuela->nombre ?? 'No asignada' }}</div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Currícula</div>
                                        <div class="info-value">{{ $estudiante->curricula->nombre ?? 'No asignada' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-label">Año de Ingreso</div>
                                        <div class="info-value">{{ $estudiante->anio_ingreso }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-label">Año de Egreso</div>
                                        <div class="info-value">{{ $estudiante->anio_egreso ?: 'No especificado' }}</div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Estado Académico</div>
                                        <div class="info-value">
                                            <span class="badge badge-{{ $estudiante->estado == 'Activo' ? 'success' : ($estudiante->estado == 'Egresado' ? 'primary' : 'danger') }}" 
                                                  style="font-size: 1rem; padding: 8px 15px;">
                                                {{ $estudiante->estado }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">ID de Estudiante</div>
                                        <div class="info-value">{{ $estudiante->id_estudiante }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ROLES ASIGNADOS -->
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-user-tag"></i> Roles Asignados</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($estudiante->persona->roles->count() > 0)
                                            @foreach($estudiante->persona->roles as $rol)
                                                <span class="badge badge-info mr-2" style="font-size: 1rem; padding: 8px 15px;">
                                                    {{ $rol->nombre }}
                                                </span>
                                            @endforeach
                                        @else
                                            <div class="info-value">Sin roles asignados</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- DATOS DE USUARIO (si existe) -->
                        @if($estudiante->persona->usuario)
                        <div class="card mb-3">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fas fa-user-circle"></i> Datos de Usuario</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Nombre de Usuario</div>
                                        <div class="info-value">{{ $estudiante->persona->usuario->username }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Email de Usuario</div>
                                        <div class="info-value">{{ $estudiante->persona->usuario->email }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Estado de Usuario</div>
                                        <div class="info-value">
                                            <span class="badge badge-{{ $estudiante->persona->usuario->estado == 'Activo' ? 'success' : 'danger' }}" 
                                                  style="font-size: 1rem; padding: 8px 15px;">
                                                {{ $estudiante->persona->usuario->estado }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- BOTONES DE ACCIÓN -->
                        <div class="row mt-3">
                            <div class="col-md-4 mb-2">
                                <a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-primary btn-block" id="btnEditar">
                                    <i class="fas fa-edit"></i> Editar Información
                                </a>
                            </div>
                            <div class="col-md-4 mb-2">
                                <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary btn-block" id="btnVolver">
                                    <i class="fas fa-arrow-left"></i> Volver al Listado
                                </a>
                            </div>
                            @if($estudiante->estado == 'Activo')
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-danger btn-block" 
                                        onclick="confirmarEliminar({{ $estudiante->id_estudiante }}, '{{ $estudiante->persona->nombres }} {{ $estudiante->persona->apellidos }}')">
                                    <i class="fas fa-times"></i> Dar de Baja
                                </button>
                                <form id="delete-form-{{ $estudiante->id_estudiante }}" 
                                      action="{{ route('estudiantes.destroy', $estudiante) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Función para confirmar eliminación
    function confirmarEliminar(estudianteId, nombreEstudiante) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea cambiar el estado del estudiante "${nombreEstudiante}" a Inactivo?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cambiar estado',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(`delete-form-${estudianteId}`);
                if (form) {
                    form.submit();
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Loader para editar
        const btnEditar = document.getElementById('btnEditar');
        if (btnEditar) {
            btnEditar.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        }

        // Loader para volver
        const btnVolver = document.getElementById('btnVolver');
        if (btnVolver) {
            btnVolver.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        }

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection