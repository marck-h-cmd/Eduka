@extends('cplantilla.bprincipal')
@section('titulo', 'Gestión de Procesos')
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

    /* pequeñas mejoras de responsividad */
    @media (max-width: 767px) {
        .estilo-info { font-size: 0.85rem !important; }
        .btn-primary { font-size: 0.85rem !important; }
    }
</style>

<div class="container-fluid" id="contenido-principal" style="position: relative;">
    @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])

    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12">
            <div class="box_block">

                <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" 
                    data-toggle="collapse" data-target="#collapseProcesos" aria-expanded="true"
                    style="background: #0A8CB3 !important; color:white;">
                    <i class="fas fa-cogs m-1"></i>&nbsp;Gestión de Procesos
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>

                <div class="card-body info">
                    <div class="d-flex">
                        <div><i class="fas fa-info-circle fa-2x"></i></div>
                        <div class="p-2 flex-fill">
                            <p>Administre los procesos disponibles en la institución.
                                Estos procesos se componen de pasos y son usados en la gestión de expedientes estudiantiles.</p>
                        </div>
                    </div>
                </div>

                <div class="collapse show" id="collapseProcesos">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2">


                        <div class="row align-items-center">
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('procesos.create') }}" 
                                   class="btn btn-primary w-100" id="nuevoRegistroBtn">
                                    <i class="fa fa-plus mx-2"></i> Nuevo Proceso
                                </a>
                            </div>

                            <div class="col-md-6 d-flex justify-content-md-end estilo-info">
                                <form id="formBuscar" method="GET" class="w-100">
                                    <div class="input-group">
                                        <input name="buscarpor" class="form-control mt-3"
                                               type="search" placeholder="Buscar proceso..." value="{{ $buscarpor }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            @include('tramites.configuracion.procesos.procesos')
                        </div>

                        {{ $procesos->links() }}

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Función global para confirmar eliminación (usada por index)
    function confirmDelete(id, nombre, formPrefix = '') {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea cambiar el estado de "${nombre}" a Inactivo?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cambiar estado',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // formPrefix opción si tienes varios prefijos; por defecto id directo
                const formId = formPrefix ? `${formPrefix}-${id}` : `delete-form-${id}`;
                const form = document.getElementById(formId);
                if (form) {
                    form.submit();
                } else {
                    // fallback: intentar hacer POST por fetch si no encuentra el form
                    console.warn('Formulario no encontrado:', formId);
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Loader para links que navegan: botones con clase .btn-navigate (nuevoRegistroBtn, .btn-ver, .btn-edit)
        document.querySelectorAll('[data-loader="true"]').forEach(function(el) {
            el.addEventListener('click', function(e) {
                // si es link normal dejamos que navegue; solo mostramos loader y no interrumpimos
                if (loader) loader.style.display = 'flex';
            });
        });

        // Opcional: animación para botones con clases concretas (compatibilidad con tus vistas)
        const botonesConLoader = ['nuevoRegistroBtn', 'btn-ver-rol', 'btn-editar-rol'];
        botonesConLoader.forEach(cls => {
            document.querySelectorAll(`.${cls}`).forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    // si es un anchor, mostramos loader y dejamos que la navegación ocurra
                    if (loader) loader.style.display = 'flex';
                });
            });
        });

        // Mostrar mensajes de sesión con SweetAlert2 (success / error)
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#007bff',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#007bff'
            });
        @endif

        // Cuando se regrese en historial, quitar loader
        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>

@endsection