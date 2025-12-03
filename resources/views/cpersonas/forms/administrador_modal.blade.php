{{-- Formulario modal para administrador - versión compacta --}}
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
    {{-- Información del administrador --}}
    <div class="alert alert-warning border-0 mb-4">
        <i class="fas fa-info-circle fa-lg mr-3 float-left"></i>
        <strong>Rol de Administrador Seleccionado</strong><br>
        <small>Este rol otorga acceso completo al sistema administrativo. No requiere configuración adicional específica.</small>
    </div>

    {{-- Estado automático para administradores --}}
    <input type="hidden" name="administrador[estado]" value="Activo">
</div>
