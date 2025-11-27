@extends('cplantilla.bprincipal')

@section('titulo','Registro de Secciones')

@section('contenidoplantilla')

<div class="container-fluid mt-4">
    <div class="card shadow-sm mr-3 ml-3">
        {{-- Encabezado celeste --}}
        <div class="card-header d-flex justify-content-between align-items-center"
             style="background-color: #d1f0ff; color: #0b5e80;">
            <h4 class="mb-0"><i class="fas fa-layer-group me-2"></i> Listado de Secciones</h4>
            <a href="{{ route('secciones.create') }}" class="btn" style="background-color: #1f9fc4; color: white;">
                <i class="fas fa-plus-circle me-1"></i> Nueva Sección
            </a>
        </div>

        <div class="card-body">
            {{-- Alertas --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show"
                     style="background-color: #d2f4ff; color: #075f75;" role="alert">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(() => document.querySelector('.alert-success')?.remove(), 3000);
                </script>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show"
                     style="background-color: #ffd9dc; color: #6b0f1a;" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            {{-- Filtro --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <form id="formBuscarSeccion" method="GET" class="d-flex">
                        <input type="search" name="buscarpor" id="buscarpor" value="{{ $buscarpor }}"
                            class="form-control"
                            placeholder="Buscar por nombre, capacidad o descripción"
                            autocomplete="off">
                        <button type="submit" class="btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Loader --}}
            <div id="loaderTabla" class="text-center my-3" style="display: none;">
                <div class="spinner-border text-info" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>

            {{-- Tabla --}}
            <div id="tabla-secciones">
                @include('ceinformacion.secciones.tabla', ['secciones' => $secciones])
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscarInput = document.getElementById('buscarpor');
        const form = document.getElementById('formBuscarSeccion');

        function fetchSecciones() {
            const valorBuscar = buscarInput.value.trim();
            const loader = document.getElementById('loaderTabla');
            const contenedor = document.getElementById('tabla-secciones');

            loader.style.display = 'block';
            contenedor.style.opacity = '0.5';

            fetch(`{{ route('secciones.index') }}?buscarpor=${encodeURIComponent(valorBuscar)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                contenedor.innerHTML = html;
                loader.style.display = 'none';
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
                title: 'Buscando secciones...',
                showConfirmButton: false,
                timer: 1200
            });

            fetchSecciones();
        });

        buscarInput.addEventListener('input', function () {
            if (this.value.trim() === '') {
                fetchSecciones();
            }
        });

        document.addEventListener('click', function (e) {
            // Paginación AJAX
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = e.target.closest('a').getAttribute('href');
                const valorBuscar = buscarInput.value.trim();

                fetch(`${url}&buscarpor=${encodeURIComponent(valorBuscar)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('tabla-secciones').innerHTML = html;
                });
            }

            // Confirmación eliminación
            if (e.target.closest('.form-eliminar')) {
                e.preventDefault();
                const form = e.target.closest('.form-eliminar');

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
    #formBuscarSeccion input[type="search"] {
        font-size: 0.95rem;
        padding: 0.45rem 0.75rem;
        border-radius: 5px;
        border: 1px solid #56c7e3;
        transition: box-shadow 0.2s ease;
    }

    #formBuscarSeccion input[type="search"]:focus {
        box-shadow: 0 0 6px rgba(86, 199, 227, 0.5);
        border-color: #56c7e3;
        outline: none;
    }

    .pagination {
        display: flex;
        justify-content: left;
        padding: 1rem 0;
        list-style: none;
        gap: 0.3rem;
    }

    .pagination li a, .pagination li span {
        color: #0b5e80;
        border: 1px solid #0b5e80;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .pagination li a:hover, .pagination li span:hover {
        background-color: #e6f9ff;
        color: #0b5e80;
    }

    .pagination .page-item.active .page-link {
        background-color: #0b5e80 !important;
        color: white !important;
        border-color: #0b5e80 !important;
    }

    .pagination .disabled .page-link {
        color: #ccc;
        border-color: #ccc;
    }

/* Estilos búsqueda */
#formBuscarSeccion input[type="search"] {
    font-size: 0.95rem;
    padding: 0.45rem 0.75rem;
    border-radius: 6px 0 0 6px;
    border: 1px solid #38bdf8;
    border-right: none;
    transition: box-shadow 0.2s ease;
}

#formBuscarSeccion input[type="search"]:focus {
    box-shadow: 0 0 6px rgba(56, 189, 248, 0.4);
    border-color: #247fa6;
    outline: none;
}

#formBuscarSeccion button {
    border-radius: 0 6px 6px 0;
    border: 1px solid #247fa6;
    border-left: none;
    background-color: #227faa;
    color: white;
    font-weight: bold;
}
</style>

@endsection
