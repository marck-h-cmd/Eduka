@extends('cplantilla.bprincipal')

@section('titulo', 'Nuevo Grado')

@section('contenidoplantilla')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-plus-circle"></i> Registrar Nuevo Grado
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
            <form action="{{ route('grados.store') }}" method="POST" id="form-grado">
                @csrf

                {{-- Nivel educativo --}}
                <div class="form-group mb-3">
                    <label for="nivel_id" class="fw-bold">Nivel Educativo</label>
                    <select name="nivel_id" id="nivel_id" class="form-control" required>
                        <option value="">-- Seleccione un nivel --</option>
                        @foreach ($niveles as $nivel)
                            <option value="{{ $nivel->nivel_id }}" {{ old('nivel_id') == $nivel->nivel_id ? 'selected' : '' }}>
                                {{ $nivel->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Grado --}}
                <div class="form-group mb-3">
                    <label for="nombre" class="fw-bold">Grado</label>
                    <select name="nombre" id="nombre" class="form-control" required>
                        <option value="">-- Seleccione un grado --</option>
                        {{-- Las opciones se cargarán dinámicamente con JS --}}
                    </select>
                </div>

                {{-- Descripción --}}
                <div class="form-group mb-3">
                    <label for="descripcion" class="fw-bold">Descripción generada</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" readonly>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('grados.index') }}" class="btn btn-secondary">
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

{{-- Script para actualizar grados y descripción --}}
<script>
    const niveles = @json($niveles);

    document.addEventListener('DOMContentLoaded', function () {
        const nivelSelect = document.getElementById('nivel_id');
        const gradoSelect = document.getElementById('nombre');
        const descripcionInput = document.getElementById('descripcion');

        const gradosPrimaria = [1, 2, 3, 4, 5, 6];
        const gradosSecundaria = [1, 2, 3, 4, 5];

        function actualizarGrados() {
            gradoSelect.innerHTML = '<option value="">-- Seleccione un grado --</option>';
            descripcionInput.value = '';

            const nivelId = nivelSelect.value;
            const nivelNombre = niveles.find(n => n.nivel_id == nivelId)?.nombre;

            if (!nivelId || !nivelNombre) return;

            const grados = nivelNombre.toLowerCase().includes('primaria') ? gradosPrimaria : gradosSecundaria;

            grados.forEach(num => {
                const opt = document.createElement('option');
                opt.value = num;
                opt.text = `${num}°`;
                gradoSelect.appendChild(opt);
            });
        }

        function actualizarDescripcion() {
            const grado = gradoSelect.value;
            const nivelNombre = niveles.find(n => n.nivel_id == nivelSelect.value)?.nombre || '';
            descripcionInput.value = grado ? `${grado}° de ${nivelNombre.toLowerCase()}` : '';
        }

        nivelSelect.addEventListener('change', () => {
            actualizarGrados();
            actualizarDescripcion();
        });

        gradoSelect.addEventListener('change', actualizarDescripcion);

        // Inicializar si ya hay valores seleccionados (por ejemplo, al regresar con errores)
        if (nivelSelect.value) {
            actualizarGrados();
            if (gradoSelect.value) {
                actualizarDescripcion();
            }
        }
    });
</script>

@endsection
