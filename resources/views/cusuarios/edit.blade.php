@extends('cplantilla.bprincipal')
@section('titulo', 'Editar Usuario')
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
                    <i class="fas fa-user-edit m-1"></i>&nbsp;Editar Usuario
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x" style="color: #0A8CB3;"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p class="mb-0" style="font-size:1.1rem; color:#004a92; font-weight:700;">
                                Modifique los datos del usuario. Todos los campos marcados con * son obligatorios.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-3 pb-2" style="background-color: #f8fbff !important; border: 1px solid #0A8CB3; margin-top: 18px;">

                        <!-- Información de la Persona (Solo lectura) -->
                        <div class="persona-info mb-4">
                            <h6><i class="fas fa-info-circle mr-2"></i>Información de la Persona Vinculada</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Nombre:</strong> {{ $usuario->persona->nombres }} {{ $usuario->persona->apellidos }}<br>
                                    <strong>DNI:</strong> {{ $usuario->persona->dni }}<br>
                                    <strong>Email:</strong> {{ $usuario->persona->email ?: 'No especificado' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Teléfono:</strong> {{ $usuario->persona->telefono ?: 'No especificado' }}<br>
                                    <strong>Estado:</strong>
                                    <span class="badge badge-{{ $usuario->persona->estado == 'Activo' ? 'success' : 'danger' }} ml-1">
                                        {{ $usuario->persona->estado }}
                                    </span>
                                </div>
                            </div>
                            <div class="roles-display mt-2">
                                <strong>Roles asignados:</strong>
                                <div class="mt-2">
                                    @if($usuario->persona->roles->count() > 0)
                                        @foreach($usuario->persona->roles as $rol)
                                            <span class="badge badge-info mr-1">
                                                <i class="fas fa-user-shield mr-1"></i>{{ $rol->nombre }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Sin roles asignados</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('usuarios.update', $usuario->id_usuario) }}" id="formUsuario">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username"><i class="fas fa-user mr-2"></i>Nombre de Usuario *</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $usuario->username) }}" required maxlength="50" autocomplete="off">
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
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}" maxlength="100" autocomplete="off">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Opcional. Si no se proporciona, se mantendrá el email actual.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password"><i class="fas fa-lock mr-2"></i>Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="off">
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
                                        <small class="form-text text-muted">
                                            Dejar vacío para mantener la contraseña actual. Debe cumplir con los requisitos de seguridad.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation"><i class="fas fa-lock mr-2"></i>Confirmar Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                                    <i class="fas fa-eye-slash" id="passwordConfirmationIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="passwordMatchFeedback" class="invalid-feedback" style="display: none;">
                                            Las contraseñas no coinciden
                                        </div>
                                        <small class="form-text text-muted">Repita la nueva contraseña</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="estado"><i class="fas fa-flag mr-2"></i>Estado *</label>
                                        <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                            <option value="Activo" {{ old('estado', $usuario->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                            <option value="Inactivo" {{ old('estado', $usuario->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            <option value="Bloqueado" {{ old('estado', $usuario->estado) == 'Bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                                        </select>
                                        @error('estado')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Controla si el usuario puede acceder al sistema</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>Actualizar Usuario
                                        </button>
                                        <a href="{{ route('usuarios.show', $usuario->id_usuario) }}" class="btn btn-secondary">
                                            <i class="fas fa-eye mr-2"></i>Ver Detalles
                                        </a>
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

                // Only validate if password is being changed
                if (password.length > 0) {
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
