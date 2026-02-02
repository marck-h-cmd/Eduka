@extends('cplantilla.bprincipal')
@section('titulo', 'Ver Proceso')
@section('contenidoplantilla')

<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .detail-label { font-weight: 700; color: #004a92; font-size: 0.9rem; }
    .detail-value { font-size: 1rem; color: #333; padding: 8px 0; }
    .badge-detail { font-size: 0.85rem; padding: 6px 12px; }
    .btn-primary, .btn-secondary, .btn-warning { font-family: "Quicksand", sans-serif; font-weight: 700; border: none; transition: 0.2s; }
    .btn-primary:hover, .btn-secondary:hover, .btn-warning:hover { transform: scale(1.02); }
    .table-custom tbody tr:nth-of-type(odd){ background:#f5f5f5; }
    .table-custom tbody tr:nth-of-type(even){ background:#e0e0e0; }
    .table-hover tbody tr:hover{ background:#eeffe7 !important; }
    #loaderPrincipal[style*="display: flex"]{ display:flex!important; justify-content:center; align-items:center; position:absolute!important; top:0; left:0; right:0; bottom:0; width:100%; height:100%; z-index:2000; }
</style>

<div class="container-fluid" id="contenido-principal" style="position: relative;">
    @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])

    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12">
            <div class="box_block">

                <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                    data-toggle="collapse" data-target="#collapseProceso" aria-expanded="true"
                    style="background: #0A8CB3 !important; color:white;">
                    <i class="fas fa-cogs m-1"></i>&nbsp;Detalles del Proceso: {{ $proceso->nombre }}
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>

                <div class="card-body info">
                    <div class="d-flex">
                        <i class="fas fa-info-circle fa-2x"></i>
                        <div class="p-2 flex-fill">
                            <p>Aquí puedes visualizar todos los detalles del proceso y sus pasos asociados.</p>
                            <p>Utiliza los botones para volver o editar el proceso.</p>
                        </div>
                    </div>
                </div>

                <div class="collapse show" id="collapseProceso">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2">

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="estilo-info">ID Proceso</label>
                                <div class="detail-value bg-light p-2 rounded">
                                    {{ $proceso->id_proceso }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="estilo-info">Estado</label>
                                <div class="detail-value">
                                    <span class="badge badge-{{ $proceso->estado == 'Activo' ? 'success' : 'danger' }} badge-detail">
                                        <i class="fas fa-{{ $proceso->estado == 'Activo' ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                        {{ $proceso->estado }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="estilo-info">Nombre</label>
                                <div class="detail-value bg-light p-2 rounded">
                                    {{ $proceso->nombre }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="estilo-info">Duración Estimada</label>
                                <div class="detail-value bg-light p-2 rounded">
                                    {{ $proceso->duracion_estimada_dias }} días
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="estilo-info">Requiere Pago</label>
                                <div class="detail-value">
                                    @if($proceso->requiere_pago)
                                        <span class="badge badge-info badge-detail">
                                            <i class="fas fa-money-bill mr-1"></i>S/ {{ number_format($proceso->monto_pago, 2) }}
                                        </span>
                                    @else
                                        <span class="badge badge-success badge-detail">
                                            <i class="fas fa-check-circle mr-1"></i>No requiere
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="estilo-info">Fecha de Creación</label>
                                <div class="detail-value bg-light p-2 rounded">
                                    <i class="fas fa-calendar-alt mr-1 text-info"></i>
                                    {{ \Carbon\Carbon::parse($proceso->fecha_creacion)->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="estilo-info">Descripción</label>
                            <div class="detail-value bg-light p-3 rounded">
                                {{ $proceso->descripcion ?: 'Sin descripción' }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="estilo-info">Pasos del Proceso</label>

                            <div class="table-responsive mt-2">
                                <table class="table table-hover table-custom text-center"
                                    style="border: 1px solid #0A8CB3; border-radius: 10px;">
                                    <thead class="table-hover estilo-info">
                                        <tr>
                                            <th>Orden</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Duración (días)</th>
                                            <th>Requiere Documento</th>
                                            <th>Requiere Validación</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($proceso->pasos as $paso)
                                            <tr>
                                                <td>{{ $paso->pivot->orden }}</td>
                                                <td>{{ $paso->nombre }}</td>
                                                <td>{{ $paso->descripcion }}</td>
                                                <td>{{ $paso->duracion_dias }}</td>
                                                <td>
                                                    @if($paso->requiere_documento)
                                                        <span class="badge badge-info badge-detail">
                                                            <i class="fas fa-file-alt mr-1"></i> Sí
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary badge-detail">
                                                            <i class="fas fa-times-circle mr-1"></i> No
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($paso->requiere_validacion)
                                                        <span class="badge badge-warning badge-detail">
                                                            <i class="fas fa-check-circle mr-1"></i> Sí
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary badge-detail">
                                                            <i class="fas fa-times-circle mr-1"></i> No
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">Este proceso no tiene pasos registrados.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-center" style="gap: 15px;">
                                <a href="{{ route('procesos.edit', $proceso->id_proceso) }}" class="btn btn-warning" style="width: 160px;">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <a href="{{ route('procesos.index') }}" class="btn btn-secondary" style="width: 180px;">
                                    <i class="fas fa-arrow-left"></i> Volver al Listado
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loader = document.getElementById('loaderPrincipal');
    const contenido = document.getElementById('contenido-principal');

    if (loader) loader.style.display = 'none';
    if (contenido) contenido.style.opacity = '1';

    document.querySelectorAll('a.btn-warning, a.btn-secondary').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (loader) loader.style.display = 'flex';
            setTimeout(() => window.location.href = this.href, 500);
        });
    });
});
</script>

@endsection
