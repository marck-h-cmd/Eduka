@extends('cplantilla.bprincipal')
@section('titulo', 'Editar Estudiante')
@section('contenidoplantilla')
<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary { background: #007bff !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .btn-primary:hover { background-color: #0056b3 !important; transform: scale(1.01); }
    .btn-secondary { background: #6c757d !important; border: none; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .form-control, .form-select { font-family: "Quicksand", sans-serif; border-color: #007bff; }
    .form-label { font-weight: 600; color: #004a92; }
    .invalid-feedback { display: block; }
    .valid-feedback { display: block; color: #28a745; font-size: 0.875rem; margin-top: 0.25rem; }
    .is-valid { border-color: #28a745 !important; }
    .is-invalid { border-color: #dc3545 !important; }
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
                    <i class="fas fa-user-edit m-1"></i>&nbsp;Editar Estudiante
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex ">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>
                                Modifique los datos del estudiante. Todos los campos marcados con (*) son obligatorios.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-3 pb-2" style="background-color: #fcfffc !important">
                        <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST" id="formEditarEstudiante">
                            @csrf
                            @method('PUT')
                            
                            <!-- DATOS PERSONALES -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-user"></i> Datos Personales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombres" class="form-label">Nombres *</label>
                                            <input type="text" 
                                                   class="form-control @error('nombres') is-invalid @enderror" 
                                                   id="nombres" 
                                                   name="nombres" 
                                                   value="{{ old('nombres', $estudiante->persona->nombres) }}"
                                                   data-original-value="{{ $estudiante->persona->nombres }}"
                                                   required>
                                            <small id="nombresHelp" class="form-text text-muted"></small>
                                            @error('nombres')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="apellidos" class="form-label">Apellidos *</label>
                                            <input type="text" 
                                                   class="form-control @error('apellidos') is-invalid @enderror" 
                                                   id="apellidos" 
                                                   name="apellidos" 
                                                   value="{{ old('apellidos', $estudiante->persona->apellidos) }}"
                                                   data-original-value="{{ $estudiante->persona->apellidos }}"
                                                   required>
                                            <small id="apellidosHelp" class="form-text text-muted"></small>
                                            @error('apellidos')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="dni" class="form-label">DNI *</label>
                                            <input type="text" 
                                                   class="form-control @error('dni') is-invalid @enderror" 
                                                   id="dni" 
                                                   name="dni" 
                                                   maxlength="8"
                                                   value="{{ old('dni', $estudiante->persona->dni) }}"
                                                   data-original-value="{{ $estudiante->persona->dni }}"
                                                   required>
                                            <small id="dniHelp" class="form-text text-muted"></small>
                                            @error('dni')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" 
                                                   class="form-control @error('telefono') is-invalid @enderror" 
                                                   id="telefono" 
                                                   name="telefono" 
                                                   maxlength="9"
                                                   value="{{ old('telefono', $estudiante->persona->telefono) }}"
                                                   data-original-value="{{ $estudiante->persona->telefono }}">
                                            <small id="telefonoHelp" class="form-text text-muted"></small>
                                            @error('telefono')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="genero" class="form-label">Género</label>
                                            <select class="form-control @error('genero') is-invalid @enderror" 
                                                    id="genero" 
                                                    name="genero"
                                                    data-original-value="{{ $estudiante->persona->genero }}">
                                                <option value="">Seleccione</option>
                                                <option value="M" {{ old('genero', $estudiante->persona->genero) == 'M' ? 'selected' : '' }}>Masculino</option>
                                                <option value="F" {{ old('genero', $estudiante->persona->genero) == 'F' ? 'selected' : '' }}>Femenino</option>
                                                <option value="Otro" {{ old('genero', $estudiante->persona->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                            <small id="generoHelp" class="form-text text-muted"></small>
                                            @error('genero')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email_username" class="form-label">Email Personal</label>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       id="email_username" 
                                                       name="email_username" 
                                                       value="{{ old('email_username', explode('@', $estudiante->persona->email ?? '')[0] ?? '') }}"
                                                       data-original-value="{{ explode('@', $estudiante->persona->email ?? '')[0] ?? '' }}"
                                                       placeholder="usuario">
                                                <span class="input-group-text">@</span>
                                                <input type="text" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       id="email_domain" 
                                                       name="email_domain" 
                                                       value="{{ old('email_domain', explode('@', $estudiante->persona->email ?? '')[1] ?? '') }}"
                                                       data-original-value="{{ explode('@', $estudiante->persona->email ?? '')[1] ?? '' }}"
                                                       placeholder="dominio.com">
                                            </div>
                                            <small id="emailHelp" class="form-text text-muted"></small>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" 
                                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                                   id="fecha_nacimiento" 
                                                   name="fecha_nacimiento" 
                                                   value="{{ old('fecha_nacimiento', $estudiante->persona->fecha_nacimiento ? $estudiante->persona->fecha_nacimiento->format('Y-m-d') : '') }}"
                                                   data-original-value="{{ $estudiante->persona->fecha_nacimiento ? $estudiante->persona->fecha_nacimiento->format('Y-m-d') : '' }}">
                                            <small id="fechaHelp" class="form-text text-muted"></small>
                                            @error('fecha_nacimiento')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                                      id="direccion" 
                                                      name="direccion" 
                                                      rows="2"
                                                      data-original-value="{{ $estudiante->persona->direccion }}">{{ old('direccion', $estudiante->persona->direccion) }}</textarea>
                                            <small id="direccionHelp" class="form-text text-muted"></small>
                                            @error('direccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- DATOS ACADÉMICOS -->
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Datos Académicos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="emailUniversidad" class="form-label">Email Universitario *</label>
                                            <input type="email" 
                                                   class="form-control @error('emailUniversidad') is-invalid @enderror" 
                                                   id="emailUniversidad" 
                                                   name="emailUniversidad" 
                                                   value="{{ old('emailUniversidad', $estudiante->emailUniversidad) }}"
                                                   data-original-value="{{ $estudiante->emailUniversidad }}"
                                                   placeholder="Ingrese el email universitario"
                                                   required>
                                            <small id="emailUniversidadHelp" class="form-text text-muted"></small>
                                            @error('emailUniversidad')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="id_escuela" class="form-label">Escuela</label>
                                            <select class="form-control @error('id_escuela') is-invalid @enderror" 
                                                    id="id_escuela" 
                                                    name="id_escuela">
                                                <option value="">Seleccione una escuela</option>
                                                @foreach($escuelas as $escuela)
                                                    <option value="{{ $escuela->id_escuela }}" 
                                                            {{ old('id_escuela', $estudiante->id_escuela) == $escuela->id_escuela ? 'selected' : '' }}>
                                                        {{ $escuela->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_escuela')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="id_curricula" class="form-label">Currícula</label>
                                            <select class="form-control @error('id_curricula') is-invalid @enderror" 
                                                    id="id_curricula" 
                                                    name="id_curricula">
                                                <option value="">Seleccione una currícula</option>
                                                @foreach($curriculas as $curricula)
                                                    <option value="{{ $curricula->id_curricula }}" 
                                                            {{ old('id_curricula', $estudiante->id_curricula) == $curricula->id_curricula ? 'selected' : '' }}>
                                                        {{ $curricula->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_curricula')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="estado" class="form-label">Estado *</label>
                                            <select class="form-control @error('estado') is-invalid @enderror" 
                                                    id="estado" 
                                                    name="estado"
                                                    data-original-value="{{ $estudiante->estado }}"
                                                    required>
                                                <option value="Activo" {{ old('estado', $estudiante->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="Egresado" {{ old('estado', $estudiante->estado) == 'Egresado' ? 'selected' : '' }}>Egresado</option>
                                                <option value="Inactivo" {{ old('estado', $estudiante->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            <small id="estadoHelp" class="form-text text-muted"></small>
                                            @error('estado')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="anio_ingreso" class="form-label">Año de Ingreso *</label>
                                            <input type="number" 
                                                   class="form-control @error('anio_ingreso') is-invalid @enderror" 
                                                   id="anio_ingreso" 
                                                   name="anio_ingreso" 
                                                   min="1900"
                                                   max="{{ date('Y') + 10 }}"
                                                   value="{{ old('anio_ingreso', $estudiante->anio_ingreso) }}"
                                                   required>
                                            @error('anio_ingreso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anio_egreso" class="form-label">Año de Egreso</label>
                                            <input type="number" 
                                                   class="form-control @error('anio_egreso') is-invalid @enderror" 
                                                   id="anio_egreso" 
                                                   name="anio_egreso" 
                                                   min="1900"
                                                   max="{{ date('Y') + 20 }}"
                                                   value="{{ old('anio_egreso', $estudiante->anio_egreso) }}">
                                            @error('anio_egreso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- BOTONES -->
                            <div class="row mt-4">
                                <div class="col-md-6 mb-2">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary btn-block" id="btnCancelar">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
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
    // Función debounce
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }

    // Función para combinar email
    function combineEmail() {
        var username = $('#email_username').val().trim();
        var domain = $('#email_domain').val();
        if (username && domain) {
            return username + '@' + domain;
        }
        return '';
    }

    // Función para verificar DNI
    function verificarDni(dni) {
        var personaId = {{ $estudiante->persona->id_persona }};
        $.ajax({
            url: '{{ route('personas.verificarDni') }}',
            type: 'GET',
            data: { dni: dni, persona_id: personaId },
            success: function(response) {
                if (response.existe) {
                    $('#dniHelp').removeClass('text-success text-warning').addClass('text-danger').text(response.mensaje);
                    $('#dni').addClass('is-invalid').removeClass('is-valid');
                } else {
                    $('#dniHelp').removeClass('text-danger text-warning').addClass('text-success').text(response.mensaje);
                    $('#dni').removeClass('is-invalid').addClass('is-valid');
                }
            },
            error: function() {
                $('#dniHelp').removeClass('text-success text-warning').addClass('text-danger').text('Error al verificar DNI.');
                $('#dni').addClass('is-invalid').removeClass('is-valid');
            }
        });
    }

    // Función para verificar Email Personal
    function verificarEmail(email) {
        var personaId = {{ $estudiante->persona->id_persona }};
        $.ajax({
            url: '{{ route('personas.verificarEmail') }}',
            type: 'GET',
            data: { email: email, persona_id: personaId },
            success: function(response) {
                if (response.existe) {
                    $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger').text(response.mensaje);
                    $('#email_username').addClass('is-invalid').removeClass('is-valid');
                    $('#email_domain').addClass('is-invalid').removeClass('is-valid');
                } else {
                    $('#emailHelp').removeClass('text-danger text-warning').addClass('text-success').text(response.mensaje);
                    $('#email_username').removeClass('is-invalid').addClass('is-valid');
                    $('#email_domain').removeClass('is-invalid').addClass('is-valid');
                }
            },
            error: function() {
                $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger').text('Error al verificar email.');
                $('#email_username').addClass('is-invalid').removeClass('is-valid');
                $('#email_domain').addClass('is-invalid').removeClass('is-valid');
            }
        });
    }

    // Función para verificar Email Universitario
    function verificarEmailUniversitarioInput(forceCheck = false) {
        var $input = $('#emailUniversidad');
        var email = $input.val().trim();
        var $help = $('#emailUniversidadHelp');
        var personaId = {{ $estudiante->persona->id_persona }};
        var url = '{{ route('personas.verificarEmailUniversitario') }}';

        $help.removeClass('text-success text-danger text-warning').text('');
        $input.removeClass('is-valid is-invalid');

        if (!email) {
            return;
        }

        // Formato básico
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
        if (!emailRegex.test(email)) {
            $input.addClass('is-invalid');
            $help.addClass('text-danger').text('Formato de email inválido.');
            return;
        }

        // Mostrar verificación
        $help.removeClass('text-danger text-success').addClass('text-warning').text('Verificando email universitario...');
        
        // AJAX
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                email: email,
                tipo: 'estudiante',
                persona_id: personaId
            },
            success: function(response) {
                if (response.existe) {
                    $input.removeClass('is-valid').addClass('is-invalid');
                    $help.removeClass('text-success text-warning').addClass('text-danger').text(response.mensaje || 'Email universitario ya registrado.');
                } else {
                    $input.removeClass('is-invalid').addClass('is-valid');
                    $help.removeClass('text-danger text-warning').addClass('text-success').text(response.mensaje || 'Email universitario disponible.');
                }
            },
            error: function() {
                $input.removeClass('is-valid').addClass('is-invalid');
                $help.removeClass('text-success text-warning').addClass('text-danger').text('Error al verificar email universitario.');
            }
        });
    }

    $(document).ready(function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Validación de nombres y apellidos
        $('#nombres, #apellidos').on('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });

        // Validación de DNI
        $('#dni').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
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
            }
        });

        $('#dni').on('blur', function() {
            var dni = $(this).val();
            if (dni.length === 8) {
                verificarDni(dni);
            } else if (dni.length > 0) {
                $('#dniHelp').removeClass('text-success').addClass('text-danger').text('El DNI debe contener exactamente 8 dígitos.');
                $('#dni').addClass('is-invalid');
            }
        });

        // Validación de teléfono
        $('#telefono').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);
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
            }
        });

        // Prevención de escritura de "@" en usuario
        $('#email_username').on('input', function() {
            this.value = this.value.replace(/@/g, '');
        });

        // Validación de email personal
        $('#email_username, #email_domain').on('input change', function() {
            var combinedEmail = combineEmail();
            if (combinedEmail) {
                $('#email_username').removeClass('is-invalid');
                $('#email_domain').removeClass('is-invalid');
                $('#emailHelp').removeClass('text-danger').text('Verificando email...');
                verificarEmail(combinedEmail);
            } else {
                $('#emailHelp').removeClass('text-success text-danger text-warning').text('');
                $('#email_username').removeClass('is-invalid');
                $('#email_domain').removeClass('is-invalid');
            }
        });

        // Validación de Email Universitario (debounced en input, inmediata en blur)
        $('#emailUniversidad').off('input blur change');

        $('#emailUniversidad').on('input', debounce(function() {
            verificarEmailUniversitarioInput();
        }, 600));

        $('#emailUniversidad').on('blur', function() {
            verificarEmailUniversitarioInput(true);
        });

        // Loader al cancelar
        $('#btnCancelar').on('click', function(e) {
            e.preventDefault();
            if (loader) {
                loader.style.display = 'flex';
            }
            setTimeout(() => {
                window.location.href = this.href;
            }, 800);
        });

        // Mostrar mensajes de error
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                html: '<ul style="text-align: left;">' +
                    @foreach ($errors->all() as $error)
                        '<li>{{ $error }}</li>' +
                    @endforeach
                    '</ul>',
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