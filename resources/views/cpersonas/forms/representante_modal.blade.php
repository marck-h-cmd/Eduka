{{-- Formulario modal para representante - versión compacta --}}
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
</style>

<div class="modal-form-compact role-config-form">
    {{-- Información del representante --}}
    <div class="alert alert-info border-0 mb-4">
        <i class="fas fa-users fa-lg mr-3 float-left"></i>
        <strong>Rol de Representante Seleccionado</strong><br>
        <small>Este rol permite gestionar estudiantes a su cargo. No requiere configuración adicional específica.</small>
    </div>

    {{-- Estado --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="representante_estado" class="estilo-info">
                    Estado <span class="text-danger">*</span>
                    <i class="fas fa-toggle-on text-primary" title="Estado del representante en el sistema"></i>
                </label>
                <select name="representante[estado]" class="form-control @error('representante.estado') is-invalid @enderror"
                    id="representante_estado" style="border-color: #007bff;" required>
                    <option value="Activo" {{ old('representante.estado', 'Activo') == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ old('representante.estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
                <small class="form-text text-muted">Estado del representante en el sistema</small>
                @error('representante.estado')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
</div>
