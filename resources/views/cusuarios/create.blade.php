@extends('cplantilla.bprincipal')
@section('titulo', 'Crear Nuevo Usuario')
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

    .persona-info {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 10px;
        margin-top: 10px;
    }

    .roles-display {
        margin-top: 10px;
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
                    <i class="fas fa-user-plus m-1"></i>&nbsp;Registrar Nuevo Usuario
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x" style="color: #0A8CB3;"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p class="mb-0" style="font-size:1.1rem; color:#004a92; font-weight:700;">
                                Complete el siguiente formulario para registrar un nuevo usuario. Todos los campos marcados con * son obligatorios.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-3 pb-2" style="background-color: #f8fbff !important; border: 1px solid #0A8CB3; margin-top: 18px;">
                        <form method="POST" action="{{ route('usuarios.store') }}" id="formUsuario">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_persona"><i class="fas fa-user-check mr-2"></i>Seleccionar Persona *</label>
                                        <select class="form-control @error('id_persona') is-invalid @enderror" id="id_persona" name="id_persona" required>
                                            <option value="">Seleccione una persona</option>
                                            @foreach($personas as $persona)
                                                <option value="{{ $persona->id_persona }}"
                                                        data-dni="{{ $persona->dni }}"
                                                        data-email="{{ $persona->email }}"
                                                        data-telefono="{{ $persona->telefono }}"
                                                        data-roles="{{ $persona->roles->pluck('nombre')->join(',') }}"
                                                        {{ (old('id_persona') == $persona->id_persona) || (isset($personaPreseleccionada) && $personaPreseleccionada->id_persona == $persona->id_persona) ? 'selected' : '' }}>
                                                    {{ $persona->nombres }} {{ $persona->apellidos }} ({{ $persona->dni }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_persona')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Solo se muestran personas activas que tienen roles asignados y no tienen usuario creado.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div id="persona-info" class="persona-info" style="display: none;">
                                <h6><i class="fas fa-info-circle mr-2"></i>Información de la Persona Seleccionada</h6>
                                <div id="persona-details"></div>
                                <div class="roles-display">
                                    <strong>Roles asignados:</strong>
                                    <div id="persona-roles" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username"><i class="fas fa-user mr-2"></i>Nombre de Usuario *</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required maxlength="50" autocomplete="off">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Nombre único para iniciar sesión</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email"><i class="fas fa-envelope mr-2"></i>Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" maxlength="100" autocomplete="off">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Opcional. Si no se proporciona, se usará el email de la persona seleccionada.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password"><i class="fas fa-lock mr-2"></i>Contraseña *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required minlength="8" autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="fas fa-eye-slash" id="passwordIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <!-- Password Strength Indicator -->
                                        <div id="passwordStrength" class="mt-2" style="display: none;">
                                            <small class="form-text">
                                                <div id="lengthCheck" class="password-requirement">
                                                    <i class="fas fa-times text-danger mr-1"></i>
                                                    Mínimo 8 caracteres
                                                </div>
                                                <div id="uppercaseCheck" class="password-requirement">
                                                    <i class="fas fa-times text-danger mr-1"></i>
                                                    Al menos una mayúscula
                                                </div>
                                                <div id="lowercaseCheck" class="password-requirement">
                                                    <i class="fas fa-times text-danger mr-1"></i>
                                                    Al menos una minúscula
                                                </div>
                                                <div id="numberCheck" class="password-requirement">
                                                    <i class="fas fa-times text-danger mr-1"></i>
                                                    Al menos un número
                                                </div>
                                                <div id="specialCheck" class="password-requirement">
                                                    <i class="fas fa-times text-danger mr-1"></i>
                                                    Al menos un carácter especial (@$!%*?&)
                                                </div>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation"><i class="fas fa-lock mr-2"></i>Confirmar Contraseña *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8" autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                                    <i class="fas fa-eye-slash" id="passwordConfirmationIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="passwordMatchFeedback" class="invalid-feedback" style="display: none;">
                                            Las contraseñas no coinciden
                                        </div>
                                        <small class="form-text text-muted">Repita la contraseña</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>Crear Usuario
                                        </button>
                                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
                                        </a>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        const form = document.getElementById('formUsuario');
        const personaSelect = document.getElementById('id_persona');
        const personaInfo = document.getElementById('persona-info');
        const personaDetails = document.getElementById('persona-details');
        const personaRoles = document.getElementById('persona-roles');

        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        if (form) {
            form.addEventListener('submit', function() {
                if (loader && contenido) {
                    loader.style.display = 'flex';
                    contenido.style.opacity = '0.5';
                }
            });
        }

        // Mostrar información de la persona seleccionada
        if (personaSelect) {
            personaSelect.addEventListener('change', function() {
                const selectedId = this.value;
                const selectedOption = this.options[this.selectedIndex];

                if (selectedId) {
                    // Obtener datos de la opción seleccionada (data attributes)
                    const dni = selectedOption.getAttribute('data-dni') || 'No especificado';
                    const email = selectedOption.getAttribute('data-email') || 'No especificado';
                    const telefono = selectedOption.getAttribute('data-telefono') || 'No especificado';
                    const roles = selectedOption.getAttribute('data-roles') || '';

                    // Mostrar detalles de la persona
                    personaDetails.innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <strong>DNI:</strong> ${dni}<br>
                                <strong>Email:</strong> ${email}<br>
                                <strong>Teléfono:</strong> ${telefono}
                            </div>
                        </div>
                    `;

                    // Mostrar roles
                    if (roles) {
                        const rolesArray = roles.split(',');
                        const rolesHtml = rolesArray.map(rol =>
                            `<span class="badge badge-info mr-1">${rol.trim()}</span>`
                        ).join('');
                        personaRoles.innerHTML = rolesHtml;
                    } else {
                        personaRoles.innerHTML = '<span class="text-muted">Sin roles asignados</span>';
                    }

                    // Mostrar el contenedor de información
                    personaInfo.style.display = 'block';
                } else {
                    personaInfo.style.display = 'none';
                }
            });

            // Si hay un valor preseleccionado (old input), mostrar la información
            if (personaSelect.value) {
                personaSelect.dispatchEvent(new Event('change'));
            }
        }

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const passwordConfirmationIcon = document.getElementById('passwordConfirmationIcon');

        if (togglePassword && passwordInput && passwordIcon) {
            togglePassword.addEventListener('click', function(e) {
                e.preventDefault();
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                passwordIcon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
            });
        }

        if (togglePasswordConfirmation && passwordConfirmationInput && passwordConfirmationIcon) {
            togglePasswordConfirmation.addEventListener('click', function(e) {
                e.preventDefault();
                const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmationInput.setAttribute('type', type);
                passwordConfirmationIcon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
            });
        }

        // Real-time password strength validation
        const passwordStrength = document.getElementById('passwordStrength');
        const lengthCheck = document.getElementById('lengthCheck');
        const uppercaseCheck = document.getElementById('uppercaseCheck');
        const lowercaseCheck = document.getElementById('lowercaseCheck');
        const numberCheck = document.getElementById('numberCheck');
        const specialCheck = document.getElementById('specialCheck');

        function validatePasswordStrength(password) {
            // Check each requirement
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[@$!%*?&]/.test(password);

            // Update visual indicators
            updateRequirement(lengthCheck, hasMinLength);
            updateRequirement(uppercaseCheck, hasUppercase);
            updateRequirement(lowercaseCheck, hasLowercase);
            updateRequirement(numberCheck, hasNumber);
            updateRequirement(specialCheck, hasSpecial);

            // Show/hide password strength indicator
            if (password.length > 0) {
                passwordStrength.style.display = 'block';
            } else {
                passwordStrength.style.display = 'none';
            }

            // Return overall validity
            return hasMinLength && hasUppercase && hasLowercase && hasNumber && hasSpecial;
        }

        function updateRequirement(element, isValid) {
            const icon = element.querySelector('i');
            if (isValid) {
                icon.className = 'fas fa-check text-success mr-1';
                element.classList.add('text-success');
                element.classList.remove('text-danger');
            } else {
                icon.className = 'fas fa-times text-danger mr-1';
                element.classList.add('text-danger');
                element.classList.remove('text-success');
            }
        }

        // Real-time password matching validation
        const passwordMatchFeedback = document.getElementById('passwordMatchFeedback');

        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirmation = passwordConfirmationInput.value;

            if (confirmation.length > 0) {
                if (password === confirmation) {
                    passwordConfirmationInput.classList.remove('is-invalid');
                    passwordConfirmationInput.classList.add('is-valid');
                    passwordMatchFeedback.style.display = 'none';
                } else {
                    passwordConfirmationInput.classList.remove('is-valid');
                    passwordConfirmationInput.classList.add('is-invalid');
                    passwordMatchFeedback.style.display = 'block';
                }
            } else {
                passwordConfirmationInput.classList.remove('is-valid', 'is-invalid');
                passwordMatchFeedback.style.display = 'none';
            }
        }

        // Add password strength validation to password input
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                validatePasswordStrength(this.value);
            });
        }

        if (passwordInput && passwordConfirmationInput) {
            passwordConfirmationInput.addEventListener('input', validatePasswordMatch);
            passwordInput.addEventListener('input', validatePasswordMatch);
        }

        // Form validation before submit
        if (form) {
            form.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirmation = passwordConfirmationInput.value;

                if (password !== confirmation) {
                    e.preventDefault();
                    passwordConfirmationInput.classList.add('is-invalid');
                    passwordMatchFeedback.style.display = 'block';
                    passwordMatchFeedback.textContent = 'Las contraseñas deben coincidir';

                    // Scroll to the password fields
                    passwordConfirmationInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    passwordConfirmationInput.focus();

                    return false;
                }
            });
        }

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection
