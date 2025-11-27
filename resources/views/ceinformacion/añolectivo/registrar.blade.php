@extends('cplantilla.bprincipal')

@section('titulo', 'Años Lectivos')

@section('contenidoplantilla')
<div class="container-fluid mt-4">
    <div class="card shadow-sm mr-3 ml-3">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #0f172a;">
            <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Años Lectivos</h4>
            <a href="{{ route('aniolectivo.create') }}" class="btn"
               style="background-color: #1e3a8a; color: #fff; border-radius: 6px; font-weight: 500;">
                <i class="fas fa-plus-circle me-1"></i> Registrar Año Lectivo
            </a>
        </div>

        <div class="card-body">
            {{-- Alertas --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Acción no permitida',
                            text: @json(session('error')),
                            confirmButtonColor: '#d33'
                        });
                    });
                </script>
            @endif

            {{-- Filtro de búsqueda --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <form id="formBuscarAnioLectivo" method="GET" class="d-flex">
                        <input type="search" name="buscarpor" id="buscarpor" value="{{ $buscarpor }}"
                            class="form-control"
                            placeholder="Buscar por nombre o estado"
                            autocomplete="off">
                        <button type="submit" class="btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <div id="loaderTabla" class="text-primary mt-2 d-none">
                        <i class="fas fa-spinner fa-spin me-2"></i> Buscando años lectivos...
                    </div>
                </div>
            </div>

            {{-- Tabla --}}
            <div id="tabla-anoslectivos">
                @include('ceinformacion.añolectivo.tabla')
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscarInput = document.getElementById('buscarpor');
        const form = document.getElementById('formBuscarAnioLectivo');

        function fetchAnioLectivo(url = null) {
            const valorBuscar = buscarInput.value.trim();
            const loader = document.getElementById('loaderTabla');
            const contenedor = document.getElementById('tabla-anoslectivos');
            const fetchUrl = url || `{{ route('aniolectivo.index') }}?buscarpor=${encodeURIComponent(valorBuscar)}`;

            loader.classList.remove('d-none');
            contenedor.style.opacity = '0.5';

            fetch(fetchUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                contenedor.innerHTML = html;
                loader.classList.add('d-none');
                contenedor.style.opacity = '1';
            });
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const valorBuscar = buscarInput.value.trim();

            if (valorBuscar === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo vacío',
                    text: 'Por favor, ingresa un término de búsqueda.',
                    confirmButtonColor: '#0b5e80'
                });
                return;
            }

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Buscando años lectivos...',
                showConfirmButton: false,
                timer: 1200
            });

            fetchAnioLectivo();
        });

        buscarInput.addEventListener('input', function () {
            if (this.value.trim() === '') {
                fetchAnioLectivo();
            }
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = e.target.closest('a').getAttribute('href');
                fetchAnioLectivo(url);
            }

            if (e.target.closest('.form-eliminar')) {
                e.preventDefault();
                const form = e.target.closest('form');

                Swal.fire({
                    title: '¿Está seguro?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>

{{-- Estilos --}}
<style>
    /* Campo de búsqueda */
    #formBuscarAnioLectivo input[type="search"] {
        font-size: 0.95rem;
        padding: 0.45rem 0.75rem;
        border-radius: 6px;
        border: 1px solid #1e3a8a;
        transition: box-shadow 0.2s ease;
    }

    #formBuscarAnioLectivo input[type="search"]:focus {
        box-shadow: 0 0 6px rgba(30, 58, 138, 0.5);
        border-color: #1e3a8a;
        outline: none;
    }

    #formBuscarAnioLectivo button {
        border-radius: 6px;
        font-weight: bold;
    }

    /* Encabezado tabla */
    .table thead {
        background-color: #1e293b;
        color: white;
    }

    .table-hover tbody tr:hover {
        background-color: #e0f2fe;
    }

    /* Paginación */
    .pagination {
        display: flex;
        justify-content: left;
        padding-top: 1rem;
    }

    .pagination li a,
    .pagination li span {
        border: 1px solid #0f172a;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        color: #0f172a;
        font-size: 0.875rem;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background-color: #0f172a;
        color: white;
    }

    .pagination .disabled .page-link {
        color: #ccc;
        border-color: #ccc;
    }
        /* Campo de búsqueda */
    #formBuscarAnioLectivo input[type="search"] {
        font-size: 0.95rem;
        padding: 0.45rem 0.75rem;
        border-radius: 6px 0 0 6px;
        border: 1px solid #141517;
        transition: box-shadow 0.2s ease;
        border-right: none;
    }

    #formBuscarAnioLectivo input[type="search"]:focus {
        box-shadow: 0 0 6px rgba(30, 58, 138, 0.5);
        border-color: #1e3a8a;
        outline: none;
    }

    /* Botón de búsqueda */
    #formBuscarAnioLectivo button {
        border-radius: 0 6px 6px 0;
        border: 1px solid #141517;
        border-left: none;
        border-right: none;
        font-weight: bold;
        background-color: #0a122d;
        color: white;
    }
</style>
@endsection
