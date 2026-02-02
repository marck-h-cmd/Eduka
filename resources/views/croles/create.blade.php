@extends('cplantilla.bprincipal')
@section('titulo', 'Crear Nuevo Rol')
@section('contenidoplantilla')
<style>
    .form-bordered {
        margin: 0;
        border: none;
        padding-top: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #eaedf1;
    }

    .card-body.info {
        background: #f3f3f3;
        border-bottom: 1px solid rgba(0, 0, 0, .125);
        border-top: 1px solid rgba(0, 0, 0, .125);
        color: #F59D24;
    }

    .card-body.info p {
        margin-bottom: 0px;
        font-family: "Quicksand", sans-serif;
        font-weight: 600;
        color: #004a92;
    }

    .estilo-info {
        margin-bottom: 0px;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
    }

    .btn-primary {
        background: #007bff !important;
        border: none;
        transition: background-color 0.2s ease, transform 0.1s ease;
        margin: 0;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
    }

    .btn-primary:hover {
        background-color: #0056b3 !important;
        transform: scale(1.01);
    }

    .btn-secondary {
        background: #6c757d !important;
        border: none;
        transition: background-color 0.2s ease, transform 0.1s ease;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
    }

    .btn-secondary:hover {
        background-color: #545b62 !important;
        transform: scale(1.01);
    }

    /* Estilos para validación visual */
    .is-valid {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }

    #loaderPrincipal[style*="display: flex"] {
        display: flex !important;
        justify-content: center;
        align-items: center;
        position: absolute !important;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        z-index: 2000;
    }
</style>
<div class="container-fluid" id="contenido-principal" style="position: relative;">
    @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])
    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12">
            <div class="box_block">
                <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                    data-toggle="collapse" data-target="#collapseExample0" aria-expanded="true"
                    aria-controls="collapseExample"
                    style="background: #0A8CB3 !important; font-weight: bold; color: white;">
                    <i class="fas fa-user-shield m-1"></i>&nbsp;Registrar Nuevo Rol
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x" style="color: #0A8CB3;"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p class="mb-0" style="font-size:1.1rem; color:#004a92; font-weight:700;">
                                Complete el siguiente formulario para registrar un nuevo rol. Todos los campos marcados con * son obligatorios.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2"
                        style="background-color: #fcfffc !important">
                        <form action="{{ route('roles.store') }}" method="POST" id="rolForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre" class="estilo-info">Nombre del Rol *</label>
                                        <input type="text"
                                            class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                            name="nombre" value="{{ old('nombre') }}" required
                                            style="border-color: #007bff;">
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small id="nombreHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion" class="estilo-info">Descripción</label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                            rows="4" style="border-color: #007bff;">{{ old('descripcion') }}</textarea>
                                        @error('descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small id="descripcionHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <button type="submit" class="btn btn-primary" style="width: 200px; height: 38px; padding: 6px 12px;">
                                            <i class="fas fa-save"></i> Guardar Rol
                                        </button>
                                        <button type="button" onclick="window.location.href='{{ route('roles.index') }}'" class="btn btn-secondary" style="width: 120px; height: 38px; padding: 6px 12px;">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Validar nombre del rol en tiempo real
        $('#nombre').on('input', function() {
            var nombre = $(this).val().trim();

            if (nombre.length === 0) {
                $('#nombreHelp').removeClass('text-success text-danger').text('');
                $('#nombre').removeClass('is-valid is-invalid');
            } else if (nombre.length < 2) {
                $('#nombreHelp').removeClass('text-success').addClass('text-warning').text(
                    'El nombre debe tener al menos 2 caracteres');
                $('#nombre').removeClass('is-valid is-invalid');
            } else if (nombre.length >= 2) {
                $('#nombreHelp').removeClass('text-warning').text('Verificando nombre...');
                verificarNombreRol(nombre);
            } else if (nombre.length > 100) {
                $('#nombreHelp').removeClass('text-success text-warning').addClass('text-danger').text(
                    'El nombre no puede exceder 100 caracteres');
                $('#nombre').addClass('is-invalid').removeClass('is-valid');
            }
        });

        // Validar descripción en tiempo real
        $('#descripcion').on('input', function() {
            var descripcion = $(this).val();

            if (descripcion.length === 0) {
                $('#descripcionHelp').removeClass('text-success text-danger text-warning').text('');
                $('#descripcion').removeClass('is-valid is-invalid');
            } else if (descripcion.length <= 255) {
                $('#descripcionHelp').removeClass('text-danger text-warning').addClass('text-success')
                    .text('Descripción válida (' + descripcion.length + '/255 caracteres)');
                $('#descripcion').removeClass('is-invalid').addClass('is-valid');
            } else if (descripcion.length > 255) {
                $('#descripcionHelp').removeClass('text-success text-warning').addClass('text-danger')
                    .text('La descripción no puede exceder 255 caracteres');
                $('#descripcion').addClass('is-invalid').removeClass('is-valid');
            }
        });

        // Función para verificar nombre del rol
        function verificarNombreRol(nombre) {
            $.ajax({
                url: '{{ route('roles.index') }}',
                type: 'GET',
                data: {
                    buscarpor: nombre,
                    verificar: 'true'
                },
                success: function(response) {
                    // Verificar si ya existe un rol con ese nombre
                    var existe = false;
                    if (response.roles && response.roles.data) {
                        existe = response.roles.data.some(function(rol) {
                            return rol.nombre.toLowerCase() === nombre.toLowerCase();
                        });
                    }

                    if (existe) {
                        $('#nombreHelp').removeClass('text-success text-warning').addClass('text-danger').text(
                            'El nombre del rol ya está registrado.');
                        $('#nombre').addClass('is-invalid').removeClass('is-valid');
                    } else {
                        $('#nombreHelp').removeClass('text-danger text-warning').addClass('text-success').text(
                            'Nombre disponible.');
                        $('#nombre').removeClass('is-invalid').addClass('is-valid');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error AJAX verificar nombre:', xhr.status, xhr.responseText);
                    $('#nombreHelp').removeClass('text-success text-warning').addClass('text-danger').text(
                        'Error al verificar el nombre.');
                    $('#nombre').addClass('is-invalid').removeClass('is-valid');
                }
            });
        }

        // Mostrar errores de validación con SweetAlert2
        @if ($errors->any())
            var errores = '';
            @foreach ($errors->all() as $error)
                errores += '{{ $error }}\n';
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Errores de validación',
                text: errores.trim(),
                confirmButtonColor: '#007bff'
            });
        @endif

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection
