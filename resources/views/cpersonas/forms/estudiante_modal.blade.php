{{-- Formulario modal para estudiante - versión compacta --}}
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

    /* Estilos de validación - bordes verdes para campos válidos */
    .modal-form-compact .form-control.is-valid {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }

    .modal-form-compact .input-group .form-control.is-valid {
        border-color: #28a745 !important;
    }

    .modal-form-compact .input-group .input-group-text {
        border-color: #28a745 !important;
    }

    .modal-form-compact .form-control.is-valid:focus {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }
</style>

{{-- Versión limpia del formulario para asignación de roles - sin valores pre-cargados --}}
<div class="modal-form-compact role-config-form">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="estudiante_emailUniversidad" class="estilo-info">
                Email Universitario * <i class="fas fa-info-circle text-info" title="Email institucional único para el estudiante"></i>
            </label>
            <div class="input-group">
                <input type="text" class="form-control @error('estudiante_emailUniversidad') is-invalid @enderror"
                    id="estudiante_emailUniversidad_username" name="estudiante_emailUniversidad_username"
                    value="{{ old('estudiante_emailUniversidad_username') }}"
                    style="border-color: #007bff;" placeholder="usuario" autocomplete="off">
                <div class="input-group-append">
                    <span class="input-group-text" style="border-color: #007bff; background-color: #f8f9fa;">@</span>
                </div>
                <select class="form-control @error('estudiante_emailUniversidad') is-invalid @enderror"
                    id="estudiante_emailUniversidad_domain" name="estudiante_emailUniversidad_domain"
                    style="border-color: #007bff;" required>
                    <option value="unitru.edu.pe" selected>unitru.edu.pe</option>
                </select>
            </div>
            <small class="form-text text-muted">Debe ser único en el sistema estudiantil</small>
            <small id="estudiante_emailHelp" class="form-text text-danger" style="display: none;"></small>
            @error('estudiante_emailUniversidad')
                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="estudiante_anio_ingreso" class="estilo-info">
                Año de Ingreso * <i class="fas fa-calendar-check text-success" title="Año en que inició sus estudios"></i>
            </label>
            <input type="number" class="form-control @error('estudiante.anio_ingreso') is-invalid @enderror"
                id="estudiante_anio_ingreso" name="estudiante[anio_ingreso]"
                value="{{ old('estudiante.anio_ingreso', date('Y')) }}"
                min="1900" max="{{ date('Y') + 10 }}" style="border-color: #007bff;" required>
            <small id="estudiante_anio_ingresoHelp" class="form-text text-danger" style="display: none;"></small>
            @error('estudiante.anio_ingreso')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="estudiante_anio_egreso" class="estilo-info">
                Año de Egreso <i class="fas fa-calendar-times text-warning" title="Año estimado de egreso (opcional)"></i>
            </label>
            <input type="number" class="form-control @error('estudiante.anio_egreso') is-invalid @enderror"
                id="estudiante_anio_egreso" name="estudiante[anio_egreso]"
                value="{{ old('estudiante.anio_egreso') }}"
                style="border-color: #007bff;" min="1900" max="{{ date('Y') + 20 }}">
            <small id="estudiante_anio_egresoHelp" class="form-text text-danger" style="display: none;"></small>
            @error('estudiante.anio_egreso')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="estudiante_id_escuela" class="estilo-info">
                Escuela <i class="fas fa-school text-primary" title="Escuela/facultad del estudiante"></i>
            </label>
            <select class="form-control @error('estudiante.id_escuela') is-invalid @enderror"
                id="estudiante_id_escuela" name="estudiante[id_escuela]" style="border-color: #007bff;">
                <option value="">Seleccionar escuela</option>
                @foreach ($escuelas as $escuela)
                    <option value="{{ $escuela->id_escuela }}"
                        {{ (old('estudiante_id_escuela') == $escuela->id_escuela) ? 'selected' : '' }}>
                        {{ $escuela->nombre }}
                    </option>
                @endforeach
            </select>
            @error('estudiante_id_escuela')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="estudiante_id_curricula" class="estilo-info">
                Currícula <i class="fas fa-book text-info" title="Currícula académica vigente de la escuela seleccionada"></i>
            </label>
            <select class="form-control @error('estudiante.id_curricula') is-invalid @enderror"
                id="estudiante_id_curricula" name="estudiante[id_curricula]" style="border-color: #007bff;">
                <option value="">Primero seleccione una escuela</option>
                @if(isset($curriculas))
                    @foreach ($curriculas as $curricula)
                        <option value="{{ $curricula->id_curricula }}"
                            data-escuela="{{ $curricula->id_escuela }}"
                            {{ (old('estudiante_id_curricula') == $curricula->id_curricula) ? 'selected' : '' }}>
                            {{ $curricula->escuela->nombre }} - {{ $curricula->nombre }} ({{ $curricula->anio_inicio }})
                        </option>
                    @endforeach
                @endif
            </select>
            <small class="form-text text-muted">Solo se muestran currículas vigentes de la escuela seleccionada</small>
            @error('estudiante_id_curricula')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>
</div>

<script>
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

    // Validación de año de ingreso
    $('#estudiante_anio_ingreso').on('input change', function() {
        validarAnioIngreso($(this));
    });

    // Validación de año de egreso
    $('#estudiante_anio_egreso').on('input change', function() {
        validarAnioEgreso($(this));
    });

    // Auto-cálculo de año de egreso cuando cambia el año de ingreso
    $('#estudiante_anio_ingreso').on('input change', function() {
        var anioIngreso = parseInt($(this).val());
        if (!isNaN(anioIngreso) && anioIngreso >= 2000) {
            var anioEgreso = anioIngreso + 5;
            $('#estudiante_anio_egreso').val(anioEgreso);
            // Revalidar el año de egreso
            validarAnioEgreso($('#estudiante_anio_egreso'));
        }
    });
}

// Hacer la función global para que pueda ser llamada desde el modal
window.initializeEstudianteModalForm = initializeEstudianteModalForm;

// Auto-inicializar si el script se carga directamente
$(document).ready(function() {
    initializeEstudianteModalForm();
});
</script>
