@extends('cplantilla.bprincipal')

@section('titulo', 'Nuevo Año Lectivo')

@section('contenidoplantilla')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-calendar-plus me-2"></i> Registrar Año Lectivo
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
            <form action="{{ route('aniolectivo.store') }}" method="POST">
                @csrf

                {{-- Nombre --}}
                <div class="form-group mb-3">
                    <label for="nombre" class="fw-bold">Nombre del Año Lectivo</label>
                    <input type="text" name="nombre" id="nombre" class="form-control"
                        value="{{ old('nombre') }}" required maxlength="100">
                </div>

                {{-- Fecha de inicio --}}
                <div class="form-group mb-3">
                    <label for="fecha_inicio" class="fw-bold">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                        value="{{ old('fecha_inicio') }}" required>
                </div>

                {{-- Fecha de fin --}}
                <div class="form-group mb-3">
                    <label for="fecha_fin" class="fw-bold">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                        value="{{ old('fecha_fin') }}" required>
                </div>

                {{-- Estado --}}
                <div class="form-group mb-3">
                    <label for="estado" class="fw-bold">Estado</label>
                    <select name="estado" id="estado" class="form-control" required>
                         <option value="">-- Seleccione un estado --</option>
                        <option value="Activo" {{ old('estado', $anolectivo->estado ?? '') == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Planificación" {{ old('estado') == 'Planificación' ? 'selected' : '' }}>Planificación</option>
                        <option value="Finalizado" {{ old('estado', $anolectivo->estado ?? '') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                </div>

                {{-- Descripción --}}
                <div class="form-group mb-4">
                    <label for="descripcion" class="fw-bold">Descripción (opcional)</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control"
                        maxlength="500">{{ old('descripcion') }}</textarea>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between">
    <a href="{{ route('aniolectivo.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Registrar Año Lectivo
    </button>
</div>
            </form>
        </div>
    </div>
</div>
@endsection
