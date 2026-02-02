@extends('cplantilla.bprincipal')
@section('titulo', 'Asignación de Pasos a Procesos')
@section('contenidoplantilla')

<style>
    .form-bordered{margin:0;border:none;padding-top:15px;padding-bottom:15px;border-bottom:1px dashed #eaedf1;}
    .card-body.info{background:#f3f3f3;border-bottom:1px solid rgba(0,0,0,.125);border-top:1px solid rgba(0,0,0,.125);color:#F59D24;}
    .card-body.info p{margin-bottom:0;font-family:"Quicksand",sans-serif;font-weight:600;color:#004a92;}
    .estilo-info{margin-bottom:0;font-family:"Quicksand",sans-serif;font-weight:700;font-size:clamp(.9rem,2vw,.9rem)!important;}
    .btn-primary{margin-top:1rem;background:#007bff!important;border:none;transition:.2s;font-family:"Quicksand";font-weight:700;}
    .btn-primary:hover{background:#0056b3!important;transform:scale(1.01);}
    .table-custom tbody tr:nth-of-type(odd){background:#f5f5f5;}
    .table-custom tbody tr:nth-of-type(even){background:#e0e0e0;}
    .table-hover tbody tr:hover{background:#eeffe7!important;}
    .btn-action-group .btn-link{margin-right:8px;padding:0 6px;border:none;background:none;}
    .pagination{display:flex;gap:.3rem;padding:1rem 0;}
    #loaderPrincipal[style*="display: flex"]{display:flex!important;justify-content:center;align-items:center;position:absolute!important;top:0;left:0;right:0;bottom:0;width:100%;height:100%;z-index:2000;}
</style>

<div class="container-fluid" id="contenido-principal" style="position:relative;">
    @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])

    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12">
            <div class="box_block">

 
                <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6"
                    data-toggle="collapse" data-target="#collapseProcesoPaso" aria-expanded="true"
                    style="background:#0A8CB3!important;color:white;">
                    <i class="fas fa-project-diagram m-1"></i> Asignación de Pasos a Procesos
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>

                <div class="card-body info">
                    <div class="d-flex">
                        <div><i class="fas fa-info-circle fa-2x"></i></div>
                        <div class="p-2 flex-fill">
                            <p>Administre los pasos asignados a los procesos del sistema.
                                Organice la secuencia y defina su obligatoriedad.</p>
                        </div>
                    </div>
                </div>


                <div class="collapse show" id="collapseProcesoPaso">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2">


                        <div class="row align-items-center">

                            <div class="col-md-6 mb-2">
                                <a href="{{ route('proceso_pasos.create') }}" class="btn btn-primary w-100">
                                    <i class="fa fa-plus mx-2"></i> Nueva Asignación
                                </a>
                            </div>

                            <div class="col-md-6 d-flex justify-content-md-end estilo-info">
                                <form method="GET" class="w-100">
                                    <div class="input-group">
                                        <input name="buscarpor" class="form-control mt-3" type="search"
                                            placeholder="Buscar proceso o paso..." value="{{ $buscarpor }}">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class="table-responsive mt-3">
                            @include('tramites.configuracion.procesos_pasos.proceso_pasos')
                        </div>

                        {{ $proceso_pasos->links() }}

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(proceso, paso, nombrePaso) {
    Swal.fire({
        title: '¿Está seguro?',
        text: `¿Desea inactivar el paso "${nombrePaso}" del proceso seleccionado?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, inactivar',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${proceso}-${paso}`).submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loaderPrincipal');
    if (loader) loader.style.display = 'none';
});
</script>

@endsection
