@extends('cplantilla.bprincipal')
@section('titulo', 'Acceso Denegado')
@section('contenidoplantilla')
<div class="container-fluid" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div class="row">
        <div class="col-12 text-center">
            <div class="card border-danger">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fa-4x text-danger mb-4"></i>
                    <h1 class="card-title text-danger">Acceso Denegado</h1>
                    <h4 class="card-text text-muted">No tienes permisos para acceder a esta sección</h4>
                    <p class="card-text">
                        Esta sección está restringida únicamente para usuarios con roles administrativos.
                        Si crees que deberías tener acceso, contacta al administrador del sistema.
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home mr-2"></i> Ir al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
