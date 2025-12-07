@extends('cplantilla.bprincipal')
@section('titulo', 'Asignación de Roles')
@section('contenidoplantilla')
<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary { margin-top: 1rem; background: #007bff !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary:hover { background-color: #0056b3 !important; transform: scale(1.01); }
    .btn-success { background: #28a745 !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .btn-success:hover { background-color: #1e7e34 !important; transform: scale(1.01); }
    .table-custom tbody tr:nth-of-type(odd) { background-color: #f5f5f5; }
    .table-custom tbody tr:nth-of-type(even) { background-color: #e0e0e0; }
    .table-hover tbody tr:hover { background-color: #eeffe7 !important; }
    .pagination { display: flex; justify-content: left; padding: 1rem 0; list-style: none; gap: 0.3rem; }
    .pagination li a, .pagination li span { color: var(--color-principal); border: 1px solid var(--color-principal); padding: 6px 12px; border-radius: 4px; text-decoration: none; transition: all 0.2s ease; font-size: 0.9rem; }
    .pagination li a:hover, .pagination li span:hover { background-color: #f1f1f1; color: #333; }
    .pagination .page-item.active .page-link { background-color: #0A8CB3 !important; color: white !important; border-color: #000000 !important; }
    .pagination .disabled .page-link { color: #ccc; border-color: #ccc; }
    .role-selection { border: 2px solid #007bff; border-radius: 10px; padding: 15px; margin: 10px 0; background-color: #f8f9ff; }
    .role-checkbox { margin: 5px 0; }
    .select-all-container { background-color: #e3f2fd; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
    .role-tag { position: relative !important; }
    .role-assigned-container { position: relative !important; display: inline-block; }
    .remove-role-overlay {
        position: absolute !important;
        top: -3px !important;
        right: -3px !important;
        width: 18px !important;
        height: 18px !important;
        background: #dc3545 !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        border: 1px solid #fff !important;
        z-index: 5 !important;
    }
    .remove-role-overlay i {
        font-size: 10px !important;
        color: #fff !important;
        line-height: 1 !important;
    }
    .remove-role-overlay:hover {
        background: #c82333 !important;
    }
    .role-assigned-container .badge {
        border-radius: 3px !important; /* Cuadrado en lugar de redondeado */
    }
    #loaderPrincipal[style*="display: flex"] { display: flex !important; justify-content: center; align-items: center; position: absolute !important; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: 2000; }
    .modal-loader { position: absolute !important; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.9); display: flex; justify-content: center; align-items: center; z-index: 1050; }
    .modal-loader .spinner-border { width: 3rem; height: 3rem; }
    .btn-loading { position: relative; color: transparent !important; }
    .btn-loading::after { content: ""; position: absolute; width: 16px; height: 16px; top: 50%; left: 50%; margin-left: -8px; margin-top: -8px; border: 2px solid #ffffff; border-radius: 50%; border-top-color: transparent; animation: spin 1s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }
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
                    <i class="fas fa-user-tag m-1"></i>&nbsp;Asignación de Roles
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex ">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>
                                En esta sección, podrás asignar roles a las personas registradas en el sistema.
                            </p>
                            <p>
                                Estimado Usuario: Haz clic en el botón "+" de cada rol para asignarlo individualmente a las personas. Al asignar el primer rol a una persona, se creará automáticamente una cuenta de usuario.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2" style="background-color: #fcfffc !important">
                        {{-- Formulario eliminado - ahora solo asignación individual --}}

                            {{-- Advanced AJAX Filters and Search Bar --}}
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                            <div class="row align-items-end">
                                                <!-- Search Type Selector -->
                                                <div class="col-md-2 mb-3 mb-md-0">
                                                    <label for="tipoBusqueda" class="form-label fw-bold text-primary">
                                                        <i class="fas fa-filter me-1"></i>Buscar por
                                                    </label>
                                                    <select name="tipo_busqueda" id="tipoBusqueda" class="form-control" style="border-color: #007bff;">
                                                        <option value="nombre" {{ request('tipo_busqueda', 'nombre') == 'nombre' ? 'selected' : '' }}>Nombre</option>
                                                        <option value="dni" {{ request('tipo_busqueda') == 'dni' ? 'selected' : '' }}>DNI</option>
                                                        <option value="email" {{ request('tipo_busqueda') == 'email' ? 'selected' : '' }}>Email</option>
                                                    </select>
                                                </div>

                                                <!-- Search Input -->
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <label for="inputBuscar" class="form-label fw-bold text-primary">
                                                        <i class="fas fa-search me-1"></i>Buscar Persona
                                                    </label>
                                                    <input name="buscarpor" id="inputBuscar" class="form-control"
                                                           type="search" placeholder="Ingrese el término de búsqueda..."
                                                           aria-label="Search" autocomplete="off"
                                                           style="border-color: #007bff;" value="{{ $buscarpor }}">
                                                </div>

                                                <!-- Role Filter -->
                                                <div class="col-md-3 mb-3 mb-md-0">
                                                    <label for="rolFiltro" class="form-label fw-bold text-info">
                                                        <i class="fas fa-user-tag me-1"></i>Filtrar por Rol
                                                    </label>
                                                    <select name="rol_filtro" id="rolFiltro" class="form-control" style="border-color: #17a2b8;">
                                                        <option value="">Todos los roles</option>
                                                        <option value="sin_roles" {{ $rol_filtro == 'sin_roles' ? 'selected' : '' }}>Sin roles asignados</option>
                                                        @foreach($roles as $rol)
                                                            <option value="{{ $rol->id_rol }}" {{ $rol_filtro == $rol->id_rol ? 'selected' : '' }}>
                                                                {{ $rol->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="col-md-3 mb-3 mb-md-0">
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-outline-secondary" id="btnLimpiar">
                                                            <i class="fas fa-times me-1"></i>Limpiar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Active Filters Display -->
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div id="activeFilters" class="d-flex flex-wrap gap-2" style="display: none;">
                                                        <small class="text-muted me-2"><i class="fas fa-filter me-1"></i>Filtros activos:</small>
                                                        <!-- Active filter badges will be added here by JavaScript -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            {{-- AJAX Role Assignment Table --}}
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead class="bg-primary text-white">
                                                        <tr>
                                                            <th class="border-0" style="width: 60px;">ID</th>
                                                            <th class="border-0">Persona</th>
                                                            <th class="border-0" style="width: 100px;">DNI</th>
                                                            <th class="border-0 text-center" style="width: 150px;">Roles Asignados</th>
                                                            @foreach($roles as $rol)
                                                                <th class="border-0 text-center" style="width: 120px;">
                                                                    <div class="text-center">
                                                                        @if ($rol->nombre == 'Administrador')
                                                                            <i class="fas fa-crown text-warning d-block mb-1"></i>
                                                                        @elseif($rol->nombre == 'Docente')
                                                                            <i class="fas fa-chalkboard-teacher text-info d-block mb-1"></i>
                                                                        @elseif($rol->nombre == 'Estudiante')
                                                                            <i class="fas fa-user-graduate text-success d-block mb-1"></i>
                                                                        @elseif($rol->nombre == 'Secretaria')
                                                                            <i class="fas fa-user-tie text-secondary d-block mb-1"></i>
                                                                        @elseif($rol->nombre == 'Representante')
                                                                            <i class="fas fa-user-friends text-primary d-block mb-1"></i>
                                                                        @else
                                                                            <i class="fas fa-user-tag text-secondary d-block mb-1"></i>
                                                                        @endif
                                                                        <small class="font-weight-bold">{{ $rol->nombre }}</small>
                                                                    </div>
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody id="personasTableBody">
                                                        @forelse($personasSinRoles as $persona)
                                                            <tr class="persona-row" data-persona-id="{{ $persona->id_persona }}">
                                                                <td class="font-weight-bold align-middle">{{ $persona->id_persona }}</td>
                                                                <td class="align-middle">
                                                                    <strong>{{ $persona->nombres }} {{ $persona->apellidos }}</strong>
                                                                    <br><small class="text-muted">{{ $persona->email ?: 'Sin email' }}</small>
                                                                </td>
                                                                <td class="align-middle">{{ $persona->dni }}</td>
                                                                <td class="text-center align-middle">
                                                                    @if($persona->roles->count() > 0)
                                                                        <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                                            @foreach($persona->roles as $rol)
                                                                                @php
                                                                                    $iconClass = '';
                                                                                    switch($rol->nombre) {
                                                                                        case 'Administrador': $iconClass = 'fas fa-crown text-warning'; break;
                                                                                        case 'Docente': $iconClass = 'fas fa-chalkboard-teacher text-info'; break;
                                                                                        case 'Estudiante': $iconClass = 'fas fa-user-graduate text-success'; break;
                                                                                        case 'Secretaria': $iconClass = 'fas fa-user-tie text-secondary'; break;
                                                                                        case 'Representante': $iconClass = 'fas fa-user-friends text-primary'; break;
                                                                                        default: $iconClass = 'fas fa-user-tag text-secondary'; break;
                                                                                    }
                                                                                @endphp
                                                                                <span class="badge badge-info d-inline-flex align-items-center" style="font-size: 0.75rem;">
                                                                                    <i class="{{ $iconClass }} me-1"></i>{{ $rol->nombre }}
                                                                                </span>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        <span class="badge badge-secondary">Sin roles</span>
                                                                    @endif
                                                                </td>
                                                                @foreach($roles as $rol)
                                                                    <td class="text-center align-middle">
                                                                        <div class="role-assignment-container" data-persona-id="{{ $persona->id_persona }}" data-role-id="{{ $rol->id_rol }}">
                                                                            @if($persona->roles->contains('id_rol', $rol->id_rol))
                                                                                <div class="role-assigned-container">
                                                                                    <span class="badge badge-success px-3 py-2" title="Rol asignado" style="font-size: 14px; min-width: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                                                        <i class="fas fa-check"></i>
                                                                                    </span>
                                                                                    <div class="remove-role-overlay remove-role-btn" title="Quitar rol {{ $rol->nombre }}">
                                                                                        <i class="fas fa-times"></i>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <button type="button" class="btn btn-sm btn-outline-primary assign-role-btn" title="Asignar rol {{ $rol->nombre }}">
                                                                                    <i class="fas fa-plus"></i>
                                                                                </button>
                                                                            @endif
                                                                            <div class="role-form-container mt-2" style="display: none;">
                                                                                <!-- Form will be loaded here -->
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="{{ 4 + $roles->count() }}" class="text-center py-4">
                                                                    <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                                                    <h5 class="text-muted">No hay personas registradas</h5>
                                                                    <p class="text-muted">No se encontraron personas que coincidan con la búsqueda.</p>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- AJAX Pagination --}}
                            <div id="paginationContainer">
                                {{ $personasSinRoles->appends(request()->query())->links() }}
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Role Configuration Modal --}}
    <div class="modal fade" id="configureRoleModal" tabindex="-1" role="dialog" aria-labelledby="configureRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="configureRoleModalLabel">
                        <i class="fas fa-cog mr-2"></i>
                        Configurar Rol - <span id="modalPersonaName"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto; padding: 1.5rem;">
                    <div id="roleConfigurationContent">
                        <!-- Role configuration forms will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cerrar
                    </button>
                    <button type="button" class="btn btn-success" id="saveRoleConfiguration">
                        <i class="fas fa-save mr-1"></i>Guardar Configuración
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/persona-validation.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded - initializing role assignment');

        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        const saveBtn = document.getElementById('saveRoleConfiguration');
        console.log('Save button found:', saveBtn);

        const roleAssignmentForm = document.getElementById('roleAssignmentForm');









        // Save role configuration from modal and assign role
        document.getElementById('saveRoleConfiguration').addEventListener('click', function() {
            console.log('Save button clicked');

            const personaId = this.getAttribute('data-persona-id');
            const roleId = this.getAttribute('data-role-id');
            const roleName = this.getAttribute('data-role-name');

            console.log('Persona ID:', personaId, 'Role ID:', roleId, 'Role Name:', roleName);

            const form = document.querySelector('.role-config-form');
            console.log('Form found:', form);

            // Validate form if it exists
            if (form) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos requeridos',
                        text: 'Por favor complete todos los campos obligatorios.',
                        confirmButtonColor: '#007bff'
                    });
                    return;
                }
            }

            // Show confirmation message based on role
            let confirmTitle = 'Confirmar asignación de rol';
            let confirmText = `¿Está seguro de asignar el rol "${roleName}" a esta persona?`;

            if (roleName === 'Administrador') {
                confirmTitle = '⚠️ Confirmar acceso total al sistema';
                confirmText = `¡ATENCIÓN! Está a punto de otorgar acceso TOTAL al sistema como Administrador. Esta persona tendrá control completo sobre todas las funciones del sistema.\n\n¿Está completamente seguro de continuar?`;
            }

            Swal.fire({
                icon: roleName === 'Administrador' ? 'warning' : 'question',
                title: confirmTitle,
                html: confirmText,
                confirmButtonText: 'Sí, asignar rol',
                cancelButtonText: 'Cancelar',
                showCancelButton: true,
                confirmButtonColor: roleName === 'Administrador' ? '#dc3545' : '#28a745',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading indicators
                    if (loader) loader.style.display = 'flex';

                    // Disable modal buttons and show loading state
                    const modal = document.getElementById('configureRoleModal');
                    const saveBtn = document.getElementById('saveRoleConfiguration');
                    const cancelBtn = modal.querySelector('.btn-secondary');

                    // Disable buttons
                    saveBtn.disabled = true;
                    cancelBtn.disabled = true;

                    // Add loading spinner to save button
                    saveBtn.classList.add('btn-loading');
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Procesando...';

                    // Add loading overlay to modal
                    const modalContent = modal.querySelector('.modal-content');
                    const loadingOverlay = document.createElement('div');
                    loadingOverlay.className = 'modal-loader';
                    loadingOverlay.innerHTML = `
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                            <div class="mt-2">
                                <strong>Procesando...</strong>
                                <br>
                                <small class="text-muted">Por favor espere</small>
                            </div>
                        </div>
                    `;
                    modalContent.appendChild(loadingOverlay);

                    // Collect form data manually to ensure proper structure
                    const configData = {};
                    if (form) {
                        // Get all form inputs
                        const inputs = form.querySelectorAll('input, select, textarea');
                        console.log('Found inputs:', inputs.length);

                        // Specifically log checkbox inputs
                        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
                        console.log('Found checkboxes:', checkboxes.length);
                        checkboxes.forEach(cb => {
                            console.log('Checkbox:', cb.name, cb.value, cb.checked, cb.id);
                        });

                        inputs.forEach(input => {
                            console.log('Processing input:', input.name, input.value, input.type, input.checked);
                            if (input.name && input.value) {
                                // Parse array notation like "docente[especialidades][]" or "secretaria[emailUniversidad_username]"
                                const bracketStart = input.name.indexOf('[');
                                const bracketEnd = input.name.indexOf(']', bracketStart);
                                if (bracketStart !== -1 && bracketEnd !== -1 && bracketEnd > bracketStart) {
                                    const prefix = input.name.substring(0, bracketStart);
                                    // Check if this is an array field (ends with [])
                                    const hasArrayBrackets = input.name.substring(bracketEnd + 1, bracketEnd + 3) === '[]';
                                    const fieldEnd = hasArrayBrackets ? bracketEnd + 3 : bracketEnd;
                                    const fieldWithBrackets = input.name.substring(bracketStart + 1, fieldEnd);
                                    const isArray = fieldWithBrackets.endsWith('[]');
                                    const field = isArray ? fieldWithBrackets.slice(0, -2) : fieldWithBrackets;

                                    if (!configData[prefix]) {
                                        configData[prefix] = {};
                                    }

                                    // Handle array fields
                                    if (isArray) {
                                        if (!configData[prefix][field]) {
                                            configData[prefix][field] = [];
                                        }
                                        // Only add if it's a checked checkbox or has value
                                        if (input.type === 'checkbox' && input.checked) {
                                            configData[prefix][field].push(input.value);
                                            console.log('Added checkbox value to array:', field, input.value);
                                        } else if (input.type !== 'checkbox') {
                                            configData[prefix][field].push(input.value);
                                            console.log('Added non-checkbox value to array:', field, input.value);
                                        }
                                    } else {
                                        // Regular field
                                        configData[prefix][field] = input.value;
                                        console.log('Set regular field:', prefix, field, input.value);
                                    }
                                } else {
                                    configData[input.name] = input.value;
                                    console.log('Set top-level field:', input.name, input.value);
                                }
                            }
                        });
                    }

                    // Debug: log collected data
                    console.log('Collected configData:', configData);
                    console.log('Final configData to send:', JSON.stringify(configData));

                    // Send assignment request
                    fetch('/asignacion-roles/asignar-rol', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            persona_id: personaId,
                            role_id: roleId,
                            config_data: configData
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide all loading indicators
                        if (loader) loader.style.display = 'none';

                        // Reset modal buttons and remove loading overlay
                        const modal = document.getElementById('configureRoleModal');
                        const saveBtn = document.getElementById('saveRoleConfiguration');
                        const cancelBtn = modal.querySelector('.btn-secondary');

                        // Re-enable buttons
                        saveBtn.disabled = false;
                        cancelBtn.disabled = false;

                        // Remove loading spinner from save button
                        saveBtn.classList.remove('btn-loading');
                        saveBtn.innerHTML = '<i class="fas fa-save mr-1"></i>Guardar Configuración';

                        // Remove loading overlay from modal
                        const loadingOverlay = modal.querySelector('.modal-loader');
                        if (loadingOverlay) {
                            loadingOverlay.remove();
                        }

                        if (data.success) {
                            // Find the container in the table and update it
                            const container = document.querySelector(`[data-persona-id="${personaId}"][data-role-id="${roleId}"]`);
                            if (container) {
                                const checkbox = container.querySelector('.role-checkbox');
                                const assignBtn = container.querySelector('.assign-role-btn');

                                if (checkbox && assignBtn) {
                                    checkbox.checked = true;
                                    checkbox.style.display = 'inline-block';
                                    assignBtn.style.display = 'none';
                                }
                            }

                            // Close modal
                            $('#configureRoleModal').modal('hide');

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Rol asignado exitosamente',
                                html: data.message || `El rol "${roleName}" ha sido asignado correctamente.`,
                                confirmButtonColor: '#007bff',
                                timer: 3000,
                                timerProgressBar: true
                            });

                            // Update table row via AJAX instead of reloading page
                            setTimeout(() => {
                                // Update the specific row in the table
                                const row = container.closest('tr');
                                const rolesCell = row.cells[3]; // Roles column

                                // Update roles display
                                const currentRoles = @json($roles->pluck('nombre', 'id_rol'));
                                const roleName = currentRoles[roleId];

                                let rolesHtml = '';
                                if (rolesCell.querySelector('.badge-secondary')) {
                                    // No roles before, replace with first role
                                    rolesHtml = `<div class="d-flex flex-wrap gap-1 justify-content-center">
                                        <span class="badge badge-info d-inline-flex align-items-center" style="font-size: 0.75rem;">
                                            <i class="fas fa-user-tag me-1"></i>${roleName}
                                        </span>
                                    </div>`;
                                } else {
                                    // Add to existing roles
                                    const existingRolesDiv = rolesCell.querySelector('.d-flex');
                                    const newRoleBadge = document.createElement('span');
                                    newRoleBadge.className = 'badge badge-info d-inline-flex align-items-center';
                                    newRoleBadge.style.fontSize = '0.75rem';
                                    newRoleBadge.innerHTML = `<i class="fas fa-user-tag me-1"></i>${roleName}`;
                                    existingRolesDiv.appendChild(newRoleBadge);
                                }

                                // Update the button to show as assigned with badge and overlay
                                container.innerHTML = `
                                    <div class="role-assigned-container">
                                        <span class="badge badge-success px-3 py-2" title="Rol asignado" style="font-size: 14px; min-width: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <div class="remove-role-overlay remove-role-btn" title="Quitar rol ${roleName}">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                    <div class="role-form-container mt-2" style="display: none;">
                                        <!-- Form will be loaded here -->
                                    </div>
                                `;
                            }, 1500);
                        } else {
                            throw new Error(data.message || 'Error al asignar el rol');
                        }
                    })
                    .catch(error => {
                        // Hide all loading indicators
                        if (loader) loader.style.display = 'none';

                        // Reset modal buttons and remove loading overlay
                        const modal = document.getElementById('configureRoleModal');
                        const saveBtn = document.getElementById('saveRoleConfiguration');
                        const cancelBtn = modal.querySelector('.btn-secondary');

                        // Re-enable buttons
                        saveBtn.disabled = false;
                        cancelBtn.disabled = false;

                        // Remove loading spinner from save button
                        saveBtn.classList.remove('btn-loading');
                        saveBtn.innerHTML = '<i class="fas fa-save mr-1"></i>Guardar Configuración';

                        // Remove loading overlay from modal
                        const loadingOverlay = modal.querySelector('.modal-loader');
                        if (loadingOverlay) {
                            loadingOverlay.remove();
                        }

                        console.error('Error assigning role:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Error al asignar el rol. Por favor, inténtelo de nuevo.',
                            confirmButtonColor: '#007bff'
                        });
                    });
                }
            });
        });





        // Form submission handler - REMOVED (now only individual assignment)

        // Mostrar mensajes de éxito o error con SweetAlert2
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#007bff',
                timer: 5000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session("error") }}',
                confirmButtonColor: '#007bff'
            });
        @endif

        // Mostrar errores de validación
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

        // Handle assign role button clicks
        document.addEventListener('click', function(e) {
            // Check if the clicked element or its parent has the assign-role-btn class
            const assignBtn = e.target.closest('.assign-role-btn');
            if (assignBtn) {
                const container = assignBtn.closest('.role-assignment-container');
                const personaId = container.dataset.personaId;
                const roleId = container.dataset.roleId;

                // Get role name from the table header
                const roleMap = @json($roles->pluck('nombre', 'id_rol'));
                const roleName = roleMap[roleId] || 'Rol desconocido';

                // Show the form for this role
                showRoleForm(container, personaId, roleId, roleName);
            }

            // Check if the clicked element or its parent has the remove-role-btn class
            const removeBtn = e.target.closest('.remove-role-btn');
            if (removeBtn) {
                const container = removeBtn.closest('.role-assignment-container');
                const personaId = container.dataset.personaId;
                const roleId = container.dataset.roleId;

                // Get role name from the table header
                const roleMap = @json($roles->pluck('nombre', 'id_rol'));
                const roleName = roleMap[roleId] || 'Rol desconocido';

                // Get person name for confirmation
                const row = container.closest('tr');
                const personNameCell = row.cells[1];
                const personName = personNameCell.querySelector('strong').textContent.trim();

                // Show confirmation dialog
                Swal.fire({
                    icon: 'warning',
                    title: `Quitar rol "${roleName}"`,
                    text: `¿Confirmar quitar el rol a ${personName}?`,
                    confirmButtonText: 'Quitar',
                    cancelButtonText: 'Cancelar',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        if (loader) loader.style.display = 'flex';

                        // Send remove role request
                        fetch('/asignacion-roles/desasignar-rol', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                persona_id: personaId,
                                role_id: roleId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Hide loader
                            if (loader) loader.style.display = 'none';

                            if (data.success) {
                                // Update the container to show assign button
                                container.innerHTML = `
                                    <button type="button" class="btn btn-sm btn-outline-primary assign-role-btn" title="Asignar rol ${roleName}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <div class="role-form-container mt-2" style="display: none;">
                                        <!-- Form will be loaded here -->
                                    </div>
                                `;

                                // Update roles display in the roles column
                                const rolesCell = row.cells[3];
                                const currentRoles = @json($roles->pluck('nombre', 'id_rol'));
                                const roleNameToRemove = currentRoles[roleId];

                                // Find and remove the role badge
                                const roleBadges = rolesCell.querySelectorAll('.badge');
                                roleBadges.forEach(badge => {
                                    if (badge.textContent.includes(roleNameToRemove)) {
                                        badge.remove();
                                    }
                                });

                                // If no roles left, show "Sin roles" message
                                const remainingBadges = rolesCell.querySelectorAll('.badge');
                                if (remainingBadges.length === 0 || (remainingBadges.length === 1 && remainingBadges[0].classList.contains('badge-secondary'))) {
                                    rolesCell.innerHTML = '<span class="badge badge-secondary">Sin roles</span>';
                                }

                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Rol desasignado',
                                    html: data.message || `El rol "${roleName}" ha sido removido correctamente.`,
                                    confirmButtonColor: '#007bff',
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            } else {
                                throw new Error(data.message || 'Error al desasignar el rol');
                            }
                        })
                        .catch(error => {
                            // Hide loader
                            if (loader) loader.style.display = 'none';

                            console.error('Error removing role:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message || 'Error al desasignar el rol. Por favor, inténtelo de nuevo.',
                                confirmButtonColor: '#007bff'
                            });
                        });
                    }
                });
            }
        });

        // Function to show role configuration form in modal
        function showRoleForm(container, personaId, roleId, roleName) {
            const assignBtn = container.querySelector('.assign-role-btn');

            if (!assignBtn) {
                console.error('Assign button not found');
                return;
            }

            // Get person name for modal title
            const row = container.closest('tr');
            const personNameCell = row.cells[1];
            const personName = personNameCell.querySelector('strong').textContent.trim();

            // Set modal title
            document.getElementById('configureRoleModalLabel').innerHTML = `
                <i class="fas fa-user-tag mr-2"></i>
                Configurar ${roleName} - ${personName}
            `;

            // Load form content into modal via AJAX
            const modalBody = document.querySelector('#configureRoleModal .modal-body');
            modalBody.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando formulario...</div>';

            // Make AJAX request to load the form
            fetch(`/asignacion-roles/get-form/${roleId}/${personaId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                modalBody.innerHTML = html;

                // Update modal footer buttons with data attributes
                const saveBtn = document.getElementById('saveRoleConfiguration');
                const cancelBtn = document.querySelector('#configureRoleModal .btn-secondary');

                saveBtn.setAttribute('data-persona-id', personaId);
                saveBtn.setAttribute('data-role-id', roleId);
                saveBtn.setAttribute('data-role-name', roleName);
                saveBtn.setAttribute('data-container-selector', `[data-persona-id="${personaId}"][data-role-id="${roleId}"]`);

                cancelBtn.setAttribute('data-persona-id', personaId);
                cancelBtn.setAttribute('data-role-id', roleId);
                cancelBtn.setAttribute('data-container-selector', `[data-persona-id="${personaId}"][data-role-id="${roleId}"]`);

                // Show modal
                $('#configureRoleModal').modal('show');

                // Execute any JavaScript that might be in the loaded content
                // This ensures that form-specific JavaScript runs after the modal is shown
                setTimeout(() => {
                    // Trigger any initialization that might be needed
                    if (roleName === 'Estudiante' && typeof initializeEstudianteModalForm === 'function') {
                        initializeEstudianteModalForm();
                    } else if (roleName === 'Docente' && typeof initializeDocenteModalForm === 'function') {
                        initializeDocenteModalForm();
                    } else if (roleName === 'Secretaria' && typeof initializeSecretariaModalForm === 'function') {
                        initializeSecretariaModalForm();
                    } else if (typeof initializeFormScripts === 'function') {
                        initializeFormScripts();
                    }
                }, 100);
            })
            .catch(error => {
                console.error('Error loading form:', error);
                modalBody.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        Error al cargar el formulario. Por favor, inténtelo de nuevo.
                    </div>
                `;
            });
        }





        // AJAX Search and Filtering Functionality
        let searchTimeout;

        // Function to perform AJAX search
        function performAjaxSearch(page = 1) {
            const searchTerm = document.getElementById('inputBuscar').value.trim();
            const tipoBusqueda = document.getElementById('tipoBusqueda').value;
            const rolFiltro = document.getElementById('rolFiltro').value;

            // Show loading
            if (loader) loader.style.display = 'flex';

            // Prepare data for AJAX request
            const ajaxData = {
                buscarpor: searchTerm,
                tipo_busqueda: tipoBusqueda,
                rol_filtro: rolFiltro,
                page: page
            };

            // Make AJAX request
            fetch('/asignacion-roles/ajax-search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(ajaxData)
            })
            .then(response => response.json())
            .then(data => {
                // Hide loader
                if (loader) loader.style.display = 'none';

                if (data.html) {
                    // Update table body
                    document.getElementById('personasTableBody').innerHTML = data.html;

                    // Update pagination
                    document.getElementById('paginationContainer').innerHTML = data.pagination;

                    // Update URL without reloading
                    const params = new URLSearchParams();
                    if (searchTerm) params.append('buscarpor', searchTerm);
                    if (tipoBusqueda && tipoBusqueda !== 'nombre') params.append('tipo_busqueda', tipoBusqueda);
                    if (rolFiltro) params.append('rol_filtro', rolFiltro);
                    if (page > 1) params.append('page', page);

                    const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
                    window.history.pushState({}, '', newUrl);

                    // Update active filters display
                    updateActiveFilters();
                } else {
                    console.error('No HTML data received');
                }
            })
            .catch(error => {
                // Hide loader
                if (loader) loader.style.display = 'none';

                console.error('Error performing AJAX search:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al realizar la búsqueda. Por favor, inténtelo de nuevo.',
                    confirmButtonColor: '#007bff'
                });
            });
        }

        // Search input with debounce
        document.getElementById('inputBuscar').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performAjaxSearch();
            }, 500);
        });

        // Filter select changes
        document.getElementById('tipoBusqueda').addEventListener('change', function() {
            performAjaxSearch();
        });
        document.getElementById('rolFiltro').addEventListener('change', function() {
            performAjaxSearch();
        });

        // Clear filters button
        document.getElementById('btnLimpiar').addEventListener('click', function() {
            document.getElementById('inputBuscar').value = '';
            document.getElementById('tipoBusqueda').value = 'nombre';
            document.getElementById('rolFiltro').value = '';
            performAjaxSearch();
        });

        // Handle pagination clicks (event delegation)
        document.addEventListener('click', function(e) {
            const paginationLink = e.target.closest('.pagination a');
            if (paginationLink) {
                e.preventDefault();
                const url = new URL(paginationLink.href);
                const page = url.searchParams.get('page') || 1;
                performAjaxSearch(page);
            }
        });

        // Function to update active filters display
        function updateActiveFilters() {
            const activeFiltersDiv = document.getElementById('activeFilters');
            const searchTerm = document.getElementById('inputBuscar').value.trim();
            const tipoBusqueda = document.getElementById('tipoBusqueda').value;
            const rolFiltro = document.getElementById('rolFiltro').value;

            const roleMap = @json($roles->pluck('nombre', 'id_rol'));
            let filters = [];

            if (searchTerm) {
                const tipoText = tipoBusqueda === 'dni' ? 'DNI' : (tipoBusqueda === 'email' ? 'Email' : 'Nombre');
                filters.push(`<span class="badge badge-primary"><i class="fas fa-search me-1"></i>${tipoText}: "${searchTerm}"</span>`);
            }

            if (rolFiltro) {
                let rolText;
                if (rolFiltro === 'sin_roles') {
                    rolText = 'Sin roles asignados';
                } else {
                    rolText = roleMap[rolFiltro] || 'Rol desconocido';
                }
                filters.push(`<span class="badge badge-info"><i class="fas fa-user-tag me-1"></i>Rol: ${rolText}</span>`);
            }

            if (filters.length > 0) {
                activeFiltersDiv.innerHTML = '<small class="text-muted me-2"><i class="fas fa-filter me-1"></i>Filtros activos:</small>' + filters.join(' ');
                activeFiltersDiv.style.display = 'flex';
            } else {
                activeFiltersDiv.style.display = 'none';
            }
        }

        // Initialize active filters on page load
        updateActiveFilters();

        // Enter key support for search
        document.getElementById('inputBuscar').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performAjaxSearch();
            }
        });

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection
