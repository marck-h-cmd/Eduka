@extends('cplantilla.bprincipal')
@section('titulo', 'Editar Proceso')
@section('contenidoplantilla')

<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary, .btn-secondary { font-family: "Quicksand", sans-serif; font-weight: 700; border: none; transition: 0.2s; }
    .btn-primary:hover, .btn-secondary:hover { transform: scale(1.02); }
    .btn-primary { background:#007bff !important; }
    .btn-secondary { background:#6c757d !important; }
    .is-valid { border-color:#28a745 !important; }
    .is-invalid { border-color:#dc3545 !important; }
</style>

<div class="container-fluid" id="contenido-principal" style="position: relative;">
    @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])

    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12">
            <div class="box_block">

                <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6"
                    type="button" data-toggle="collapse" data-target="#collapseProceso"
                    aria-expanded="true" style="background:#0A8CB3 !important; color:white;">
                    <i class="fas fa-edit m-1"></i>&nbsp;Editar Proceso: {{ $proceso->nombre }}
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>

                <div class="card-body info">
                    <div class="d-flex">
                        <i class="fas fa-info-circle fa-2x"></i>
                        <div class="p-2 flex-fill">
                            <p>En esta sección puedes modificar los datos del proceso.</p>
                            <p>Asegúrate de validar la información antes de guardar los cambios.</p>
                        </div>
                    </div>
                </div>

                <div class="collapse show" id="collapseProceso">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2" style="background:#fcfffc !important;">

                        <form action="{{ route('procesos.update', $proceso->id_proceso) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- NOMBRE --}}
                            <label class="estilo-info mt-3">Nombre *</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                </div>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $proceso->nombre) }}" style="border-color:#007bff">
                                @error('nombre')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- DESCRIPCIÓN --}}
                            <label class="estilo-info">Descripción</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                </div>
                                <textarea name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror"
                                          style="border-color:#007bff">{{ old('descripcion', $proceso->descripcion) }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- DURACIÓN --}}
                            <label class="estilo-info">Duración Estimada (días) *</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                </div>
                                <input type="number" name="duracion_estimada_dias"
                                       class="form-control @error('duracion_estimada_dias') is-invalid @enderror"
                                       value="{{ old('duracion_estimada_dias', $proceso->duracion_estimada_dias) }}"
                                       min="1" style="border-color:#007bff">
                                @error('duracion_estimada_dias')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- REQUIERE PAGO + MONTO PAGO --}}
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="estilo-info">Requiere Pago *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                                        </div>
                                        <select id="requiere_pago" name="requiere_pago"
                                                class="form-control @error('requiere_pago') is-invalid @enderror"
                                                style="border-color:#007bff">
                                            <option value="0" {{ old('requiere_pago', $proceso->requiere_pago)==0 ? 'selected':'' }}>No</option>
                                            <option value="1" {{ old('requiere_pago', $proceso->requiere_pago)==1 ? 'selected':'' }}>Sí</option>
                                        </select>
                                        @error('requiere_pago')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6" id="monto_pago_container">
                                    <label class="estilo-info">Monto Pago</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold">S/</span>
                                        </div>
                                        <input type="number" step="0.01" name="monto_pago" id="monto_pago"
                                               class="form-control @error('monto_pago') is-invalid @enderror"
                                               value="{{ old('monto_pago', $proceso->monto_pago) }}"
                                               style="border-color:#007bff">
                                        @error('monto_pago')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center" style="gap: 15px;">
                                    <button type="submit" class="btn btn-primary" style="width: 180px;">
                                        <i class="fas fa-save"></i> Actualizar
                                    </button>

                                    <button type="button" class="btn btn-secondary"
                                        onclick="window.location.href='{{ route('procesos.index') }}'"
                                        style="width: 140px;">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const requierePago = document.getElementById('requiere_pago');
    const montoContainer = document.getElementById('monto_pago_container');
    const monto = document.getElementById('monto_pago');

    function toggleMontoPago() {
        if (requierePago.value == "1") {
            montoContainer.style.display = "block";
            monto.value = "{{ old('monto_pago', $proceso->monto_pago) }}";
        } else {
            montoContainer.style.display = "none";
            monto.value = 0;
        }
    }

    toggleMontoPago();
    requierePago.addEventListener('change', toggleMontoPago);
});
</script>

@endsection
