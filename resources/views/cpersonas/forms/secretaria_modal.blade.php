{{-- Formulario modal para secretaria - versión compacta --}}
<style>
    /* Estilos específicos para modal */
    .modal-form-compact .form-group {
        margin-bottom: 1rem;
    }

    .modal-form-compact .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #495057;
    }

    .modal-form-compact .form-control {
        font-size: 0.85rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
    }

    .modal-form-compact .form-text {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .modal-form-compact .invalid-feedback {
        font-size: 0.75rem;
    }

    .modal-form-compact .input-group-sm .input-group-text {
        font-size: 0.8rem;
    }
</style>

<div class="modal-form-compact role-config-form">
    {{-- Información básica de la secretaria --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="secretaria_emailUniversidad" class="estilo-info">
                    Email Universitario * <i class="fas fa-envelope text-info" title="Email institucional único para la secretaria"></i>
                </label>
                <div class="input-group">
                    <input type="text" class="form-control @error('secretaria.emailUniversidad') is-invalid @enderror"
                        id="secretaria_emailUniversidad_username" name="secretaria[emailUniversidad_username]"
                        value="{{ old('secretaria.emailUniversidad_username') }}" placeholder="usuario"
                        style="border-color: #007bff;" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text" style="border-color: #007bff; background-color: #f8f9fa;">@</span>
                    </div>
                    <select class="form-control @error('secretaria.emailUniversidad') is-invalid @enderror"
                        id="secretaria_emailUniversidad_domain" name="secretaria[emailUniversidad_domain]"
                        style="border-color: #007bff;" required>
                        <option value="unitru.edu.pe" selected>unitru.edu.pe</option>
                    </select>
                </div>
                <small class="form-text text-muted">Debe ser único en el sistema administrativo</small>
                <small id="secretaria_emailHelp" class="form-text text-danger" style="display: none;"></small>
                @error('secretaria.emailUniversidad')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="secretaria_fecha_ingreso" class="estilo-info">
                    Fecha de Ingreso <i class="fas fa-calendar-alt text-primary" title="Fecha en que inició sus funciones administrativas"></i>
                </label>
                <input type="date" class="form-control @error('secretaria.fecha_ingreso') is-invalid @enderror"
                    id="secretaria_fecha_ingreso" name="secretaria[fecha_ingreso]"
                    value="{{ old('secretaria.fecha_ingreso') }}" style="border-color: #007bff;">
                <small id="secretaria_fecha_ingresoHelp" class="form-text text-danger" style="display: none;"></small>
                @error('secretaria.fecha_ingreso')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
</div>

<script>
// Función de inicialización para el formulario modal de secretaria
function initializeSecretariaModalForm() {
    // Validación de email universitario
    $('#secretaria_emailUniversidad_username, #secretaria_emailUniversidad_domain').on('input change', function() {
        var username = $('#secretaria_emailUniversidad_username').val().trim();
        var domain = $('#secretaria_emailUniversidad_domain').val();
        var $usernameInput = $('#secretaria_emailUniversidad_username');
        var $domainInput = $('#secretaria_emailUniversidad_domain');
        var $helpElement = $('#secretaria_emailHelp');

        // Limpiar estados previos
        $usernameInput.removeClass('is-valid is-invalid');
        $domainInput.removeClass('is-valid is-invalid');
        $helpElement.hide();

        // Validar formato del username
        if (username !== '' && !/^[a-zA-Z0-9._-]+$/.test(username)) {
            $usernameInput.addClass('is-invalid');
            $helpElement.text('El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.').removeClass('text-success').addClass('text-danger').show();
            return;
        }

        // Solo validar cuando ambos campos tengan contenido
        if (username === '' || domain === '') {
            return;
        }

        var emailCompleto = username + '@' + domain;

        // Validar formato completo del email
        if (!/^[a-zA-Z0-9._-]+@unitru\.edu\.pe$/.test(emailCompleto)) {
            $usernameInput.addClass('is-invalid');
            $domainInput.addClass('is-invalid');
            $helpElement.text('Formato de email inválido. Debe ser usuario@unitru.edu.pe').removeClass('text-success').addClass('text-danger').show();
            return;
        }

        // Validar longitud del username
        if (username.length < 3 || username.length > 50) {
            $usernameInput.addClass('is-invalid');
            $helpElement.text('El nombre de usuario debe tener entre 3 y 50 caracteres.').removeClass('text-success').addClass('text-danger').show();
            return;
        }

        // Email válido - verificar unicidad
        $usernameInput.addClass('is-valid');
        $domainInput.addClass('is-valid');
        $helpElement.text('Verificando disponibilidad del email...').removeClass('text-danger').addClass('text-success').show();

        // Verificar unicidad del email
        $.ajax({
            url: '/personas/verificar-email-universitario',
            type: 'GET',
            data: {
                email: emailCompleto,
                tipo: 'secretaria'
            },
            success: function(response) {
                if (response.existe) {
                    $usernameInput.removeClass('is-valid').addClass('is-invalid');
                    $domainInput.removeClass('is-valid').addClass('is-invalid');
                    $helpElement.text('Este email ya está registrado en el sistema').removeClass('text-success').addClass('text-danger').show();
                } else {
                    $usernameInput.removeClass('is-invalid').addClass('is-valid');
                    $domainInput.removeClass('is-invalid').addClass('is-valid');
                    $helpElement.text('Email disponible').removeClass('text-danger').addClass('text-success').show();
                }
            },
            error: function(xhr, status, error) {
                $usernameInput.removeClass('is-valid').addClass('is-invalid');
                $domainInput.removeClass('is-valid').addClass('is-invalid');
                $helpElement.text('Error al verificar el email. Intente nuevamente.').removeClass('text-success').addClass('text-danger').show();
            }
        });
    });

    // Validación de fecha de ingreso
    $('#secretaria_fecha_ingreso').on('change blur', function() {
        var fecha = $(this).val();
        var $helpElement = $('#secretaria_fecha_ingresoHelp');

        $(this).removeClass('is-valid is-invalid');
        $helpElement.hide();

        if (fecha === '') {
            return;
        }

        var fechaSeleccionada = new Date(fecha);
        var hoy = new Date();

        if (fechaSeleccionada > hoy) {
            $(this).addClass('is-invalid');
            $helpElement.text('La fecha no puede ser futura').removeClass('text-success').addClass('text-danger').show();
        } else {
            $(this).addClass('is-valid');
            $helpElement.hide();
        }
    });
}

// Hacer la función global para que pueda ser llamada desde el modal
window.initializeSecretariaModalForm = initializeSecretariaModalForm;

// Auto-inicializar si el script se carga directamente
$(document).ready(function() {
    initializeSecretariaModalForm();
});
</script>
