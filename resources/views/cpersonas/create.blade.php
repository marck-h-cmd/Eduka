@extends('cplantilla.bprincipal')
@section('titulo', 'Crear Nueva Persona')
@section('contenidoplantilla')
    <style>
        /* Estilos optimizados para la vista de creación */
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

        /* Estilos para botones optimizados */
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

        /* Estilos para validación visual optimizados */
        .is-valid {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        /* Responsive optimizado para roles */
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

        /* Loader optimizado */
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

        .spinner-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .circle {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            animation: float 1s infinite ease-in-out;
        }

        .c1 { background-color: #0A8CB3; animation-delay: 0s; }
        .c2 { background-color: #FF5A6A; animation-delay: 0.1s; }
        .c3 { background-color: #FFD700; animation-delay: 0.2s; }
        .c4 { background-color: #000000; animation-delay: 0.3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* Secciones de roles ocultas inicialmente */
        #role-fields-container { display: none; }
        .role-section { display: none; }

        /* Estilos para tarjetas de roles optimizados */
        .role-selector-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid #e9ecef !important;
            position: relative;
            overflow: hidden;
        }

        .role-selector-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
            border-color: #007bff !important;
        }

        .role-selector-card.selected {
            border-color: #28a745 !important;
            background: linear-gradient(135deg, #f8fff8 0%, #ffffff 100%) !important;
        }

        .role-icon {
            transition: all 0.3s ease;
        }

        .role-selector-card:hover .role-icon {
            transform: scale(1.1);
        }

        .role-status-badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
            transition: all 0.3s ease;
        }

        .role-checkmark {
            animation: checkmark-appear 0.3s ease;
        }

        @keyframes checkmark-appear {
            0% { opacity: 0; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* Paneles de configuración optimizados */
        .role-config-panel {
            animation: panel-slide-in 0.4s ease;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        @keyframes panel-slide-in {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .role-config-container {
            animation: container-fade-in 0.3s ease;
        }

        @keyframes container-fade-in {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Estilos para especialidades seleccionadas */
        .especialidad-item.selected {
            background-color: #e8f5e8 !important;
            border: 2px solid #28a745 !important;
            border-radius: 6px !important;
        }

        .especialidad-item.selected .form-check-label {
            font-weight: bold;
            color: #155724;
        }

        .especialidad-item.selected::before {
            content: "✓ ";
            color: #28a745;
            font-weight: bold;
            font-size: 1.1em;
        }

        /* Hover effect para especialidades */
        .especialidad-item:hover {
            background-color: #f8f9fa !important;
            border-color: #007bff !important;
        }

        /* Estilos para indicador de envío de credenciales */
        .dots-loading {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 15px;
        }

        .dots-loading .dot {
            width: 8px;
            height: 8px;
            background-color: #ffffff;
            border-radius: 50%;
            animation: dots-bounce 1.4s infinite ease-in-out both;
        }

        .dots-loading .dot:nth-child(1) { animation-delay: -0.32s; }
        .dots-loading .dot:nth-child(2) { animation-delay: -0.16s; }
        .dots-loading .dot:nth-child(3) { animation-delay: 0s; }

        @keyframes dots-bounce {
            0%, 80%, 100% {
                transform: scale(0);
                opacity: 0.5;
            }
            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Estilos para resaltar errores automáticamente */
        .error-highlight {
            animation: error-flash 0.6s ease-in-out;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.5) !important;
            border-color: #dc3545 !important;
        }

        @keyframes error-flash {
            0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.5); }
            50% { box-shadow: 0 0 0 6px rgba(220, 53, 69, 0.3); }
            100% { box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.5); }
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
                        <i class="fas fa-user-plus m-1"></i>&nbsp;Crear Nueva Persona
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>
                    <div class="card-body info">
                        <div class="d-flex ">
                            <div>
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                            <div class="p-2 flex-fill">
                                <p>
                                    En esta sección, podrás registrar una nueva persona en el sistema.
                                </p>
                                <p>
                                    Estimado Usuario: Completa todos los campos obligatorios marcados con (*) y verifica que
                                    la información sea correcta antes de guardar.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="collapse show" id="collapseExample0">
                        <div class="card card-body rounded-0 border-0 pt-0 pb-2"
                            style="background-color: #fcfffc !important">
                            <form action="{{ route('personas.store') }}" method="POST" id="personaForm" onsubmit="handleFormSubmit(event)">
                                @csrf
                                @include('cpersonas._form')



                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-center">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <button type="submit" class="btn btn-primary"
                                                style="width: 200px; height: 38px; padding: 6px 12px;">
                                                <i class="fas fa-save"></i> Guardar Persona
                                            </button>
                                            <button type="button"
                                                onclick="window.location.href='{{ route('personas.index') }}'"
                                                class="btn btn-secondary"
                                                style="width: 120px; height: 38px; padding: 6px 12px;">
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
        /**
         * Funciones de validación para formularios de personas
         */

        // Función para inicializar campos de roles
        function toggleRoleFields() {
            // Esta función inicializa los campos de roles al cargar la página
            console.log('Inicializando campos de roles...');
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

        // Función para mostrar indicador de envío de credenciales
        function showCredentialsLoading() {
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
                            <h4 class="text-white font-weight-bold">Enviando Credenciales</h4>
                            <p class="text-white mb-0">Se están enviando las credenciales al correo electrónico...</p>
                            <div class="mt-3">
                                <div class="dots-loading">
                                    <span class="dot">.</span>
                                    <span class="dot">.</span>
                                    <span class="dot">.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            if (contenido) contenido.style.opacity = '0.5';
        }

        // Función para manejar el envío del formulario
        function handleFormSubmit(event) {
            event.preventDefault();

            var username = $('#email_username').val().trim();
            var domain = $('#email_domain').val();

            // Si hay algo en el campo de usuario pero no hay dominio seleccionado
            if (username && !domain) {
                $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger')
                    .text('Debes seleccionar un dominio de email');
                $('#email_domain').addClass('is-invalid');
                $('#email_username').addClass('is-invalid');
                return false;
            }

            // Si hay dominio pero no hay usuario
            if (domain && !username) {
                $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger')
                    .text('Debes ingresar un nombre de usuario');
                $('#email_username').addClass('is-invalid');
                $('#email_domain').addClass('is-invalid');
                return false;
            }

            // Validar formularios de roles antes de enviar
            var rolesSeleccionados = $('input[name="roles[]"]:checked');
            var erroresRoles = [];

            rolesSeleccionados.each(function() {
                var roleId = $(this).val();
                var erroresRol = validarFormularioRol(roleId);
                if (erroresRol.length > 0) {
                    erroresRoles = erroresRoles.concat(erroresRol);
                }
            });

            // Si hay roles con errores, mostrar advertencia
            if (erroresRoles.length > 0) {
                var mensajeAdvertencia = 'Faltan datos requeridos para los siguientes roles:\n\n';
                mensajeAdvertencia += erroresRoles.join('\n');
                mensajeAdvertencia += '\n\nPor favor, completa los campos requeridos antes de guardar.';

                Swal.fire({
                    icon: 'warning',
                    title: 'Datos incompletos',
                    text: mensajeAdvertencia,
                    confirmButtonColor: '#007bff'
                });
                return false;
            }

            // Mostrar indicador apropiado según si hay roles asignados
            var hasRoles = rolesSeleccionados.length > 0;
            if (hasRoles) {
                showCredentialsLoading();
            } else {
                showLoading();
            }

            // Combinar campos de email antes de enviar
            rolesSeleccionados.each(function() {
                var roleId = $(this).val();
                var roleName = $('.role-selector-card[data-role-id="' + roleId + '"]').data('role-name');

                if (roleName === 'Docente') {
                    var username = $('#docente_emailUniversidad_username').val().trim();
                    var domain = $('#docente_emailUniversidad_domain').val();
                    if (username && domain) {
                        var combinedEmail = username + '@' + domain;
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'docente[emailUniversidad]',
                            value: combinedEmail
                        }).appendTo('#personaForm');
                    }
                } else if (roleName === 'Estudiante') {
                    var username = $('#estudiante_emailUniversidad_username').val().trim();
                    var domain = $('#estudiante_emailUniversidad_domain').val();
                    if (username && domain) {
                        var combinedEmail = username + '@' + domain;
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'estudiante[emailUniversidad]',
                            value: combinedEmail
                        }).appendTo('#personaForm');
                    }
                } else if (roleName === 'Secretaria') {
                    var username = $('#secretaria_emailUniversidad_username').val().trim();
                    var domain = $('#secretaria_emailUniversidad_domain').val();
                    if (username && domain) {
                        var combinedEmail = username + '@' + domain;
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'secretaria[emailUniversidad]',
                            value: combinedEmail
                        }).appendTo('#personaForm');
                    }
                }
            });

            // Enviar el formulario
            $('#personaForm')[0].submit();
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
            $.ajax({
                url: '/personas/verificar-email',
                type: 'GET',
                data: { email: email },
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
            mostrarMensajeErrorRol(tipo, 'Verificando disponibilidad del email...');

            $.ajax({
                url: '/personas/verificar-email-universitario',
                type: 'GET',
                data: {
                    email: email,
                    tipo: tipo
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

        // Función para actualizar contador de especialidades seleccionadas
        function actualizarContadorEspecialidades() {
            var seleccionadas = $('.especialidad-checkbox:checked').length;
            $('#especialidades-seleccionadas').text(seleccionadas);
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

        // Función para validar fecha de contratación
        function validarFechaContratacion($input) {
            var fecha = $input.val();

            $input.removeClass('is-valid is-invalid');

            if (fecha === '') {
                return;
            }

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

            if (isNaN(anio) || anio < 1900 || anio > anioActual + 5) {
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

            if (isNaN(anioEgreso) || anioEgreso < 1900 || anioEgreso > anioActual + 10) {
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

        // Función para hacer scroll automático suave
        function scrollToElement($element, offset = 120) {
            if ($element.length > 0) {
                var elementOffset = $element.offset().top - offset;
                $('html, body').animate({
                    scrollTop: elementOffset
                }, 600, 'swing');
            }
        }

        // Función para hacer scroll al primer error de validación
        function scrollToFirstError() {
            var $firstError = $('.is-invalid, .text-danger').first();
            if ($firstError.length > 0) {
                scrollToElement($firstError, 100);
                // Agregar un efecto de highlight temporal
                $firstError.addClass('error-highlight');
                setTimeout(function() {
                    $firstError.removeClass('error-highlight');
                }, 2000);
            }
        }

        // Función para hacer scroll a secciones enfocadas
        function scrollToFocusedSection() {
            // Scroll automático cuando se enfoca en campos específicos
            $('input, select, textarea').on('focus', function() {
                var $field = $(this);
                var fieldTop = $field.offset().top;
                var windowTop = $(window).scrollTop();
                var windowHeight = $(window).height();

                // Si el campo está cerca del borde inferior de la ventana, hacer scroll
                if (fieldTop > windowTop + windowHeight - 150) {
                    scrollToElement($field, 150);
                }
                // Si el campo está cerca del borde superior de la ventana, hacer scroll
                else if (fieldTop < windowTop + 150) {
                    scrollToElement($field, 150);
                }
            });
        }

        // Función para inicializar scroll automático inteligente
        function inicializarAutoScroll() {
            // Scroll a roles pre-seleccionados al cargar la página
            setTimeout(function() {
                var $selectedRoles = $('.role-selector-card.selected');
                if ($selectedRoles.length > 0) {
                    var $firstSelectedRole = $selectedRoles.first();
                    var roleName = $firstSelectedRole.data('role-name');
                    var $panel = $('#' + roleName.toLowerCase() + '-panel');

                    // Esperar a que el panel esté completamente visible
                    var checkPanelVisibility = function() {
                        if ($panel.is(':visible') && $panel.height() > 0) {
                            scrollToElement($panel, 120);
                        } else {
                            // Si no está visible aún, esperar un poco más
                            setTimeout(checkPanelVisibility, 200);
                        }
                    };
                    checkPanelVisibility();
                }
            }, 800); // Aumentar el timeout inicial

            // Scroll automático cuando se muestran errores
            @if ($errors->any())
                setTimeout(function() {
                    scrollToFirstError();
                }, 1000);
            @endif

            // Scroll automático cuando se expanden/colapsan secciones de roles
            inicializarScrollEnCollapse();
        }

        // Función para inicializar scroll en botones de collapse
        function inicializarScrollEnCollapse() {
            // Escuchar eventos de collapse en los paneles de roles
            $('.collapse').on('shown.bs.collapse', function() {
                var $collapse = $(this);
                var collapseId = $collapse.attr('id');

                // Solo hacer scroll si es un panel de rol
                if (collapseId && (collapseId.includes('docente') || collapseId.includes('estudiante') || collapseId.includes('secretaria'))) {
                    setTimeout(function() {
                        scrollToElement($collapse, 100);
                    }, 300); // Esperar a que termine la animación de Bootstrap
                }
            });
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

            // Scroll automático al panel del rol seleccionado
            setTimeout(function() {
                scrollToElement(panel, 120);
            }, 350); // Esperar a que el panel se abra completamente
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

        // Función para verificar Email
        function verificarEmail(email) {
            $.ajax({
                url: '{{ route('personas.verificarEmail') }}',
                type: 'GET',
                data: { email: email },
                success: function(response) {
                    if (response.existe) {
                        $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger').text(response.mensaje);
                        $('#email').addClass('is-invalid').removeClass('is-valid');
                    } else {
                        $('#emailHelp').removeClass('text-danger text-warning').addClass('text-success').text(response.mensaje);
                        $('#email').removeClass('is-invalid').addClass('is-valid');
                    }
                },
                error: function(xhr, status, error) {
                    $('#emailHelp').removeClass('text-success text-warning').addClass('text-danger').text('Error al verificar email.');
                    $('#email').addClass('is-invalid').removeClass('is-valid');
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

            $curriculaSelect.val('');

            if (!escuelaSeleccionada) {
                $curriculaSelect.html('<option value="">Primero seleccione una escuela</option>');
                return;
            }

            var opcionesFiltradas = '<option value="">Seleccionar currícula</option>';
            opcionesCurriculasOriginales.forEach(function(opcion) {
                if (opcion.escuela == escuelaSeleccionada) {
                    opcionesFiltradas += '<option value="' + opcion.value + '">' + opcion.text + '</option>';
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

        $(document).ready(function() {
            // Inicializar validaciones para la vista de creación
            inicializarValidacionCamposRequeridos();
            inicializarRolesSeleccionados();

            // Inicializar opciones de currículas
            inicializarOpcionesCurriculas();

            // Inicializar filtro de currículas
            filtrarCurriculasPorEscuela();

            // Inicializar scroll automático inteligente
            inicializarAutoScroll();
            scrollToFocusedSection();

            // Validación de DNI en tiempo real
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

            // Verificación de DNI
            $('#dni').on('blur', function() {
                var dni = $(this).val();
                if (dni.length === 8) {
                    verificarDni(dni);
                } else if (dni.length > 0) {
                    $('#dniHelp').removeClass('text-success').addClass('text-danger').text('El DNI debe contener exactamente 8 dígitos.');
                    $('#dni').addClass('is-invalid');
                }
            });

            // Combinación de email
            function combineEmail() {
                var username = $('#email_username').val().trim();
                var domain = $('#email_domain').val();
                if (username && domain) {
                    return username + '@' + domain;
                }
                return '';
            }

            // Validación de nombres y apellidos
            $('#nombres, #apellidos').on('input', function() {
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            });

            // Prevención de escritura de "@" en usuario
            $('#email_username').on('input', function() {
                this.value = this.value.replace(/@/g, '');
            });

            // Combinación de email en tiempo real
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

            // Validación de teléfono
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

            $('#telefono').on('blur', function() {
                var telefono = $(this).val();
                if (telefono.length > 0 && telefono.length !== 9) {
                    $('#telefonoHelp').removeClass('text-success text-warning').addClass('text-danger').text('El teléfono debe contener exactamente 9 dígitos');
                    $('#telefono').addClass('is-invalid').removeClass('is-valid');
                } else if (telefono.length === 9) {
                    $('#telefonoHelp').removeClass('text-danger text-warning').addClass('text-success').text('Teléfono válido');
                    $('#telefono').removeClass('is-invalid').addClass('is-valid');
                }
            });

            // Validación de fecha de nacimiento
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

            // Manejo de clics en tarjetas de rol
            $('.role-selector-card').on('click', function(e) {
                e.preventDefault();
                var roleId = $(this).data('role-id');
                var roleName = $(this).data('role-name');
                var checkbox = $('#role_checkbox_' + roleId);
                var isCurrentlySelected = checkbox.prop('checked');

                if (isCurrentlySelected) {
                    toggleRoleDeselect(roleId, roleName);
                } else {
                    toggleRoleSelect(roleId, roleName);
                }
            });

            // Validaciones en tiempo real para formularios de roles

            // Búsqueda en tiempo real de especialidades
            $(document).on('input', '#especialidad-search', function() {
                var searchTerm = $(this).val();
                filtrarEspecialidades(searchTerm);
            });

            // Validación para email universitario de docente
            $(document).on('input change', '#docente_emailUniversidad_username, #docente_emailUniversidad_domain', function() {
                validarEmailUniversitarioRol('docente');
            });

            // Validación para fecha de contratación de docente
            $(document).on('change', '#docente_fecha_contratacion', function() {
                validarFechaContratacion($(this));
                mostrarMensajeError($(this), validarFechaContratacionMensaje($(this)));
            });

            // Validación para especialidades de docente
            $(document).on('change', '.especialidad-checkbox', function() {
                var $item = $(this).closest('.especialidad-item');
                if ($(this).is(':checked')) {
                    $item.addClass('selected');
                } else {
                    $item.removeClass('selected');
                }
                validarEspecialidadesSeleccionadas();
                mostrarMensajeErrorEspecialidades();
                actualizarContadorEspecialidades();
            });

            // Validación para email universitario de estudiante
            $(document).on('input change', '#estudiante_emailUniversidad_username, #estudiante_emailUniversidad_domain', function() {
                validarEmailUniversitarioRol('estudiante');
            });

            // Validación para año de ingreso de estudiante
            $(document).on('input change', '#estudiante_anio_ingreso', function() {
                validarAnioIngreso($(this));
                var mensaje = validarAnioIngresoMensaje($(this));
                mostrarMensajeError($(this), mensaje);

                // Actualizar automáticamente el año de egreso (ingreso + 5 años)
                var anioIngreso = parseInt($(this).val());
                if (!isNaN(anioIngreso) && anioIngreso >= 1900) {
                    $('#estudiante_anio_egreso').val(anioIngreso + 5);
                    // Validar el año de egreso actualizado
                    validarAnioEgreso($('#estudiante_anio_egreso'));
                }
            });

            // Validación para año de egreso de estudiante
            $(document).on('input change', '#estudiante_anio_egreso', function() {
                validarAnioEgreso($(this));
                var mensaje = validarAnioEgresoMensaje($(this));
                mostrarMensajeError($(this), mensaje);
            });

            // Validación para email universitario de secretaria
            $(document).on('input change', '#secretaria_emailUniversidad_username, #secretaria_emailUniversidad_domain', function() {
                validarEmailUniversitarioRol('secretaria');
            });

            // Validación para fecha de ingreso de secretaria
            $(document).on('change', '#secretaria_fecha_ingreso', function() {
                validarFechaIngreso($(this));
                mostrarMensajeError($(this), validarFechaIngresoMensaje($(this)));
            });

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



            // Evento para filtrar currículas cuando cambia la escuela
            $(document).on('change', '#estudiante_id_escuela', function() {
                filtrarCurriculasPorEscuela();
            });
        });
    </script>
@endsection
