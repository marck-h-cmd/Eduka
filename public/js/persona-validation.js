/**
 * Validaciones en tiempo real para formularios de personas
 * Archivo compartido para create y edit
 */

// Función para inicializar campos de roles
function toggleRoleFields() {
    // Esta función inicializa los campos de roles al cargar la página
}

// Función para inicializar validación de campos requeridos
function inicializarValidacionCamposRequeridos() {
    // Marcar campos requeridos visualmente
    $('input[required], select[required], textarea[required]').each(function() {
        $(this).addClass('required-field');
    });
}

// Función para inicializar roles seleccionados
function inicializarRolesSeleccionados() {
    // Mostrar paneles de roles que ya están seleccionados
    $('input[name="roles[]"]:checked').each(function() {
        var roleId = $(this).val();
        var roleName = $('.role-selector-card[data-role-id="' + roleId + '"]').data('role-name');
        var panel = $('#' + roleName.toLowerCase() + '-panel');
        if (panel.length > 0) {
            $('#role-config-container').show();
            panel.show();
        }
    });
}

// Función para mostrar indicador de carga
function showLoading() {
    const loader = document.getElementById('loaderPrincipal');
    const contenido = document.getElementById('contenido-principal');
    if (loader) {
        loader.style.display = 'flex';
        loader.innerHTML = `
            <div class="text-center">
                <div class="spinner-container">
                    <div class="circle c1"></div>
                    <div class="circle c2"></div>
                    <div class="circle c3"></div>
                    <div class="circle c4"></div>
                </div>
                <div class="mt-3">
                    <h5 class="text-white">Procesando...</h5>
                </div>
            </div>
        `;
    }
    if (contenido) contenido.style.opacity = '0.5';
}

// Función para validar email desde el atributo oninput
function validarEmailManual(emailValue) {
    var email = emailValue.trim();
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    if (email.length === 0) {
        $('#emailHelp').removeClass('text-success text-danger text-warning').text('');
        $('#email_username').removeClass('is-invalid is-valid');
        $('#email_domain').removeClass('is-invalid is-valid');
        return;
    }

    if (emailRegex.test(email)) {
        $('#emailHelp').removeClass('text-warning text-danger').addClass('text-success').text('Verificando email...');
        $('#email_username').removeClass('is-invalid').addClass('is-valid');
        $('#email_domain').removeClass('is-invalid').addClass('is-valid');
        verificarEmailGlobal(email);
    } else {
        $('#emailHelp').removeClass('text-success text-danger').addClass('text-warning').text('Formato de email incompleto');
        $('#email_username').addClass('is-invalid').removeClass('is-valid');
        $('#email_domain').addClass('is-invalid').removeClass('is-valid');
    }
}

// Función global para verificar email
function verificarEmailGlobal(email) {
    var personaId = typeof window.personaId !== 'undefined' ? window.personaId : null;

    $.ajax({
        url: '/personas/verificar-email',
        type: 'GET',
        data: {
            email: email,
            persona_id: personaId
        },
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
        error: function(xhr, status, error) {
            $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger').text('Error al verificar email.');
            $('#email_username').addClass('is-invalid').removeClass('is-valid');
            $('#email_domain').addClass('is-invalid').removeClass('is-valid');
        }
    });
}

// Función para validar email universitario de roles
function validarEmailUniversitarioRol(tipo) {
    var $usernameInput = $('#' + tipo + '_emailUniversidad_username');
    var $domainInput = $('#' + tipo + '_emailUniversidad_domain');
    var $helpElement = $('#' + tipo + '_emailHelp');

    var username = $usernameInput.val().trim();
    var domain = $domainInput.val();

    // Limpiar estados previos
    $usernameInput.removeClass('is-valid is-invalid');
    $domainInput.removeClass('is-valid is-invalid');
    $helpElement.hide();

    // Validar formato del username
    if (username !== '' && !/^[a-zA-Z0-9._-]+$/.test(username)) {
        $usernameInput.addClass('is-invalid');
        mostrarMensajeErrorRol(tipo, 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.');
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
        mostrarMensajeErrorRol(tipo, 'Formato de email inválido. Debe ser usuario@unitru.edu.pe');
        return;
    }

    // Validar longitud del username
    if (username.length < 3 || username.length > 50) {
        $usernameInput.addClass('is-invalid');
        mostrarMensajeErrorRol(tipo, 'El nombre de usuario debe tener entre 3 y 50 caracteres.');
        return;
    }

    // Email válido - verificar unicidad
    $usernameInput.addClass('is-valid');
    $domainInput.addClass('is-valid');
    verificarEmailUniversitarioUnico(emailCompleto, tipo, $usernameInput, $domainInput);
}

// Función para verificar unicidad de email universitario
function verificarEmailUniversitarioUnico(email, tipo, $input, $domainInput) {
    var personaId = typeof window.personaId !== 'undefined' ? window.personaId : null;

    mostrarMensajeErrorRol(tipo, 'Verificando disponibilidad del email...');

    $.ajax({
        url: '/personas/verificar-email-universitario',
        type: 'GET',
        data: {
            email: email,
            tipo: tipo,
            persona_id: personaId
        },
        success: function(response) {
            if (response.existe) {
                $input.removeClass('is-valid').addClass('is-invalid');
                if ($domainInput) $domainInput.removeClass('is-valid').addClass('is-invalid');
                mostrarMensajeErrorRol(tipo, 'Este email ya está registrado en el sistema');
            } else {
                $input.removeClass('is-invalid').addClass('is-valid');
                if ($domainInput) $domainInput.removeClass('is-invalid').addClass('is-valid');
                mostrarMensajeErrorRol(tipo, '');
            }
        },
        error: function(xhr, status, error) {
            $input.removeClass('is-valid').addClass('is-invalid');
            if ($domainInput) $domainInput.removeClass('is-valid').addClass('is-invalid');
            mostrarMensajeErrorRol(tipo, 'Error al verificar el email. Intente nuevamente.');
        }
    });
}

// Función para mostrar mensaje de error en roles
function mostrarMensajeErrorRol(tipo, mensaje) {
    var $helpElement = $('#' + tipo + '_emailHelp');
    if (mensaje) {
        $helpElement.text(mensaje).removeClass('text-success').addClass('text-danger').show();
    } else {
        $helpElement.text('').hide();
    }
}

// Función para mostrar mensaje de error genérico
function mostrarMensajeError($input, mensaje) {
    if (mensaje) {
        var inputId = $input.attr('id');
        var helpElementId = inputId + 'Help';
        var $helpElement = $('#' + helpElementId);

        if ($helpElement.length > 0) {
            $helpElement.text(mensaje).removeClass('text-success').addClass('text-danger').show();
        }
    } else {
        var inputId = $input.attr('id');
        var helpElementId = inputId + 'Help';
        var $helpElement = $('#' + helpElementId);
        if ($helpElement.length > 0) {
            $helpElement.text('').hide();
        }
    }
}

// Función para validar fecha de contratación
function validarFechaContratacion($input) {
    var fecha = $input.val();

    $input.removeClass('is-valid is-invalid');

    if (fecha === '') {
        return;
    }

    // Fecha válida (puede ser futura)
    $input.addClass('is-valid');
}

// Función para validar especialidades seleccionadas
function validarEspecialidadesSeleccionadas() {
    var seleccionadas = $('.especialidad-checkbox:checked').length;
    var $container = $('#especialidades-container');

    $container.removeClass('border-success border-danger');

    if (seleccionadas === 0) {
        $container.addClass('border-danger');
        return false;
    }

    $container.addClass('border-success');
    return true;
}

// Función para validar año de ingreso
function validarAnioIngreso($input) {
    var anio = parseInt($input.val());
    var anioActual = new Date().getFullYear();

    $input.removeClass('is-valid is-invalid');

    if (isNaN(anio) || anio < 2000 || anio > anioActual + 5) {
        $input.addClass('is-invalid');
        return;
    }

    $input.addClass('is-valid');

    // Si hay año de egreso, validar que sea consistente
    var $anioEgreso = $('#estudiante_anio_egreso');
    if ($anioEgreso.val()) {
        validarAnioEgreso($anioEgreso);
    }
}

// Función para validar año de egreso
function validarAnioEgreso($input) {
    var anioEgreso = parseInt($input.val());
    var anioIngreso = parseInt($('#estudiante_anio_ingreso').val());
    var anioActual = new Date().getFullYear();

    $input.removeClass('is-valid is-invalid');

    if ($input.val() === '') {
        return;
    }

    if (isNaN(anioEgreso) || anioEgreso < 2000 || anioEgreso > anioActual + 10) {
        $input.addClass('is-invalid');
        return;
    }

    if (anioEgreso < anioIngreso) {
        $input.addClass('is-invalid');
        return;
    }

    $input.addClass('is-valid');
}

// Función para validar fecha de ingreso
function validarFechaIngreso($input) {
    var fecha = $input.val();

    $input.removeClass('is-valid is-invalid');

    if (fecha === '') {
        return;
    }

    $input.addClass('is-valid');
}

// Función para mostrar mensaje de error en especialidades
function mostrarMensajeErrorEspecialidades() {
    var seleccionadas = $('.especialidad-checkbox:checked').length;
    var $container = $('#especialidades-container');

    if (seleccionadas === 0) {
        if (!$('#especialidades-error').length) {
            $container.after('<small id="especialidades-error" class="form-text text-danger">Debe seleccionar al menos una especialidad</small>');
        }
        $('#especialidades-error').show();
    } else {
        $('#especialidades-error').hide();
    }
}

// Funciones de mensaje para diferentes validaciones
function validarFechaContratacionMensaje($input) {
    var fecha = $input.val();
    if (fecha === '') return '';
    return '';
}

function validarAnioIngresoMensaje($input) {
    var anio = parseInt($input.val());

    if (isNaN(anio) || anio < 2000) {
        return 'Año de ingreso inválido (debe ser mayor o igual a 2000)';
    }
    return '';
}

function validarAnioEgresoMensaje($input) {
    var anioEgreso = parseInt($input.val());
    var anioIngreso = parseInt($('#estudiante_anio_ingreso').val());

    if ($input.val() === '') return '';

    if (isNaN(anioEgreso) || anioEgreso < 2000) {
        return 'Año de egreso inválido (debe ser mayor o igual a 2000)';
    }

    if (anioEgreso < anioIngreso) {
        return 'El año de egreso no puede ser menor al año de ingreso';
    }
    return '';
}

function validarFechaIngresoMensaje($input) {
    var fecha = $input.val();
    if (fecha === '') return '';
    return '';
}

// Función para seleccionar un rol
function toggleRoleSelect(roleId, roleName) {
    var checkbox = $('#role_checkbox_' + roleId);
    var card = $('.role-selector-card[data-role-id="' + roleId + '"]');
    var panel = $('#' + roleName.toLowerCase() + '-panel');
    var collapse = $('#' + roleName.toLowerCase() + '-collapse');

    // Seleccionar rol
    checkbox.prop('checked', true);
    card.addClass('selected');
    card.find('.role-status-badge').removeClass('badge-secondary').addClass('badge-success')
        .html('<i class="fas fa-check-circle"></i> Seleccionado');
    card.find('.role-checkmark').show();

    // Mostrar contenedor de paneles y mostrar este panel
    $('#role-config-container').show();
    panel.show();

    // Abrir automáticamente el panel colapsable
    if (collapse.length > 0) {
        collapse.collapse('show');
    }

    // Inicializar valores por defecto para el rol seleccionado
    if (roleName === 'Docente') {
        $('#docente_emailUniversidad_domain').val('unitru.edu.pe');
    } else if (roleName === 'Estudiante') {
        $('#estudiante_emailUniversidad_domain').val('unitru.edu.pe');
        var currentYear = new Date().getFullYear();
        $('#estudiante_anio_ingreso').val(currentYear);
        $('#estudiante_anio_egreso').val(currentYear + 5);
    } else if (roleName === 'Secretaria') {
        $('#secretaria_emailUniversidad_domain').val('unitru.edu.pe');
    }
}

// Función para deseleccionar un rol
function toggleRoleDeselect(roleId, roleName) {
    var checkbox = $('#role_checkbox_' + roleId);
    var card = $('.role-selector-card[data-role-id="' + roleId + '"]');
    var panel = $('#' + roleName.toLowerCase() + '-panel');

    // Deseleccionar rol
    checkbox.prop('checked', false);
    card.removeClass('selected');
    card.find('.role-status-badge').removeClass('badge-success').addClass('badge-secondary')
        .html('<i class="fas fa-plus-circle"></i> Seleccionar');
    card.find('.role-checkmark').hide();

    // Ocultar panel
    panel.hide();

    // Verificar si quedan roles seleccionados
    var hasSelectedRoles = $('input[name="roles[]"]:checked').length > 0;
    if (!hasSelectedRoles) {
        $('#role-config-container').hide();
    }
}

// Gestión de roles con tabs optimizada
function toggleRole(roleId, roleName) {
    var checkbox = $('#role_checkbox_' + roleId);
    var isCurrentlySelected = checkbox.prop('checked');

    if (isCurrentlySelected) {
        toggleRoleDeselect(roleId, roleName);
    } else {
        toggleRoleSelect(roleId, roleName);
    }
}

// Función para remover rol
function removeRole(roleId) {
    var roleNames = { 1: 'Administrador', 2: 'Docente', 3: 'Estudiante', 4: 'Secretaria' };
    var roleName = roleNames[roleId] || 'Rol';
    toggleRole(roleId, roleName);
}

// Función para limpiar datos de un rol específico
function limpiarDatosRol(roleId) {
    switch(roleId) {
        case 4: // Administrador
            break;
        case 2: // Docente
            $('#docente_emailUniversidad_username').val('').removeClass('is-valid is-invalid');
            $('#docente_emailUniversidad_domain').val('unitru.edu.pe').removeClass('is-valid is-invalid');
            $('#docente_emailHelp').hide();
            $('#docente_fecha_contratacion').val('').removeClass('is-valid is-invalid');
            $('.especialidad-checkbox:checked').prop('checked', false).trigger('change');
            $('#especialidad-search').val('');
            filtrarEspecialidades('');
            break;
        case 1: // Estudiante
            $('#estudiante_emailUniversidad_username').val('').removeClass('is-valid is-invalid');
            $('#estudiante_emailUniversidad_domain').val('unitru.edu.pe').removeClass('is-valid is-invalid');
            $('#estudiante_emailHelp').hide();
            $('#estudiante_anio_ingreso').val('').removeClass('is-valid is-invalid');
            $('#estudiante_anio_egreso').val('').removeClass('is-valid is-invalid');
            $('#estudiante_id_escuela').val('').removeClass('is-valid is-invalid');
            $('#estudiante_id_curricula').val('').removeClass('is-valid is-invalid');
            filtrarCurriculasPorEscuela();
            break;
        case 3: // Secretaria
            $('#secretaria_emailUniversidad_username').val('').removeClass('is-valid is-invalid');
            $('#secretaria_emailUniversidad_domain').val('unitru.edu.pe').removeClass('is-valid is-invalid');
            $('#secretaria_emailHelp').hide();
            $('#secretaria_fecha_ingreso').val('').removeClass('is-valid is-invalid');
            break;
    }
}

// Función para filtrar especialidades
function filtrarEspecialidades(searchTerm) {
    var term = searchTerm.toLowerCase().trim();
    var $items = $('.especialidad-item');
    var visibleCount = 0;

    $items.each(function() {
        var $item = $(this);
        var nombre = $item.data('nombre') || '';
        var isVisible = term === '' || nombre.includes(term);

        $item.toggle(isVisible);
        if (isVisible) visibleCount++;
    });

    $('#especialidades-total').text(visibleCount + ' de ' + $items.length);
}

// Función para seleccionar todas las especialidades
function seleccionarTodasEspecialidades() {
    $('.especialidad-item:visible .especialidad-checkbox:not(:checked)').prop('checked', true).trigger('change');
}

// Función para deseleccionar todas las especialidades
function deseleccionarTodasEspecialidades() {
    $('.especialidad-item:visible .especialidad-checkbox:checked').prop('checked', false).trigger('change');
}

// Función para actualizar contador de especialidades seleccionadas
function actualizarContadorEspecialidades() {
    var seleccionadas = $('.especialidad-checkbox:checked').length;
    $('#especialidades-seleccionadas').text(seleccionadas);
}

// Función para verificar DNI
function verificarDni(dni) {
    var personaId = typeof window.personaId !== 'undefined' ? window.personaId : null;

    $.ajax({
        url: '/personas/verificar-dni',
        type: 'GET',
        data: {
            dni: dni,
            persona_id: personaId
        },
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

// Función para verificar Email
function verificarEmail(email) {
    var personaId = typeof window.personaId !== 'undefined' ? window.personaId : null;

    $.ajax({
        url: '/personas/verificar-email',
        type: 'GET',
        data: {
            email: email,
            persona_id: personaId
        },
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
        error: function(xhr, status, error) {
            $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger').text('Error al verificar email.');
            $('#email_username').addClass('is-invalid').removeClass('is-valid');
            $('#email_domain').addClass('is-invalid').removeClass('is-valid');
        }
    });
}

// Variable para almacenar las opciones originales de currículas
var opcionesCurriculasOriginales = [];

// Función para inicializar opciones de currículas
function inicializarOpcionesCurriculas() {
    $('#estudiante_id_curricula option[data-escuela]').each(function() {
        opcionesCurriculasOriginales.push({
            value: $(this).val(),
            text: $(this).text(),
            escuela: $(this).data('escuela')
        });
    });
}

// Función para filtrar currículas por escuela
function filtrarCurriculasPorEscuela() {
    var escuelaSeleccionada = $('#estudiante_id_escuela').val();
    var $curriculaSelect = $('#estudiante_id_curricula');
    var curriculaActualSeleccionada = $curriculaSelect.val(); // Guardar la selección actual

    // No limpiar el valor si ya hay algo seleccionado (modo edición)
    if (!escuelaSeleccionada) {
        $curriculaSelect.html('<option value="">Primero seleccione una escuela</option>');
        return;
    }

    var opcionesFiltradas = '<option value="">Seleccionar currícula</option>';
    opcionesCurriculasOriginales.forEach(function(opcion) {
        if (opcion.escuela == escuelaSeleccionada) {
            var selected = (curriculaActualSeleccionada && opcion.value == curriculaActualSeleccionada) ? ' selected' : '';
            opcionesFiltradas += '<option value="' + opcion.value + '"' + selected + '>' + opcion.text + '</option>';
        }
    });

    if (opcionesFiltradas === '<option value="">Seleccionar currícula</option>') {
        opcionesFiltradas = '<option value="">No hay currículas vigentes para esta escuela</option>';
    }

    $curriculaSelect.html(opcionesFiltradas);
}

// Función para validar formulario de un rol específico
function validarFormularioRol(roleId) {
    var errores = [];

    switch(parseInt(roleId)) {
        case 2: // Docente
            var $usernameDocente = $('#docente_emailUniversidad_username');
            var $domainDocente = $('#docente_emailUniversidad_domain');
            var usernameDocente = $usernameDocente.val().trim();
            var domainDocente = $domainDocente.val();

            if (!domainDocente) {
                $domainDocente.val('unitru.edu.pe');
                domainDocente = 'unitru.edu.pe';
            }

            if (!usernameDocente || !domainDocente) {
                errores.push('• Docente: Email universitario es requerido');
            } else {
                var emailDocente = usernameDocente + '@' + domainDocente;
                if (!/^[^\s@]+@unitru\.edu\.pe$/.test(emailDocente)) {
                    errores.push('• Docente: Email universitario debe tener formato usuario@unitru.edu.pe');
                }
            }

            var especialidadesSeleccionadas = $('.especialidad-checkbox:checked').length;
            if (especialidadesSeleccionadas === 0) {
                errores.push('• Docente: Debe seleccionar al menos una especialidad');
            }
            break;

        case 1: // Estudiante
            var $usernameEstudiante = $('#estudiante_emailUniversidad_username');
            var $domainEstudiante = $('#estudiante_emailUniversidad_domain');
            var usernameEstudiante = $usernameEstudiante.val().trim();
            var domainEstudiante = $domainEstudiante.val();

            if (!domainEstudiante) {
                $domainEstudiante.val('unitru.edu.pe');
                domainEstudiante = 'unitru.edu.pe';
            }

            if (!usernameEstudiante || !domainEstudiante) {
                errores.push('• Estudiante: Email universitario es requerido');
            } else {
                var emailEstudiante = usernameEstudiante + '@' + domainEstudiante;
                if (!/^[^\s@]+@unitru\.edu\.pe$/.test(emailEstudiante)) {
                    errores.push('• Estudiante: Email universitario debe tener formato usuario@unitru.edu.pe');
                }
            }

            var anioIngreso = $('#estudiante_anio_ingreso').val();
            if (!anioIngreso) {
                errores.push('• Estudiante: Año de ingreso es requerido');
            }

            var anioEgreso = $('#estudiante_anio_egreso').val();
            if (anioEgreso && parseInt(anioEgreso) < parseInt(anioIngreso)) {
                errores.push('• Estudiante: Año de egreso no puede ser menor al año de ingreso');
            }

            var curriculaSeleccionada = $('#estudiante_id_curricula').val();
            if (!curriculaSeleccionada) {
                errores.push('• Estudiante: La currícula es obligatoria');
            }
            break;

        case 3: // Secretaria
            var $usernameSecretaria = $('#secretaria_emailUniversidad_username');
            var $domainSecretaria = $('#secretaria_emailUniversidad_domain');
            var usernameSecretaria = $usernameSecretaria.val().trim();
            var domainSecretaria = $domainSecretaria.val();

            if (!domainSecretaria) {
                $domainSecretaria.val('unitru.edu.pe');
                domainSecretaria = 'unitru.edu.pe';
            }

            if (!usernameSecretaria || !domainSecretaria) {
                errores.push('• Secretaria: Email universitario es requerido');
            } else {
                var emailSecretaria = usernameSecretaria + '@' + domainSecretaria;
                if (!/^[^\s@]+@unitru\.edu\.pe$/.test(emailSecretaria)) {
                    errores.push('• Secretaria: Email universitario debe tener formato usuario@unitru.edu.pe');
                }
            }
            break;
    }

    return errores;
}

// Función para inicializar especialidades
function inicializarEspecialidadesVisual() {
    $('.especialidad-checkbox:checked').each(function() {
        var $item = $(this).closest('.especialidad-item');
        $item.css('background-color', '#e8f5e8');
        $item.css('border', '1px solid #28a745');
    });
    actualizarContadorEspecialidades();
}

// Función para actualizar estilos visuales de especialidades
function actualizarEstilosEspecialidades() {
    $('.especialidad-item').each(function() {
        var checkbox = $(this).find('.especialidad-checkbox');
        if (checkbox.prop('checked')) {
            $(this).addClass('selected');
        } else {
            $(this).removeClass('selected');
        }
    });
}

// Función para inicializar las especialidades del docente
function inicializarEspecialidadesDocente() {
    actualizarContadorEspecialidades();

    var searchTerm = $('#especialidad-search').val();
    if (searchTerm) {
        filtrarEspecialidades(searchTerm);
    }

    $('.especialidad-checkbox').prop('disabled', false);
    actualizarEstilosEspecialidades();
}

// Función de inicialización para el formulario modal de estudiante
function initializeEstudianteModalForm() {
    // Inicializar opciones de currículas
    inicializarOpcionesCurriculas();

    // Inicializar filtro de currículas
    filtrarCurriculasPorEscuela();

    // Evento para filtrar currículas cuando cambia la escuela
    $('#estudiante_id_escuela').on('change', function() {
        filtrarCurriculasPorEscuela();
    });

    // Validación de email universitario
    $('#estudiante_emailUniversidad_username, #estudiante_emailUniversidad_domain').on('input change', function() {
        validarEmailUniversitarioRol('estudiante');
    });

    // Calcular año de egreso inmediatamente si ya hay un valor en año de ingreso
    var anioIngresoActual = parseInt($('#estudiante_anio_ingreso').val());
    if (!isNaN(anioIngresoActual) && anioIngresoActual >= 2000) {
        var anioEgresoCalculado = anioIngresoActual + 5;
        $('#estudiante_anio_egreso').val(anioEgresoCalculado);
        validarAnioEgreso($('#estudiante_anio_egreso'));
    }

    // Validación de año de ingreso con auto-cálculo inmediato de egreso
    $('#estudiante_anio_ingreso').on('input change blur', function() {
        validarAnioIngreso($(this));

        // Auto-cálculo inmediato de año de egreso cuando cambia el año de ingreso
        var anioIngreso = parseInt($(this).val());
        if (!isNaN(anioIngreso) && anioIngreso >= 2000 && anioIngreso <= new Date().getFullYear() + 5) {
            var anioEgreso = anioIngreso + 5;
            $('#estudiante_anio_egreso').val(anioEgreso);
            // Revalidar el año de egreso
            validarAnioEgreso($('#estudiante_anio_egreso'));
        }
    });

    // Validación de año de egreso
    $('#estudiante_anio_egreso').on('input change', function() {
        validarAnioEgreso($(this));
    });
}

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

// Función de inicialización para el formulario modal de docente
function initializeDocenteModalForm() {
    // Inicializar contador de especialidades seleccionadas
    function actualizarContadorEspecialidades() {
        var seleccionadas = $('.especialidad-checkbox:checked').length;
        $('#especialidades-seleccionadas').text(seleccionadas);

        // Marcar visualmente las especialidades seleccionadas
        $('.especialidad-item').each(function() {
            var checkbox = $(this).find('.especialidad-checkbox');
            if (checkbox.is(':checked')) {
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }
        });
    }

    // Función para filtrar especialidades
    function filtrarEspecialidades(searchTerm) {
        var term = searchTerm.toLowerCase().trim();
        var $items = $('.especialidad-item');
        var visibleCount = 0;

        $items.each(function() {
            var $item = $(this);
            var nombre = $item.data('nombre') || '';
            var isVisible = term === '' || nombre.includes(term);

            $item.toggle(isVisible);
            if (isVisible) visibleCount++;
        });

        // Actualizar contador
        $('#especialidades-total').text(visibleCount + ' de ' + $items.length);
    }

    // Función para seleccionar todas las especialidades
    window.seleccionarTodasEspecialidades = function() {
        $('.especialidad-checkbox').prop('checked', true);
        actualizarContadorEspecialidades();
    };

    // Función para deseleccionar todas las especialidades
    window.deseleccionarTodasEspecialidades = function() {
        $('.especialidad-checkbox').prop('checked', false);
        actualizarContadorEspecialidades();
    };

    // Evento para búsqueda de especialidades
    $(document).on('input', '#especialidad-search', function() {
        var searchTerm = $(this).val();
        filtrarEspecialidades(searchTerm);
    });

    // Evento para cambio en checkboxes de especialidades
    $(document).on('change', '.especialidad-checkbox', function() {
        actualizarContadorEspecialidades();
    });

    // Inicializar contador al cargar
    actualizarContadorEspecialidades();

    // Validación de email universitario
    $(document).on('input change', '#docente_emailUniversidad_username, #docente_emailUniversidad_domain', function() {
        var username = $('#docente_emailUniversidad_username').val().trim();
        var domain = $('#docente_emailUniversidad_domain').val();

        $('#docente_emailUniversidad_username').removeClass('is-valid is-invalid');
        $('#docente_emailUniversidad_domain').removeClass('is-valid is-invalid');
        $('#docente_emailHelp').hide();

        if (username === '' || domain === '') {
            return;
        }

        var emailCompleto = username + '@' + domain;

        if (!/^[a-zA-Z0-9._-]+@unitru\.edu\.pe$/.test(emailCompleto)) {
            $('#docente_emailUniversidad_username').addClass('is-invalid');
            $('#docente_emailUniversidad_domain').addClass('is-invalid');
            $('#docente_emailHelp').text('Formato de email inválido. Debe ser usuario@unitru.edu.pe').removeClass('text-success').addClass('text-danger').show();
        } else {
            $('#docente_emailUniversidad_username').addClass('is-valid');
            $('#docente_emailUniversidad_domain').addClass('is-valid');
            $('#docente_emailHelp').text('Email válido').removeClass('text-danger').addClass('text-success').show();
        }
    });

    // Validación de fecha de contratación
    $(document).on('change', '#docente_fecha_contratacion', function() {
        var fecha = $(this).val();
        $(this).removeClass('is-valid is-invalid');

        if (fecha === '') {
            return;
        }

        var fechaSeleccionada = new Date(fecha);
        var hoy = new Date();

        if (fechaSeleccionada > hoy) {
            $(this).addClass('is-invalid');
            $('#docente_fecha_contratacionHelp').text('La fecha no puede ser futura').removeClass('text-success').addClass('text-danger').show();
        } else {
            $(this).addClass('is-valid');
            $('#docente_fecha_contratacionHelp').hide();
        }
    });
}
