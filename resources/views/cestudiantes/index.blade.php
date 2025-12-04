@extends('cplantilla.bprincipal')
@section('titulo', 'Gestión de Estudiantes')
@section('contenidoplantilla')
<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary { margin-top: 1rem; background: #007bff !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary:hover { background-color: #0056b3 !important; transform: scale(1.01); }
    .btn-action-group button { margin-right: 5px; }
    .table-custom tbody tr:nth-of-type(odd) { background-color: #f5f5f5; }
    .table-custom tbody tr:nth-of-type(even) { background-color: #e0e0e0; }
    .table-hover tbody tr:hover { background-color: #eeffe7 !important; }
    .pagination { display: flex; justify-content: left; padding: 1rem 0; list-style: none; gap: 0.3rem; }
    .pagination li a, .pagination li span { color: var(--color-principal); border: 1px solid var(--color-principal); padding: 6px 12px; border-radius: 4px; text-decoration: none; transition: all 0.2s ease; font-size: 0.9rem; }
    .pagination li a:hover, .pagination li span:hover { background-color: #f1f1f1; color: #333; }
    .pagination .page-item.active .page-link { background-color: #0A8CB3 !important; color: white !important; border-color: #000000 !important; }
    .pagination .disabled .page-link { color: #ccc; border-color: #ccc; }
    .btn-action-group .btn-link { margin-right: 8px; padding: 0 6px; border: none; background: none; box-shadow: none; }
    .btn-action-group .btn-link:focus { outline: none; box-shadow: none; }
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
                    <i class="fas fa-user-graduate m-1"></i>&nbsp;Gestión de Estudiantes
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex ">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>
                                En esta sección, podrás consultar y gestionar la información de los estudiantes registrados en el sistema.
                            </p>
                            <p>
                                Estimado Usuario: Puedes ver detalles completos, editar información académica y cambiar el estado de los estudiantes según sea necesario.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2" style="background-color: #fcfffc !important">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-md-0 d-flex justify-content-start">
                                <!-- Nota: El botón de crear estudiante se mantiene para navegación, 
                                     pero la creación es manejada por otro módulo -->
                            </div>
                            <div class="col-md-12 d-flex justify-content-md-end justify-content-start estilo-info">
                                <form id="formBuscar" method="GET" action="{{ route('estudiantes.index') }}" class="w-100" style="max-width: 100%;">
                                    <div class="input-group">
                                        <input name="buscarpor" id="inputBuscar" class="form-control mt-3" type="search" 
                                               placeholder="Buscar estudiante (nombre, DNI, email universitario)" 
                                               aria-label="Search" autocomplete="off" 
                                               value="{{ request('buscarpor') }}"
                                               style="border-color: #007bff;">
                                        <button class="btn btn-primary nuevo-boton" type="submit" 
                                                style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important; background: #007bff !important; border: none;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="alerts-container"></div>
                        <div class="row form-bordered align-items-center"></div>
                        <div class="table-responsive mt-2">
                            <table class="table-hover table table-custom text-center" style="border: 1px solid #0A8CB3; border-radius: 10px; overflow: hidden;">
                                <thead class="table-hover estilo-info">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Apellidos</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Email Universitario</th>
                                        <th scope="col">Escuela</th>
                                        <th scope="col">Año Ingreso</th>
                                        <th scope="col">Roles</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($estudiantes as $estudiante)
                                        <tr>
                                            <td>{{ $estudiante->id_estudiante }}</td>
                                            <td>{{ $estudiante->persona->nombres }}</td>
                                            <td>{{ $estudiante->persona->apellidos }}</td>
                                            <td>{{ $estudiante->persona->dni }}</td>
                                            <td>{{ $estudiante->emailUniversidad }}</td>
                                            <td>{{ $estudiante->escuela->nombre ?? 'No asignada' }}</td>
                                            <td>{{ $estudiante->anio_ingreso }}</td>
                                            <td>
                                                @if($estudiante->persona->roles->count() > 0)
                                                    @foreach($estudiante->persona->roles as $rol)
                                                        <span class="badge badge-info">{{ $rol->nombre }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Sin roles</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $estudiante->estado == 'Activo' ? 'success' : ($estudiante->estado == 'Egresado' ? 'primary' : 'danger') }}">
                                                    {{ $estudiante->estado }}
                                                </span>
                                            </td>
                                            <td class="btn-action-group">
                                                <a href="{{ route('estudiantes.show', $estudiante) }}" 
                                                   class="btn btn-link btn-sm p-0 btn-ver-estudiante" title="Ver">
                                                    <i class="fas fa-eye" style="color: #17a2b8; font-size: 1.2rem;"></i>
                                                </a>
                                                <a href="{{ route('estudiantes.edit', $estudiante) }}" 
                                                   class="btn btn-link btn-sm p-0 btn-editar-estudiante" title="Editar">
                                                    <i class="fas fa-pen" style="color: #007bff; font-size: 1.2rem;"></i>
                                                </a>
                                                @if($estudiante->estado == 'Activo')
                                                    <button type="button" class="btn btn-link btn-sm p-0 btn-eliminar-estudiante" 
                                                            title="Dar de Baja"
                                                            onclick="confirmarEliminar({{ $estudiante->id_estudiante }}, '{{ $estudiante->persona->nombres }} {{ $estudiante->persona->apellidos }}')">
                                                        <i class="fas fa-times" style="color: #dc3545; font-size: 1.3rem;"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $estudiante->id_estudiante }}" 
                                                          action="{{ route('estudiantes.destroy', $estudiante) }}" 
                                                          method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No hay estudiantes registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div id="tabla-estudiantes">
                            {{ $estudiantes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Función para confirmar eliminación con SweetAlert2 (global)
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
                // Enviar el formulario de eliminación
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

        // Loader para ver estudiante
        document.querySelectorAll('.btn-ver-estudiante').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        });

        // Loader para editar estudiante
        document.querySelectorAll('.btn-editar-estudiante').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        });

        // Mostrar mensajes de éxito o error con SweetAlert2
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#007bff',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session("error") }}',
                confirmButtonColor: '#007bff'
            });
        @endif

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection