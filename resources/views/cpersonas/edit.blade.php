@extends('cplantilla.bprincipal')
@section('titulo', 'Editar Persona')
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

        .text-warning {
            color: #ffc107 !important;
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

        /* Responsive roles */
        @media (max-width: 768px) {
            .role-card-container {
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }

            .role-card {
                min-width: auto !important;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .role-card-container {
                flex: 0 0 30% !important;
                max-width: 30% !important;
            }
        }

        @media (min-width: 993px) {
            .role-card-container {
                flex: 0 0 20% !important;
                max-width: 20% !important;
            }
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
                        <i class="fas fa-user-edit m-1"></i>&nbsp;Editar Persona: {{ $persona->nombres }} {{ $persona->apellidos }}
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>
                    <div class="card-body info">
                        <div class="d-flex ">
                            <div>
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                            <div class="p-2 flex-fill">
                                <p>
                                    En esta sección, puedes editar la información de la persona seleccionada.
                                </p>
                                <p>
                                    Estimado Usuario: Modifica los campos necesarios y verifica que la información sea correcta antes de guardar.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="collapse show" id="collapseExample0">
                        <div class="card card-body rounded-0 border-0 pt-0 pb-2"
                            style="background-color: #fcfffc !important">
                            <form action="{{ route('personas.update', $persona) }}" method="POST" id="personaForm">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombres" class="estilo-info">Nombres *</label>
                                            <input type="text"
                                                class="form-control @error('nombres') is-invalid @enderror" id="nombres"
                                                name="nombres" value="{{ old('nombres', $persona->nombres) }}" required
                                                style="border-color: #007bff;">
                                            @error('nombres')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apellidos" class="estilo-info">Apellidos *</label>
                                            <input type="text"
                                                class="form-control @error('apellidos') is-invalid @enderror" id="apellidos"
                                                name="apellidos" value="{{ old('apellidos', $persona->apellidos) }}" required
                                                style="border-color: #007bff;">
                                            @error('apellidos')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dni" class="estilo-info">DNI *</label>
                                            <input type="text" class="form-control @error('dni') is-invalid @enderror"
                                                id="dni" name="dni" value="{{ old('dni', $persona->dni) }}" maxlength="8"
                                                style="border-color: #007bff;" pattern="[0-9]{8}"
                                                title="El DNI debe contener exactamente 8 dígitos" required>
                                            @error('dni')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <small id="dniHelp" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono" class="estilo-info">Teléfono</label>
                                            <input type="text"
                                                class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                                                name="telefono" value="{{ old('telefono', $persona->telefono) }}" maxlength="9"
                                                style="border-color: #007bff;" pattern="[0-9]{9}"
                                                title="El teléfono debe contener exactamente 9 dígitos">
                                            @error('telefono')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <small id="telefonoHelp" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="estilo-info">Email *</label>
                                        <div class="input-group">
                                            @php
                                                $emailParts = explode('@', old('email', $persona->email ?? ''));
                                                $emailUsername = $emailParts[0] ?? '';
                                                $emailDomain = $emailParts[1] ?? '';
                                            @endphp
                                            <input type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="email_username" name="email_username"
                                                value="{{ old('email_username', $emailUsername) }}"
                                                style="border-color: #007bff;" placeholder="usuario"
                                                autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="border-color: #007bff; background-color: #f8f9fa;">@</span>
                                            </div>
                                            <select class="form-control @error('email') is-invalid @enderror"
                                                    id="email_domain" name="email_domain"
                                                    style="border-color: #007bff;">
                                                <option value="">Seleccionar dominio</option>
                                                <option value="unitru.edu.pe" {{ old('email_domain', $emailDomain) === 'unitru.edu.pe' ? 'selected' : '' }}>unitru.edu.pe</option>
                                                <option value="gmail.com" {{ old('email_domain', $emailDomain) === 'gmail.com' ? 'selected' : '' }}>gmail.com</option>
                                                <option value="hotmail.com" {{ old('email_domain', $emailDomain) === 'hotmail.com' ? 'selected' : '' }}>hotmail.com</option>
                                                <option value="outlook.com" {{ old('email_domain', $emailDomain) === 'outlook.com' ? 'selected' : '' }}>outlook.com</option>
                                            </select>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small id="emailHelp" class="form-text text-muted" style="font-weight: bold;"></small>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_nacimiento" class="estilo-info">Fecha de Nacimiento</label>
                                            <input type="date"
                                                class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                                id="fecha_nacimiento" name="fecha_nacimiento"
                                                value="{{ old('fecha_nacimiento', $persona->fecha_nacimiento ? $persona->fecha_nacimiento->format('Y-m-d') : '') }}" style="border-color: #007bff;"
                                                placeholder="dd/mm/aaaa">
                                            @error('fecha_nacimiento')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <small id="fechaHelp" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="genero" class="estilo-info">Género</label>
                                            <select class="form-control @error('genero') is-invalid @enderror" id="genero" name="genero"
                                                style="border-color: #007bff;">
                                                <option value="">Seleccionar género</option>
                                                <option value="M" {{ old('genero', $persona->genero) == 'M' ? 'selected' : '' }}>Masculino</option>
                                                <option value="F" {{ old('genero', $persona->genero) == 'F' ? 'selected' : '' }}>Femenino</option>
                                                <option value="Otro" {{ old('genero', $persona->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                            @error('genero')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="direccion" class="estilo-info">Dirección</label>
                                            <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion"
                                                rows="3" style="border-color: #007bff;">{{ old('direccion', $persona->direccion) }}</textarea>
                                            @error('direccion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="estilo-info">Roles</label>
                                    <small class="form-text text-muted mb-2">
                                        <strong>Selecciona los roles que tendrá esta persona en el sistema (opcional)</strong><br>
                                        <i class="fas fa-info-circle text-info"></i> Al agregar el primer rol, se creará automáticamente una cuenta de usuario con credenciales que se enviarán por email.
                                    </small>
                                    <div class="d-flex flex-wrap justify-content-center" style="gap: 1.5rem;">
                                        @foreach ($roles as $rol)
                                            <div class="role-card-container" style="flex: 0 0 auto;">
                                                <div class="card role-card border"
                                                    style="cursor: pointer; transition: all 0.2s; border-radius: 12px; min-width: 160px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                                    <div class="card-body text-center p-4">
                                                        <input class="form-check-input d-none" type="checkbox"
                                                            name="roles[]" value="{{ $rol->id_rol }}"
                                                            id="rol_{{ $rol->id_rol }}"
                                                            {{ $persona->roles->where('id_rol', $rol->id_rol)->count() > 0 || in_array($rol->id_rol, old('roles', [])) ? 'checked' : '' }}>
                                                        <div class="role-icon mb-3">
                                                            @if($rol->nombre == 'Administrador')
                                                                <i class="fas fa-crown fa-3x text-warning"></i>
                                                            @elseif($rol->nombre == 'Docente')
                                                                <i class="fas fa-chalkboard-teacher fa-3x text-info"></i>
                                                            @elseif($rol->nombre == 'Estudiante')
                                                                <i class="fas fa-user-graduate fa-3x text-success"></i>
                                                            @elseif($rol->nombre == 'Secretaria')
                                                                <i class="fas fa-user-tie fa-3x text-secondary"></i>
                                                            @elseif($rol->nombre == 'Representante')
                                                                <i class="fas fa-user-friends fa-3x text-primary"></i>
                                                            @else
                                                                <i class="fas fa-user-tag fa-3x text-secondary"></i>
                                                            @endif
                                                        </div>
                                                        <div class="role-name">
                                                            <strong class="text-dark">{{ $rol->nombre }}</strong>
                                                        </div>
                                                        <div class="role-description mt-2">
                                                            <small class="text-muted">{{ $rol->descripcion }}</small>
                                                        </div>
                                                        <div class="role-checkmark mt-3">
                                                            <i class="fas fa-check-circle text-success fa-lg"
                                                                style="display: none;"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('roles')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            @error('roles.*')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-center">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <button type="submit" class="btn btn-primary" style="width: 200px; height: 38px; padding: 6px 12px;">
                                                <i class="fas fa-save"></i> Actualizar Persona
                                            </button>
                                            <button type="button" onclick="window.location.href='{{ route('personas.index') }}'" class="btn btn-secondary" style="width: 120px; height: 38px; padding: 6px 12px;">
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
        // Función para validar email desde el atributo oninput
        function validarEmailManual(emailValue) {
            var email = emailValue.trim(); // Eliminar espacios en blanco
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            var regexResult = emailRegex.test(email);

            if (email.length === 0) {
                $('#emailHelp').removeClass('text-success text-danger text-warning').text('');
                $('#email').removeClass('is-invalid is-valid');
                return; // No ejecutar más validación
            }

            if (regexResult) {
                // Email válido - verificar unicidad
                $('#emailHelp').removeClass('text-warning text-danger').addClass('text-success').text('Verificando email...');
                $('#email').removeClass('is-invalid').addClass('is-valid');
                verificarEmailGlobal(email);
            } else {
                // Email en proceso de escritura - mostrar feedback básico
                $('#emailHelp').removeClass('text-success text-danger').addClass('text-warning').text('Formato de email incompleto');
                $('#email').addClass('is-invalid').removeClass('is-valid');
            }
        }

        // Función global para verificar email (fuera de document.ready)
        function verificarEmailGlobal(email) {
            $.ajax({
                url: '/personas/verificar-email',
                type: 'GET',
                data: { email: email, persona_id: {{ $persona->id_persona }} },
                success: function(response) {
                    console.log('Respuesta exitosa email global:', response);
                    console.log('Existe:', response.existe, 'Mensaje:', response.mensaje);
                    if (response.existe) {
                        $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger').text(response.mensaje);
                        $('#email').addClass('is-invalid').removeClass('is-valid');
                    } else {
                        $('#emailHelp').removeClass('text-danger text-warning').addClass('text-success').text(response.mensaje);
                        $('#email').removeClass('is-invalid').addClass('is-valid');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error AJAX email global:', xhr.status, xhr.responseText);
                    $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger').text('Error al verificar email.');
                    $('#email').addClass('is-invalid').removeClass('is-valid');
                }
            });
        }

        $(document).ready(function() {
            const loader = document.getElementById('loaderPrincipal');
            const contenido = document.getElementById('contenido-principal');
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';

            // Validar solo números en DNI y mostrar feedback en tiempo real
            $('#dni').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                var dni = $(this).val();

                if (dni.length === 0) {
                    $('#dniHelp').removeClass('text-success text-danger').text('');
                    $('#dni').removeClass('is-valid is-invalid');
                } else if (dni.length < 8) {
                    $('#dniHelp').removeClass('text-success').addClass('text-warning').text(
                        'DNI incompleto: ' + dni.length + '/8 dígitos');
                    $('#dni').removeClass('is-valid is-invalid');
                } else if (dni.length === 8) {
                    $('#dniHelp').removeClass('text-warning').text('Verificando DNI...');
                    verificarDni(dni);
                } else if (dni.length > 8) {
                    $('#dniHelp').removeClass('text-success text-warning').addClass('text-danger').text(
                        'El DNI no puede tener más de 8 dígitos');
                    $('#dni').addClass('is-invalid');
                }
            });

            // Verificar DNI en tiempo real
            $('#dni').on('blur', function() {
                var dni = $(this).val();
                if (dni.length === 8) {
                    verificarDni(dni);
                } else if (dni.length > 0) {
                    $('#dniHelp').removeClass('text-success').addClass('text-danger').text(
                        'El DNI debe contener exactamente 8 dígitos.');
                    $('#dni').addClass('is-invalid');
                }
            });

            // Función para combinar email
            function combineEmail() {
                var username = $('#email_username').val().trim();
                var domain = $('#email_domain').val();
                if (username && domain) {
                    return username + '@' + domain;
                }
                return '';
            }

            // Validar nombres y apellidos (solo letras y espacios)
            $('#nombres, #apellidos').on('input', function() {
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            });

            // Prevenir escribir "@" en el campo de usuario
            $('#email_username').on('input', function() {
                // Remover cualquier "@" que se escriba
                this.value = this.value.replace(/@/g, '');
            });

            // Combinar email cuando cambie username o domain
            $('#email_username, #email_domain').on('input change', function() {
                var combinedEmail = combineEmail();
                if (combinedEmail) {
                    // Limpiar errores de validación previos
                    $('#email_username').removeClass('is-invalid');
                    $('#email_domain').removeClass('is-invalid');
                    $('#emailHelp').removeClass('text-danger').text('');
                    validarEmailManual(combinedEmail);
                } else {
                    $('#emailHelp').removeClass('text-success text-danger text-warning').text('');
                    $('#email_username').removeClass('is-invalid');
                    $('#email_domain').removeClass('is-invalid');
                }
            });



            // Validar teléfono (solo números y mostrar feedback en tiempo real)
            $('#telefono').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                var telefono = $(this).val();

                if (telefono.length === 0) {
                    $('#telefonoHelp').removeClass('text-success text-danger text-warning').text('');
                    $('#telefono').removeClass('is-valid is-invalid');
                } else if (telefono.length < 9) {
                    $('#telefonoHelp').removeClass('text-success text-danger').addClass('text-warning')
                        .text('Teléfono incompleto: ' + telefono.length + '/9 dígitos');
                    $('#telefono').removeClass('is-valid is-invalid');
                } else if (telefono.length === 9) {
                    $('#telefonoHelp').removeClass('text-warning text-danger').addClass('text-success')
                        .text('Teléfono válido');
                    $('#telefono').removeClass('is-invalid').addClass('is-valid');
                } else if (telefono.length > 9) {
                    this.value = telefono.substring(0, 9);
                    $('#telefonoHelp').removeClass('text-success text-warning').addClass('text-danger')
                        .text('El teléfono no puede tener más de 9 dígitos');
                    $('#telefono').addClass('is-invalid');
                }
            });

            // Validar teléfono al perder foco
            $('#telefono').on('blur', function() {
                var telefono = $(this).val();
                if (telefono.length > 0 && telefono.length !== 9) {
                    $('#telefonoHelp').removeClass('text-success text-warning').addClass('text-danger')
                        .text('El teléfono debe contener exactamente 9 dígitos');
                    $('#telefono').addClass('is-invalid').removeClass('is-valid');
                } else if (telefono.length === 9) {
                    $('#telefonoHelp').removeClass('text-danger text-warning').addClass('text-success')
                        .text('Teléfono válido');
                    $('#telefono').removeClass('is-invalid').addClass('is-valid');
                }
            });

            // Validar fecha de nacimiento (opcional, pero si se ingresa debe ser de persona mayor de 18 años)
            $('#fecha_nacimiento').on('change', function() {
                var fechaSeleccionada = new Date($(this).val());
                var hoy = new Date();
                var fechaMinima = new Date();
                fechaMinima.setFullYear(hoy.getFullYear() - 18);

                $('#fecha_nacimiento').removeClass('is-valid is-invalid');

                if ($(this).val() === '') {
                    // Campo vacío - campo opcional
                    $('#fechaHelp').removeClass('text-success text-danger text-warning').text('');
                    return;
                }

                if (fechaSeleccionada > hoy) {
                    $('#fecha_nacimiento').addClass('is-invalid');
                    $('#fechaHelp').removeClass('text-success text-muted text-warning').addClass(
                        'text-danger').text('La fecha no puede ser futura');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Fecha inválida',
                        text: 'La fecha de nacimiento no puede ser futura.',
                        confirmButtonColor: '#007bff'
                    });
                    $(this).val('');
                } else if (fechaSeleccionada > fechaMinima) {
                    $('#fecha_nacimiento').addClass('is-invalid');
                    $('#fechaHelp').removeClass('text-success text-muted text-warning').addClass(
                        'text-danger').text('Debe ser mayor de 18 años');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Edad insuficiente',
                        text: 'La persona debe tener al menos 18 años.',
                        confirmButtonColor: '#007bff'
                    });
                    $(this).val('');
                } else {
                    // Calcular edad
                    var edad = hoy.getFullYear() - fechaSeleccionada.getFullYear();
                    var mes = hoy.getMonth() - fechaSeleccionada.getMonth();
                    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaSeleccionada.getDate())) {
                        edad--;
                    }

                    $('#fecha_nacimiento').addClass('is-valid');
                    $('#fechaHelp').removeClass('text-danger text-muted text-warning').addClass(
                        'text-success').text('Fecha válida - Edad: ' + edad + ' años');
                }
            });

            // Función para verificar DNI
            function verificarDni(dni) {
                $.ajax({
                    url: '{{ route('personas.verificarDni') }}',
                    type: 'GET',
                    data: {
                        dni: dni,
                        persona_id: {{ $persona->id_persona }}
                    },
                    success: function(response) {
                        console.log('Respuesta exitosa:', response);
                        console.log('Existe:', response.existe, 'Mensaje:', response.mensaje);
                        if (response.existe) {
                            $('#dniHelp').removeClass('text-success text-warning').addClass(
                                'text-danger').text(response.mensaje);
                            $('#dni').addClass('is-invalid').removeClass('is-valid');
                        } else {
                            $('#dniHelp').removeClass('text-danger text-warning').addClass(
                                'text-success').text(response.mensaje);
                            $('#dni').removeClass('is-invalid').addClass('is-valid');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error AJAX:', xhr.status, xhr.responseText);
                        $('#dniHelp').removeClass('text-success text-warning').addClass('text-danger')
                            .text('Error al verificar DNI.');
                        $('#dni').addClass('is-invalid').removeClass('is-valid');
                    }
                });
            }

            // Función para verificar Email
            function verificarEmail(email) {
                $.ajax({
                    url: '{{ route('personas.verificarEmail') }}',
                    type: 'GET',
                    data: {
                        email: email,
                        persona_id: {{ $persona->id_persona }}
                    },
                    success: function(response) {
                        console.log('Respuesta exitosa email:', response);
                        console.log('Existe:', response.existe, 'Mensaje:', response.mensaje);
                        if (response.existe) {
                            $('#emailHelp').removeClass('text-success text-warning').addClass(
                                'text-danger').text(response.mensaje);
                            $('#email').addClass('is-invalid').removeClass('is-valid');
                        } else {
                            $('#emailHelp').removeClass('text-danger text-warning').addClass(
                                'text-success').text(response.mensaje);
                            $('#email').removeClass('is-invalid').addClass('is-valid');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error AJAX email:', xhr.status, xhr.responseText);
                        $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger')
                            .text('Error al verificar email.');
                        $('#email').addClass('is-invalid').removeClass('is-valid');
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

            // Función para manejar la selección de roles con cards (checkboxes)
            $('.role-card').on('click', function() {
                var checkbox = $(this).find('input[type="checkbox"]');
                var checkmark = $(this).find('.role-checkmark i');
                var card = $(this);

                // Toggle del checkbox
                checkbox.prop('checked', !checkbox.prop('checked'));

                // Actualizar visualización
                if (checkbox.prop('checked')) {
                    card.addClass('border-success').css('background-color', '#f8fff8');
                    checkmark.show();
                    console.log('Rol seleccionado:', checkbox.val());
                } else {
                    card.removeClass('border-success').css('background-color', '');
                    checkmark.hide();
                    console.log('Rol deseleccionado:', checkbox.val());
                }
            });

            // Inicializar visualización de roles seleccionados al cargar la página
            function inicializarRolesSeleccionados() {
                $('input[type="checkbox"][name="roles[]"]').each(function() {
                    var checkbox = $(this);
                    var card = checkbox.closest('.role-card');
                    var checkmark = card.find('.role-checkmark i');

                    if (checkbox.prop('checked')) {
                        card.addClass('border-success').css('background-color', '#f8fff8');
                        checkmark.show();
                    } else {
                        card.removeClass('border-success').css('background-color', '');
                        checkmark.hide();
                    }
                });
            }

            // Inicializar validación de campos requeridos vacíos
            function inicializarValidacionCamposRequeridos() {
                // No hay campos opcionales que necesiten inicialización especial
            }

            // Validar y combinar email antes de enviar el formulario
            $('#personaForm').on('submit', function(e) {
                var username = $('#email_username').val().trim();
                var domain = $('#email_domain').val();

                // Si hay algo en el campo de usuario pero no hay dominio seleccionado
                if (username && !domain) {
                    e.preventDefault(); // Prevenir envío
                    $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger')
                        .text('Debes seleccionar un dominio de email');
                    $('#email_domain').addClass('is-invalid');
                    $('#email_username').addClass('is-invalid');
                    return false;
                }

                // Si hay dominio pero no hay usuario
                if (domain && !username) {
                    e.preventDefault(); // Prevenir envío
                    $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger')
                        .text('Debes ingresar un nombre de usuario');
                    $('#email_username').addClass('is-invalid');
                    $('#email_domain').addClass('is-invalid');
                    return false;
                }

                // Email se combina en el controlador
            });

            // Inicializar validación al cargar la página
            inicializarValidacionCamposRequeridos();
            inicializarRolesSeleccionados();

            window.addEventListener('pageshow', function(event) {
                if (loader) loader.style.display = 'none';
                if (contenido) contenido.style.opacity = '1';
            });
        });
    </script>
@endsection
