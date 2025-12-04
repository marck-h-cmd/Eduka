{{-- Formulario modal para docente - usando el formulario original adaptado --}}
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

    /* Estilos para especialidades en modal */
    .modal-form-compact .especialidad-item {
        padding: 0.75rem;
        border-radius: 0.25rem;
        transition: all 0.2s ease;
        margin-bottom: 0.5rem;
        border: 1px solid #dee2e6;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }

    .modal-form-compact .especialidad-item:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
    }

    .modal-form-compact .especialidad-item.selected {
        background-color: #e8f5e8;
        border-color: #28a745;
    }

    .modal-form-compact .especialidad-item.selected .form-check-label {
        font-weight: bold;
        color: #155724;
    }

    /* Estilos responsive para especialidades */
    .modal-form-compact .especialidad-item .form-check-label {
        font-size: 0.85rem;
        line-height: 1.4;
        margin-bottom: 0.25rem;
    }

    .modal-form-compact .especialidad-item .form-check-label strong {
        display: block;
        margin-bottom: 0.25rem;
        word-break: break-word;
    }

    .modal-form-compact .especialidad-item .form-check-label small {
        display: block;
        font-size: 0.75rem;
        color: #6c757d;
        word-break: break-word;
        line-height: 1.3;
    }

    /* Contenedor de especialidades con scroll limitado para modal */
    .modal-form-compact #especialidades-container {
        max-height: 350px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.75rem;
    }

    /* Estilos para búsqueda de especialidades en modal */
    .modal-form-compact .input-group.mb-3 {
        margin-bottom: 0.75rem !important;
    }

    .modal-form-compact .input-group .input-group-text {
        font-size: 0.8rem;
    }

    .modal-form-compact .btn-outline-secondary {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }

    /* Estilos para contador de especialidades */
    .modal-form-compact .mb-2 small {
        font-size: 0.75rem;
        line-height: 1.4;
    }

    /* Estilos para botones de acciones rápidas */
    .modal-form-compact .mt-2 small .btn-link {
        font-size: 0.75rem;
        padding: 0.125rem 0.25rem;
    }

    /* Responsive para móviles */
    @media (max-width: 576px) {
        .modal-form-compact .especialidad-item {
            padding: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .modal-form-compact .especialidad-item .form-check-label {
            font-size: 0.8rem;
        }

        .modal-form-compact .especialidad-item .form-check-label small {
            font-size: 0.7rem;
        }

        .modal-form-compact #especialidades-container {
            max-height: 250px;
            padding: 0.5rem;
        }
    }
</style>

<div class="modal-form-compact role-config-form">
    {{-- Versión limpia del formulario para asignación de roles - sin valores pre-cargados --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="docente_emailUniversidad" class="estilo-info">
                    Email Universitario * <i class="fas fa-info-circle text-info" title="Email institucional único para el docente"></i>
                </label>
                <div class="input-group">
                    <input type="text" class="form-control @error('docente_emailUniversidad') is-invalid @enderror"
                        id="docente_emailUniversidad_username" name="docente_emailUniversidad_username"
                        value="{{ old('docente_emailUniversidad_username') }}"
                        style="border-color: #007bff;" placeholder="usuario" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text" style="border-color: #007bff; background-color: #f8f9fa;">@</span>
                    </div>
                    <select class="form-control @error('docente_emailUniversidad') is-invalid @enderror"
                        id="docente_emailUniversidad_domain" name="docente_emailUniversidad_domain"
                        style="border-color: #007bff;" required>
                        <option value="unitru.edu.pe" selected>unitru.edu.pe</option>
                    </select>
                </div>
                <small class="form-text text-muted">Debe ser único en el sistema docente</small>
                <small id="docente_emailHelp" class="form-text text-danger" style="display: none;"></small>
                @error('docente_emailUniversidad')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="docente_fecha_contratacion" class="estilo-info">
                    Fecha de Contratación <i class="fas fa-calendar-alt text-primary" title="Fecha en que inició su contrato docente"></i>
                </label>
                <input type="date" class="form-control @error('docente.fecha_contratacion') is-invalid @enderror"
                    id="docente_fecha_contratacion" name="docente[fecha_contratacion]"
                    value="{{ old('docente.fecha_contratacion') }}"
                    style="border-color: #007bff;">
                <small id="docente_fecha_contratacionHelp" class="form-text text-danger" style="display: none;"></small>
                @error('docente.fecha_contratacion')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="docente_especialidades" class="estilo-info">
                    Especialidades * <i class="fas fa-graduation-cap text-secondary" title="Áreas de especialización del docente"></i>
                </label>
                <small class="form-text text-muted mb-2">Selecciona una o más especialidades para este docente</small>

                <!-- Search/Filter Input -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="border-color: #007bff;"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control especialidad-search" placeholder="Buscar especialidad..."
                        style="border-color: #007bff;" id="especialidad-search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="$('#especialidad-search').val('').trigger('input');">
                            <i class="fas fa-times"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Specialities Counter -->
                <div class="mb-2">
                    <small class="text-muted">
                        <span id="especialidades-total">{{ $especialidades->count() }}</span> especialidades disponibles
                        <span class="float-right">
                            <span id="especialidades-seleccionadas">0</span> seleccionadas
                        </span>
                    </small>
                </div>

                <div class="border rounded" id="especialidades-container">
                    @foreach($especialidades as $especialidad)
                        <div class="form-check especialidad-item" data-nombre="{{ strtolower($especialidad->nombre) }}">
                            <input class="form-check-input especialidad-checkbox" type="checkbox"
                                name="docente[especialidades][]" value="{{ $especialidad->id_especialidad }}"
                                id="especialidad_{{ $especialidad->id_especialidad }}"
                                {{ in_array($especialidad->id_especialidad, old('docente.especialidades', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="especialidad_{{ $especialidad->id_especialidad }}">
                                <strong>{{ $especialidad->nombre }}</strong>
                                @if($especialidad->descripcion)
                                    <br><small class="text-muted">{{ $especialidad->descripcion }}</small>
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Quick Actions -->
                <div class="mt-2">
                    <small class="text-muted">
                        <button type="button" class="btn btn-link btn-sm p-0 text-primary" onclick="seleccionarTodasEspecialidades()">
                            <i class="fas fa-check-square"></i> Seleccionar todas
                        </button>
                        <span class="mx-2">|</span>
                        <button type="button" class="btn btn-link btn-sm p-0 text-secondary" onclick="deseleccionarTodasEspecialidades()">
                            <i class="fas fa-square"></i> Deseleccionar todas
                        </button>
                    </small>
                </div>

                @error('docente_especialidades')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                @error('docente_especialidades.*')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
</div>

<script>
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

// Hacer la función global para que pueda ser llamada desde el modal
window.initializeDocenteModalForm = initializeDocenteModalForm;

// Auto-inicializar si el script se carga directamente
$(document).ready(function() {
    initializeDocenteModalForm();
});
</script>
