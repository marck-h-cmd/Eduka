@extends('cplantilla.bprincipal')
@section('titulo', 'Gestión de Docentes')
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
                    <i class="fas fa-chalkboard-teacher m-1"></i>&nbsp;Gestión de Docentes
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex ">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>
                                En esta sección, podrás gestionar los docentes del sistema, incluyendo su información personal y académica.
                            </p>
                            <p>
                                Estimado Usuario: Asegúrate de revisar cuidadosamente los datos antes de guardarlos, ya que esta información será utilizada para la gestión académica.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2" style="background-color: #fcfffc !important">
                        <div class="row align-items-center">
                            {{-- <div class="col-md-6 mb-md-0 d-flex justify-content-start">
                                <a href="{{ route('docentes.create') }}" class="btn btn-primary w-100" id="nuevoRegistroBtn" style="background: #007bff !important; border: none;">
                                    <i class="fa fa-plus mx-2"></i> Nuevo Docente
                                </a>
                            </div> --}}
                            <div class="col-md-6 d-flex justify-content-md-end justify-content-start estilo-info">
                                <form id="formBuscar" method="GET" class="w-100" style="max-width: 100%;">
                                    <div class="input-group">
                                        <input name="buscarpor" id="inputBuscar" class="form-control mt-3" type="search" placeholder="Buscar docente" aria-label="Search" autocomplete="off" style="border-color: #007bff;">
                                        <button class="btn btn-primary nuevo-boton" type="submit" style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important; background: #007bff !important; border: none;">
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
                                        <th scope="col">Especialidad</th>
                                        <th scope="col">Email Universidad</th>
                                        <th scope="col">Fecha Contratación</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($docentes as $docente)
                                        <tr>
                                            <td>{{ $docente->id_docente }}</td>
                                            <td>{{ $docente->persona->nombres }}</td>
                                            <td>{{ $docente->persona->apellidos }}</td>
                                            <td>{{ $docente->persona->dni }}</td>
                                            <td>{{ $docente->especialidad ?: 'No especificada' }}</td>
                                            <td>{{ $docente->emailUniversidad }}</td>
                                            <td>{{ $docente->fecha_contratacion ? \Carbon\Carbon::parse($docente->fecha_contratacion)->format('d/m/Y') : 'No especificada' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $docente->estado == 'Activo' ? 'success' : 'danger' }}">
                                                    {{ $docente->estado }}
                                                </span>
                                            </td>
                                            <td class="btn-action-group">
                                                <a href="{{ route('docentes.show', $docente) }}" class="btn btn-link btn-sm p-0 btn-ver-docente" title="Ver">
                                                    <i class="fas fa-eye" style="color: #17a2b8; font-size: 1.2rem;"></i>
                                                </a>
                                                <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-link btn-sm p-0 btn-editar-docente" title="Editar">
                                                    <i class="fas fa-pen" style="color: #007bff; font-size: 1.2rem;"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-sm p-0 btn-eliminar-docente" title="Eliminar"
                                                        onclick="confirmarEliminar({{ $docente->id_docente }}, '{{ $docente->persona->nombres }} {{ $docente->persona->apellidos }}')">
                                                    <i class="fas fa-times" style="color: #dc3545; font-size: 1.3rem;"></i>
                                                </button>
                                                <form id="delete-form-{{ $docente->id_docente }}" action="{{ route('docentes.destroy', $docente) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No hay docentes registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div id="tabla-docentes">
                            {{ $docentes->links() }}
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
    function confirmarEliminar(docenteId, nombreDocente) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea cambiar el estado del docente "${nombreDocente}" a Inactivo?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cambiar estado',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar el formulario de eliminación
                const form = document.getElementById(`delete-form-${docenteId}`);
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

        // Loader para ir a create (Nuevo Docente)
        const nuevoRegistroBtn = document.getElementById('nuevoRegistroBtn');
        if (nuevoRegistroBtn) {
            nuevoRegistroBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        }

        // Loader para ver
        document.querySelectorAll('.btn-ver-docente').forEach(function(btn) {
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

        // Loader para editar
        document.querySelectorAll('.btn-editar-docente').forEach(function(btn) {
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
