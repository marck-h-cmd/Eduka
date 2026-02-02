@extends('cplantilla.bprincipal')
@section('titulo', 'Nuevo Proceso')
@section('contenidoplantilla')

<style>
    .estilo-info {
        margin-bottom: 0px;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
    }

    @media (max-width: 576px) {
        .margen-movil {
            margin-left: -29px !important;
            margin-right: -29px !important;
        }

        .margen-movil-2 {
            margin: 0 !important;
            padding: 0 !important;
        }
    }

    .custom-gold {
        border: 1.5px solid #DAA520 !important;
        background-color: white !important;
    }
</style>

<div class="container-fluid estilo-info margen-movil-2">
    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12 mb-3">

            <div class="box_block">
                <button style="background: #0A8CB3 !important; border:none"
                    class="btn btn-primary btn-block text-left rounded-0 btn_header header_6 estilo-info" type="button"
                    data-toggle="collapse" data-target="#collapseProcesoNuevo" aria-expanded="true">
                    <i class="fas fa-cogs"></i>&nbsp;Registrar Nuevo Proceso
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
            </div>

            <div class="collapse show" id="collapseProcesoNuevo">
                <div class="card card-body rounded-0 border-0 pt-0" 
                    style="padding-left:0.9rem; padding-right:0.9rem;">

                    <div class="row margen-movil" style="padding:20px;">
                        <div class="col-12">

                            <form method="POST" action="{{ route('procesos.store') }}" autocomplete="off">
                                @csrf

                                <div class="card" style="border:none;">
                                    <div style="
                                        background:#E0F7FA;
                                        color:#0A8CB3;
                                        font-weight:bold;
                                        border:2px solid #86D2E3;
                                        padding:6px 20px;
                                        border-radius:4px 4px 0 0;">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        Información del Proceso
                                    </div>

                                    <div class="card-body"
                                        style="border:2px solid #86D2E3; border-top:none; border-radius:0 0 4px 4px;">

                                        <div class="row form-group">
                                            <label class="col-md-2 col-form-label">
                                                Nombre <span style="color:#FF5A6A">(*)</span>
                                            </label>
                                            <div class="col-md-10">
                                                <input type="text"
                                                    class="form-control custom-gold @error('nombre') is-invalid @enderror"
                                                    id="nombre" name="nombre"
                                                    placeholder="Nombre del proceso"
                                                    maxlength="150"
                                                    value="{{ old('nombre') }}">
                                                @error('nombre')
                                                    <span class="invalid-feedback d-block text-start">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <label class="col-md-2 col-form-label">
                                                Descripción
                                            </label>
                                            <div class="col-md-10">
                                                <textarea
                                                    class="form-control custom-gold @error('descripcion') is-invalid @enderror"
                                                    name="descripcion" id="descripcion"
                                                    rows="3"
                                                    placeholder="Descripción breve del proceso">{{ old('descripcion') }}</textarea>
                                                @error('descripcion')
                                                    <span class="invalid-feedback d-block text-start">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <label class="col-md-2 col-form-label">
                                                Días Estimados <span style="color:#FF5A6A">(*)</span>
                                            </label>
                                            <div class="col-md-4">
                                                <input type="number"
                                                    class="form-control custom-gold @error('duracion_estimada_dias') is-invalid @enderror"
                                                    name="duracion_estimada_dias"
                                                    min="1"
                                                    placeholder="Ej: 7"
                                                    value="{{ old('duracion_estimada_dias') }}">
                                                @error('duracion_estimada_dias')
                                                    <span class="invalid-feedback d-block text-start">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="card mt-4" style="border:none;">
                                    <div
                                        style="background:#E0F7FA; color:#0A8CB3; font-weight:bold;
                                        border:2px solid #86D2E3; padding:6px 20px;
                                        border-radius:4px 4px 0 0;">
                                        <i class="fas fa-money-bill-wave mr-2"></i>
                                        Información de Pago
                                    </div>

                                    <div class="card-body"
                                        style="border:2px solid #86D2E3; border-top:none; border-radius:0 0 4px 4px;">

                                        <div class="row form-group">
                                            <label class="col-md-2 col-form-label">
                                                ¿Requiere pago? <span style="color:#FF5A6A">(*)</span>
                                            </label>
                                            <div class="col-md-10">
                                                <select name="requiere_pago"
                                                    id="requiere_pago"
                                                    class="form-control custom-gold @error('requiere_pago') is-invalid @enderror">
                                                    <option value="" disabled {{ old('requiere_pago')=='' ? 'selected':'' }}>
                                                        Seleccione
                                                    </option>
                                                    <option value="1" {{ old('requiere_pago') == '1' ? 'selected':'' }}>Sí</option>
                                                    <option value="0" {{ old('requiere_pago') == '0' ? 'selected':'' }}>No</option>
                                                </select>

                                                @error('requiere_pago')
                                                    <span class="invalid-feedback d-block text-start">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group" id="grupo_monto"
                                            style="{{ old('requiere_pago')=='1' ? '' : 'display:none' }}">
                                            <label class="col-md-2 col-form-label">Monto S/.</label>
                                            <div class="col-md-10">
                                                <input type="number"
                                                    step="0.10"
                                                    min="0"
                                                    class="form-control custom-gold @error('monto_pago') is-invalid @enderror"
                                                    name="monto_pago"
                                                    placeholder="Ej: 25.00"
                                                    value="{{ old('monto_pago') }}">
                                                @error('monto_pago')
                                                    <span class="invalid-feedback d-block text-start">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <script>
                                            document.getElementById('requiere_pago').addEventListener('change', function() {
                                                const monto = document.getElementById('grupo_monto');
                                                monto.style.display = this.value === '1' ? 'flex' : 'none';
                                            });
                                        </script>

                                    </div>
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-block"
                                        style="background:#FF3F3F !important;border:none;font-weight:bold;">
                                        Registrar Proceso
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection