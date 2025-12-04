@extends('cplantilla.bprincipal')
@section('titulo', 'Crear Nuevo Docente')
@section('contenidoplantilla')
<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary { background: #007bff !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; margin: 0; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary:hover { background-color: #0056b3 !important; transform: scale(1.01); }
    .btn-secondary { background: #6c757d !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .btn-secondary:hover { background-color: #545b62 !important; transform: scale(1.01); }
    #loaderPrincipal[style*="display: flex"] { display: flex !important; justify-content: center; align-items: center; position: absolute !important; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: 2000; }
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
                    <i class="fas fa-chalkboard-teacher m-1"></i>&nbsp;Crear Nuevo Docente
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex ">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>
                                En esta sección, podrás registrar un nuevo docente en el sistema.
                            </p>
                            <p>
                                Estimado Usuario: Completa todos los campos obligatorios marcados con (*) y verifica que la información sea correcta antes de guardar. Se creará automáticamente una cuenta de usuario con credenciales que se enviarán por email.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2" style="background-color: #fcfffc !important">
                        <form action="{{ route('docentes.store') }}" method="POST" id="docenteForm">
                            @csrf

                            <!-- Información Personal -->
                            <div class="form-bordered">
                                <h5 class="estilo-info text-primary"><i class="fas fa-user"></i> Información Personal</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombres" class="estilo-info">Nombres *</label>
                                        <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" value="{{ old('nombres') }}" required style="border-color: #007bff;">
                                        @error('nombres')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos" class="estilo-info">Apellidos *</label>
                                        <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required style="border-color: #007bff;">
                                        @error('apellidos')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dni" class="estilo-info">DNI *</label>
                                        <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" value="{{ old('dni') }}" maxlength="8" style="border-color: #007bff;" pattern="[0-9]{8}" title="El DNI debe contener exactamente 8 dígitos">
                                        @error('dni')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                        <small id="dniHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono" class="estilo-info">Teléfono</label>
                                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" maxlength="9" style="border-color: #007bff;" pattern="[0-9]{9}" title="El teléfono debe contener exactamente 9 dígitos">
                                        @error('telefono')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                        <small id="telefonoHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="estilo-info">Email Personal</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email_username" name="email_username" value="{{ old('email_username', explode('@', old('email'))[0] ?? '') }}" style="border-color: #007bff;" placeholder="usuario" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="border-color: #007bff; background-color: #f8f9fa;">@</span>
                                            </div>
                                            <select class="form-control @error('email') is-invalid @enderror" id="email_domain" name="email_domain" style="border-color: #007bff;">
                                                <option value="">Seleccionar dominio</option>
                                                <option value="gmail.com" {{ (explode('@', old('email'))[1] ?? '') === 'gmail.com' ? 'selected' : '' }}>gmail.com</option>
                                                <option value="hotmail.com" {{ (explode('@', old('email'))[1] ?? '') === 'hotmail.com' ? 'selected' : '' }}>hotmail.com</option>
                                                <option value="outlook.com" {{ (explode('@', old('email'))[1] ?? '') === 'outlook.com' ? 'selected' : '' }}>outlook.com</option>
                                            </select>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                        <small id="emailHelp" class="form-text text-muted" style="font-weight: bold;"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_nacimiento" class="estilo-info">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" style="border-color: #007bff;" placeholder="dd/mm/aaaa">
                                        @error('fecha_nacimiento')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                        <small id="fechaHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genero" class="estilo-info">Género</label>
                                        <select class="form-control @error('genero') is-invalid @enderror" id="genero" name="genero" style="border-color: #007bff;">
                                            <option value="">Seleccionar género</option>
                                            <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                        @error('genero')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion" class="estilo-info">Dirección</label>
                                        <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3" style="border-color: #007bff;">{{ old('direccion') }}</textarea>
                                        @error('direccion')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Información Académica -->
                            <div class="form-bordered mt-4">
                                <h5 class="estilo-info text-primary"><i class="fas fa-graduation-cap"></i> Información Académica</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emailUniversidad" class="estilo-info">Email Universitario *</label>
                                        <input type="email" class="form-control @error('emailUniversidad') is-invalid @enderror" id="emailUniversidad" name="emailUniversidad" value="{{ old('emailUniversidad') }}" required style="border-color: #007bff;" placeholder="usuario@unitru.edu.pe">
                                        @error('emailUniversidad')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                        <small id="emailUniversidadHelp" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="especialidad" class="estilo-info">Especialidad</label>
                                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror" id="especialidad" name="especialidad" value="{{ old('especialidad') }}" style="border-color: #007bff;" placeholder="Ej: Matemáticas, Física, etc.">
                                        @error('especialidad')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_contratacion" class="estilo-info">Fecha de Contratación</label>
                                        <input type="date" class="form-control @error('fecha_contratacion') is-invalid @enderror" id="fecha_contratacion" name="fecha_contratacion" value="{{ old('fecha_contratacion') }}" style="border-color: #007bff;">
                                        @error('fecha_contratacion')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <button type="submit" class="btn btn-primary" style="width: 200px; height: 38px; padding: 6px 12px;">
                                            <i class="fas fa-save"></i> Guardar Docente
                                        </button>
                                        <button type="button" onclick="window.location.href='{{ route('docentes.index') }}'" class="btn btn-secondary" style="width: 120px; height: 38px; padding: 6px 12px;">
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

    // Validar nombres y apellidos (solo letras y espacios)
    $('#nombres, #apellidos').on('input', function() {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    });

    // Validar solo números en DNI
    $('#dni').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        var dni = $(this).val();

        if (dni.length === 0) {
            $('#dniHelp').removeClass('text-success text-danger').text('');
            $('#dni').removeClass('is-valid is-invalid');
        } else if (dni.length < 8) {
            $('#dniHelp').removeClass('text-success').addClass('text-warning').text('DNI incompleto: ' + dni.length + '/8 dígitos');
            $('#dni').removeClass('is-valid is-invalid');
        } else if (dni.length === 8) {
            $('#dniHelp').removeClass('text-warning').text('Verificando DNI...');
            verificarDni(dni);
        } else if (dni.length > 8) {
            $('#dniHelp').removeClass('text-success text-warning').addClass('text-danger').text('El DNI no puede tener más de 8 dígitos');
            $('#dni').addClass('is-invalid');
        }
    });

    // Validar teléfono
    $('#telefono').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        var telefono = $(this).val();

        if (telefono.length === 0) {
            $('#telefonoHelp').removeClass('text-success text-danger text-warning').text('');
            $('#telefono').removeClass('is-valid is-invalid');
        } else if (telefono.length < 9) {
            $('#telefonoHelp').removeClass('text-success text-danger').addClass('text-warning').text('Teléfono incompleto: ' + telefono.length + '/9 dígitos');
            $('#telefono').removeClass('is-valid is-invalid');
        } else if (telefono.length === 9) {
            $('#telefonoHelp').removeClass('text-warning text-danger').addClass('text-success').text('Teléfono válido');
            $('#telefono').removeClass('is-invalid').addClass('is-valid');
        } else if (telefono.length > 9) {
            this.value = telefono.substring(0, 9);
            $('#telefonoHelp').removeClass('text-success text-warning').addClass('text-danger').text('El teléfono no puede tener más de 9 dígitos');
            $('#telefono').addClass('is-invalid');
        }
    });

    // Validar email universitario
    $('#emailUniversidad').on('input', function() {
        var email = $(this).val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

        if (email.length === 0) {
            $('#emailUniversidadHelp').removeClass('text-success text-danger text-warning').text('');
            $('#emailUniversidad').removeClass('is-invalid is-valid');
            return;
        }

        if (emailRegex.test(email)) {
            $('#emailUniversidadHelp').removeClass('text-warning text-danger').addClass('text-success').text('Email válido');
            $('#emailUniversidad').removeClass('is-invalid').addClass('is-valid');
        } else {
            $('#emailUniversidadHelp').removeClass('text-success text-danger').addClass('text-warning').text('Formato de email incompleto');
            $('#emailUniversidad').addClass('is-invalid').removeClass('is-valid');
        }
    });

    // Validar fecha de nacimiento
    $('#fecha_nacimiento').on('change', function() {
        var fechaSeleccionada = new Date($(this).val());
        var hoy = new Date();
        var fechaMinima = new Date();
        fechaMinima.setFullYear(hoy.getFullYear() - 18);

        $('#fecha_nacimiento').removeClass('is-valid is-invalid');

        if ($(this).val() === '') {
            $('#fechaHelp').removeClass('text-success text-danger text-warning').text('');
            return;
        }

        if (fechaSeleccionada > hoy) {
            $('#fecha_nacimiento').addClass('is-invalid');
            $('#fechaHelp').removeClass('text-success text-muted text-warning').addClass('text-danger').text('La fecha no puede ser futura');
            Swal.fire({
                icon: 'warning',
                title: 'Fecha inválida',
                text: 'La fecha de nacimiento no puede ser futura.',
                confirmButtonColor: '#007bff'
            });
            $(this).val('');
        } else if (fechaSeleccionada > fechaMinima) {
            $('#fecha_nacimiento').addClass('is-invalid');
            $('#fechaHelp').removeClass('text-success text-muted text-warning').addClass('text-danger').text('Debe ser mayor de 18 años');
            Swal.fire({
                icon: 'warning',
                title: 'Edad insuficiente',
                text: 'La persona debe tener al menos 18 años.',
                confirmButtonColor: '#007bff'
            });
            $(this).val('');
        } else {
            var edad = hoy.getFullYear() - fechaSeleccionada.getFullYear();
            var mes = hoy.getMonth() - fechaSeleccionada.getMonth();
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaSeleccionada.getDate())) {
                edad--;
            }

            $('#fecha_nacimiento').addClass('is-valid');
            $('#fechaHelp').removeClass('text-danger text-muted text-warning').addClass('text-success').text('Fecha válida - Edad: ' + edad + ' años');
        }
    });

    // Función para verificar DNI
    function verificarDni(dni) {
        $.ajax({
            url: '{{ route('personas.verificarDni') }}',
            type: 'GET',
            data: { dni: dni },
            success: function(response) {
                if (response.existe) {
                    $('#dniHelp').removeClass('text-success text-warning').addClass('text-danger').text(response.mensaje);
                    $('#dni').addClass('is-invalid').removeClass('is-valid');
                } else {
                    $('#dniHelp').removeClass('text-danger text-warning').addClass('text-success').text(response.mensaje);
                    $('#dni').removeClass('is-invalid').addClass('is-valid');
                }
            },
            error: function(xhr, status, error) {
                $('#dniHelp').removeClass('text-success text-warning').addClass('text-danger').text('Error al verificar DNI.');
                $('#dni').addClass('is-invalid').removeClass('is-valid');
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
