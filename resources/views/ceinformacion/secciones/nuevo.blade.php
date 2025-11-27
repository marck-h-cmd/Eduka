@extends('cplantilla.bprincipal')

@section('titulo', 'Nueva Sección')

@section('contenidoplantilla')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-plus-circle"></i> Registrar Nueva Sección
            </h4>
        </div>

        <div class="card-body">
            {{-- Alertas de éxito o error --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            {{-- Formulario --}}
            <form id="form-seccion" action="{{ route('secciones.store') }}" method="POST">
                @csrf

                {{-- Nombre (selección de letra A–L) --}}
                <div class="form-group mb-3">
                    <label for="nombre" class="fw-bold">Nombre de la Sección</label>
                    <select name="nombre" id="nombre" class="form-control" required>
                        <option value="">-- Seleccione una letra --</option>
                        @foreach (range('A', 'L') as $letra)
                            <option value="{{ $letra }}">{{ $letra }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Capacidad Máxima --}}
                <div class="form-group mb-3">
                    <label for="capacidad_maxima" class="fw-bold">Capacidad Máxima</label>
                    <input type="number" name="capacidad_maxima" id="capacidad_maxima" class="form-control" required max="300" min="1">
                </div>

                {{-- Descripción (rellenada automáticamente) --}}
                <div class="form-group mb-3">
                    <label for="descripcion" class="fw-bold">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" readonly required>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('secciones.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script --}}
<script>

    const nombreInput = document.getElementById('nombre');
    const descripcionInput = document.getElementById('descripcion');
    const form = document.getElementById('form-seccion');

    // Lista de secciones ya existentes (simulación desde backend con Blade)
    const seccionesExistentes = @json($seccionesExistentes ?? []); // Asegúrate de pasar esto desde el controlador

    nombreInput.addEventListener('change', () => {
        const letra = nombreInput.value;
        if (letra) {
            descripcionInput.value = 'Sección ' + '"'+ letra+ '"';
        } else {
            descripcionInput.value = '';
        }
    });

    form.addEventListener('submit', function (e) {
        const nombreSeleccionado = nombreInput.value.trim();
        const capacidad = parseInt(document.getElementById('capacidad_maxima').value);

        // Validar si ya existe
        if (seccionesExistentes.includes(nombreSeleccionado)) {
            e.preventDefault();
            alert(`La sección "${nombreSeleccionado}" ya está registrada.`);
            return;
        }

        // Validar capacidad máxima
        if (capacidad > 300) {
            e.preventDefault();
            alert('La capacidad máxima no puede superar los 300 estudiantes.');
            return;
        }
    });
</script>
@endsection
