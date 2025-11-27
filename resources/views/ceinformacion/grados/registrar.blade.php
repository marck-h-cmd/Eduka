@extends('cplantilla.bprincipal')

@section('titulo', 'Registro de Grados')

@section('contenidoplantilla')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm mr-3 ml-3">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background-color: #6f42c1; color: white;">
                <h4 class="mb-0"><i class="fas fa-layer-group"></i> Listado de Grados</h4>
                <a href="{{ route('grados.create') }}" class="btn btn-sm" style="background-color: #a066dd; color: white;">
                    <i class="fas fa-plus-circle"></i> Nuevo Grado
                </a>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                    <script>
                        setTimeout(() => document.querySelector('.alert-success')?.remove(), 3000);
                    </script>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                <!-- Filtros de búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form id="formBuscarGrado" method="GET" class="d-flex">
                            <input type="search" name="buscarpor" id="buscarpor" value="{{ $buscarpor }}"
                                class="form-control"
                                placeholder="Buscar por grado o descripción"
                                autocomplete="off">
                            <button type="submit" class="btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>


                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-color: #b88ef0 !important">
                                <i class="bi bi-mortarboard-fill text-primary"></i>
                            </span>
                            <select name="nivel_id" id="nivel_id" class="form-select border-2 border-start-0 rounded-end-0"
                                style="border-color: #b88ef0;">
                                <option value="">-- Todos los niveles --</option>
                                @foreach ($niveles as $nivel)
                                    <option value="{{ $nivel->nivel_id }}"
                                        {{ $nivel_id == $nivel->nivel_id ? 'selected' : '' }}>
                                        {{ $nivel->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                <!-- Loader -->
                <div id="loaderTabla" class="text-center my-3" style="display: none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>

                <div id="tabla-grados">
                    @include('ceinformacion.grados.tabla', ['grados' => $grados])
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buscarInput = document.getElementById('buscarpor');
            const nivelSelect = document.getElementById('nivel_id');
            const form = document.getElementById('formBuscarGrado');

            function fetchGrados() {
                const valorBuscar = buscarInput.value.trim();
                const nivelId = nivelSelect.value;
                const loader = document.getElementById('loaderTabla');
                const contenedor = document.getElementById('tabla-grados');

                loader.style.display = 'block';
                contenedor.style.opacity = '0.5';

                fetch(`{{ route('grados.index') }}?buscarpor=${encodeURIComponent(valorBuscar)}&nivel_id=${nivelId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        contenedor.innerHTML = html;
                        loader.style.display = 'none';
                        contenedor.style.opacity = '1';
                    });
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Buscando grados...',
                    showConfirmButton: false,
                    timer: 1200
                });

                fetchGrados();
            });

            nivelSelect.addEventListener('change', () => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Filtrando por nivel...',
                    showConfirmButton: false,
                    timer: 1200
                });
                fetchGrados();
            });

            buscarInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    fetchGrados();
                }
            });
            form.addEventListener('submit', function(e) {
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
                    title: 'Buscando grados...',
                    showConfirmButton: false,
                    timer: 1200
                });

                fetchGrados();
            });
            document.addEventListener('click', function(e) {
                if (e.target.closest('.pagination a')) {
                    e.preventDefault();
                    const url = e.target.closest('a').getAttribute('href');
                    const valorBuscar = buscarInput.value.trim();
                    const nivelId = nivelSelect.value;

                    fetch(`${url}&buscarpor=${encodeURIComponent(valorBuscar)}&nivel_id=${nivelId}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('tabla-grados').innerHTML = html;
                        });
                }
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
    <style>
        <style>
    /* Campo de búsqueda */
#formBuscarGrado input[type="search"] {
    font-size: 0.95rem;
    padding: 0.45rem 0.75rem;
    border-radius: 6px 0 0 6px;
    border: 1px solid #b88ef0;
    border-right: none;
    transition: box-shadow 0.2s ease;
}

#formBuscarGrado input[type="search"]:focus {
    box-shadow: 0 0 6px rgba(160, 102, 221, 0.5);
    border-color: #a066dd;
    outline: none;
}

#formBuscarGrado button {
    border-radius: 0 6px 6px 0;
    border: 1px solid #b88ef0;
    border-left: none;
    border-right: none;
    background-color: #a066dd;
    color: white;
    font-weight: bold;
}

</style>
@endsection

