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
    .remove-role-btn { position: absolute !important; top: -5px !important; right: -5px !important; z-index: 10; }
    #loaderPrincipal[style*="display: flex"] { display: flex !important; justify-content: center; align-items: center; position: absolute !important; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: 2000; }
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
                                Estimado Usuario: Selecciona las personas a las que deseas asignar roles, elige los roles correspondientes y confirma la asignación. Al asignar el primer rol a una persona, se creará automáticamente una cuenta de usuario.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2" style="background-color: #fcfffc !important">
                        <form id="roleAssignmentForm" method="POST" action="{{ route('asignacion-roles.asignar') }}">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-md-0 d-flex justify-content-start">
                                    <button type="submit" class="btn btn-success" id="assignRolesBtn" disabled>
                                        <i class="fa fa-user-tag mx-2"></i> Asignar Roles
                                    </button>
                                </div>
                                <div class="col-md-6 d-flex justify-content-md-end justify-content-start estilo-info">
                                    <form id="formBuscar" method="GET" class="w-100" style="max-width: 100%;">
                                        <div class="input-group">
                                            <input name="buscarpor" id="inputBuscar" class="form-control mt-3" type="search" placeholder="Buscar persona" aria-label="Search" autocomplete="off" style="border-color: #007bff;" value="{{ $buscarpor }}">
                                            <button class="btn btn-primary nuevo-boton" type="submit" style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important; background: #007bff !important; border: none;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>



                            <div id="alerts-container"></div>
                            <div class="row form-bordered align-items-center"></div>
                            <div class="table-responsive mt-2">
                                <table class="table-hover table table-custom text-center" style="border: 1px solid #0A8CB3; border-radius: 10px; overflow: hidden;">
                                    <thead class="table-hover estilo-info">
                                        <tr>
                                            <th scope="col" style="width: 50px;">
                                                <input type="checkbox" id="masterCheckbox" style="transform: scale(1.2);">
                                            </th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nombres</th>
                                            <th scope="col">Apellidos</th>
                                            <th scope="col">DNI</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Teléfono</th>
                                            <th scope="col">Roles Actuales</th>
                                            <th scope="col" id="role-assignment-header" style="display: none;">Asignar Roles</th>
                                            <th scope="col">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($personasSinRoles as $persona)
                                            <tr class="persona-row" data-persona-id="{{ $persona->id_persona }}">
                                                <td>
                                                    <input type="checkbox" class="persona-checkbox" name="selected_personas[]" value="{{ $persona->id_persona }}" style="transform: scale(1.2);">
                                                </td>
                                                <td>{{ $persona->id_persona }}</td>
                                                <td>{{ $persona->nombres }}</td>
                                                <td>{{ $persona->apellidos }}</td>
                                                <td>{{ $persona->dni }}</td>
                                                <td>{{ $persona->email ?: 'No registrado' }}</td>
                                                <td>{{ $persona->telefono ?: 'No registrado' }}</td>
                                                <td>
                                                    @if($persona->roles->count() > 0)
                                                        @foreach($persona->roles as $rol)
                                                            <span class="badge badge-info mr-1" data-role-id="{{ $rol->id_rol }}">{{ $rol->nombre }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="badge badge-secondary">Sin roles</span>
                                                    @endif
                                                </td>
                                                <td class="role-management-cell" style="display: none; min-width: 200px;">
                                                    <div class="role-manager p-2 border rounded" data-persona-id="{{ $persona->id_persona }}" style="background-color: #f8f9fa;">
                                                        <!-- Current roles with remove buttons -->
                                                        <div class="current-roles-manager mb-2">
                                                            <small class="text-muted d-block mb-1">Roles actuales:</small>
                                                            <div class="d-flex flex-wrap gap-1">
                                                                @if($persona->roles->count() > 0)
                                                                    @foreach($persona->roles as $rol)
                                                                        <span class="badge badge-info role-tag position-relative" data-role-id="{{ $rol->id_rol }}" style="font-size: 0.75rem;">
                                                                            {{ $rol->nombre }}
                                                                            <button type="button" class="btn position-absolute remove-role-btn"
                                                                                    style="font-size: 0.6rem; padding: 0.1rem; top: -3px; right: -3px; width: 14px; height: 14px; background: #dc3545; border: none; border-radius: 50%; color: white; line-height: 1;"
                                                                                    data-role-id="{{ $rol->id_rol }}"
                                                                                    aria-label="Remove role">
                                                                                <i class="fas fa-times" style="font-size: 0.5rem;"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted small">Sin roles asignados</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Add new roles -->
                                                        <div class="add-roles-section">
                                                            @if($roles->count() > $persona->roles->count())
                                                                <select class="form-select form-select-sm add-role-select" style="font-size: 0.75rem;">
                                                                    <option value="">Seleccionar rol...</option>
                                                                    @foreach($roles as $rol)
                                                                        @if(!$persona->roles->contains('id_rol', $rol->id_rol))
                                                                            <option value="{{ $rol->id_rol }}" data-role-name="{{ $rol->nombre }}">
                                                                                {{ $rol->nombre }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="text-muted small">Todos los roles ya están asignados</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $persona->estado == 'Activo' ? 'success' : 'danger' }}">
                                                        {{ $persona->estado }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No hay personas registradas que coincidan con la búsqueda.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div id="tabla-personas">
                                {{ $personasSinRoles->appends(request()->query())->links() }}
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
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        const roleAssignmentForm = document.getElementById('roleAssignmentForm');
        const assignRolesBtn = document.getElementById('assignRolesBtn');
        const masterCheckbox = document.getElementById('masterCheckbox');
        const personaCheckboxes = document.querySelectorAll('.persona-checkbox');

        // Función para actualizar el estado del botón de asignar roles
        function updateAssignButton() {
            const checkedBoxes = document.querySelectorAll('.persona-checkbox:checked');
            assignRolesBtn.disabled = checkedBoxes.length === 0;
        }

        // Función para mostrar/ocultar la columna de roles en la tabla
        function toggleRoleSection() {
            const checkedBoxes = document.querySelectorAll('.persona-checkbox:checked');
            const roleCells = document.querySelectorAll('.role-management-cell');
            const roleHeader = document.getElementById('role-assignment-header');

            if (checkedBoxes.length > 0) {
                // Mostrar la columna de roles para todas las filas
                roleCells.forEach(function(cell) {
                    cell.style.display = 'table-cell';
                });
                // Mostrar el header de la columna
                if (roleHeader) {
                    roleHeader.style.display = 'table-cell';
                }
            } else {
                // Ocultar la columna de roles para todas las filas
                roleCells.forEach(function(cell) {
                    cell.style.display = 'none';
                });
                // Ocultar el header de la columna
                if (roleHeader) {
                    roleHeader.style.display = 'none';
                }
            }
        }

        // Función para mostrar/ocultar el contenido de roles por fila
        function toggleRoleContent() {
            const allRows = document.querySelectorAll('.persona-row');
            allRows.forEach(function(row) {
                const checkbox = row.querySelector('.persona-checkbox');
                const roleCell = row.querySelector('.role-management-cell');
                const roleManager = row.querySelector('.role-manager');

                if (checkbox && checkbox.checked) {
                    // Mostrar contenido para fila seleccionada
                    if (roleManager) {
                        roleManager.style.display = 'block';
                    }
                } else {
                    // Ocultar contenido para fila no seleccionada
                    if (roleManager) {
                        roleManager.style.display = 'none';
                    }
                }
            });
        }

        // Función para remover un rol
        function removeRole(personaId, roleId, roleName) {
            const roleManager = document.querySelector(`.role-manager[data-persona-id="${personaId}"]`);
            const roleTag = roleManager.querySelector(`.role-tag[data-role-id="${roleId}"]`);
            const roleInput = roleManager.querySelector(`input[name="assignments[${personaId}][roles][]"][value="${roleId}"]`);

            // Verificar si este es el último rol de la persona
            const currentRolesManager = roleManager.querySelector('.current-roles-manager');
            const remainingDynamicTags = currentRolesManager.querySelectorAll('.role-tag');
            const row = roleManager.closest('tr');
            const existingRolesCount = row.querySelectorAll('.badge-info').length;

            const totalRolesAfterRemoval = remainingDynamicTags.length - 1 + existingRolesCount;

            if (totalRolesAfterRemoval === 0) {
                // No permitir quitar el último rol
                Swal.fire({
                    icon: 'warning',
                    title: 'No se puede quitar el último rol',
                    text: 'Cada persona debe tener al menos un rol asignado. Si desea cambiar el rol, primero agregue el nuevo rol y luego quite el anterior.',
                    confirmButtonColor: '#007bff'
                });
                return; // No quitar el rol
            }

            // Proceder con la eliminación
            if (roleTag) {
                roleTag.remove();
            }
            if (roleInput) {
                roleInput.remove();
            }

            // Nota: No quitamos el rol de "Roles Actuales" para mostrar vista previa
            // Solo se quitará cuando se confirme la asignación

            // Agregar la opción de vuelta al select
            const select = roleManager.querySelector('.add-role-select');
            if (select) {
                const existingOption = select.querySelector(`option[value="${roleId}"]`);
                if (!existingOption) {
                    const newOption = document.createElement('option');
                    newOption.value = roleId;
                    newOption.setAttribute('data-role-name', roleName);
                    newOption.innerHTML = roleName;
                    select.appendChild(newOption);
                }
            }

            // Actualizar el mensaje si no quedan roles dinámicos
            const remainingTagsAfterRemoval = currentRolesManager.querySelectorAll('.role-tag');
            if (remainingTagsAfterRemoval.length === 0) {
                currentRolesManager.innerHTML = '<span class="text-muted small">Sin roles asignados</span>';
            }
        }

        // Función para agregar un rol
        function addRole(personaId, roleId, roleName) {
            const roleManager = document.querySelector(`.role-manager[data-persona-id="${personaId}"]`);
            const currentRolesManager = roleManager.querySelector('.current-roles-manager');

            // Remover mensaje de "sin roles" si existe
            const noRolesMsg = currentRolesManager.querySelector('.text-muted');
            if (noRolesMsg) {
                noRolesMsg.remove();
            }

            // Agregar el tag del rol
            const roleTag = document.createElement('span');
            roleTag.className = 'badge badge-success me-1 mb-1 role-tag';
            roleTag.setAttribute('data-role-id', roleId);
            roleTag.innerHTML = `
                ${roleName}
                <button type="button" class="btn position-absolute remove-role-btn" style="font-size: 0.6rem; padding: 0.1rem; top: -3px; right: -3px; width: 14px; height: 14px; background: #dc3545; border: none; border-radius: 50%; color: white; line-height: 1;" data-role-id="${roleId}" aria-label="Remove role">
                    <i class="fas fa-times" style="font-size: 0.5rem;"></i>
                </button>
                <input type="hidden" name="assignments[${personaId}][roles][]" value="${roleId}" class="role-input">
            `;
            currentRolesManager.appendChild(roleTag);

            // Remover la opción del select
            const select = roleManager.querySelector('.add-role-select');
            const optionToRemove = select.querySelector(`option[value="${roleId}"]`);
            if (optionToRemove) {
                optionToRemove.remove();
            }

            // Agregar event listener al botón de remover
            roleTag.querySelector('.remove-role-btn').addEventListener('click', function() {
                removeRole(personaId, roleId, roleName);
            });
        }







        // Event listener para checkboxes individuales
        personaCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateAssignButton();
                toggleRoleSection();
                toggleRoleContent();
                updateMasterCheckbox();
            });
        });

        // Event listener para checkbox maestro
        masterCheckbox.addEventListener('change', function() {
            const isChecked = masterCheckbox.checked;
            personaCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
            updateAssignButton();
            toggleRoleSection();
            toggleRoleContent();
        });



        // Función para actualizar el estado del checkbox maestro
        function updateMasterCheckbox() {
            const totalCheckboxes = personaCheckboxes.length;
            const checkedBoxes = document.querySelectorAll('.persona-checkbox:checked').length;

            if (checkedBoxes === 0) {
                masterCheckbox.checked = false;
                masterCheckbox.indeterminate = false;
            } else if (checkedBoxes === totalCheckboxes) {
                masterCheckbox.checked = true;
                masterCheckbox.indeterminate = false;
            } else {
                masterCheckbox.checked = false;
                masterCheckbox.indeterminate = true;
            }
        }



        // Función de validación del formulario
        function validateForm(e) {
            // Alerta simple para confirmar que JavaScript se ejecuta
            Swal.fire({
                icon: 'info',
                title: 'Validando...',
                text: 'JavaScript se está ejecutando correctamente',
                timer: 1000,
                showConfirmButton: false
            });

            const selectedPersons = document.querySelectorAll('.persona-checkbox:checked');
            const debugInfo = [
                `Personas seleccionadas: ${selectedPersons.length}`
            ];

            if (selectedPersons.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Selección requerida',
                    text: 'Debe seleccionar al menos una persona para asignar roles.',
                    confirmButtonColor: '#007bff'
                });
                return false;
            }

            // Verificar que cada persona seleccionada tenga al menos un rol asignado
            let personsWithoutRoles = [];
            let hasAnyRoles = false;
            let totalRolesAssigned = 0;
            let personSummaries = [];

            selectedPersons.forEach(function(personaCheckbox) {
                const personaId = personaCheckbox.value;
                const row = personaCheckbox.closest('tr');
                const nombre = row.cells[2].textContent.trim();
                const apellido = row.cells[3].textContent.trim();
                const nombreCompleto = `${nombre} ${apellido}`;

                // Contar roles que van a ser enviados (los que están en "Asignar Roles")
                let rolesToSendCount = 0;
                const roleManager = row.querySelector(`.role-manager[data-persona-id="${personaId}"]`);
                if (roleManager) {
                    // Roles existentes que quedan (badges en "Asignar Roles")
                    const remainingBadges = roleManager.querySelectorAll('.role-tag[data-role-id]');
                    rolesToSendCount += remainingBadges.length;

                    // Roles nuevos agregados (inputs hidden)
                    const dynamicRoles = roleManager.querySelectorAll('input[name="assignments[' + personaId + '][roles][]"]');
                    rolesToSendCount += dynamicRoles.length;
                }

                totalRolesAssigned += rolesToSendCount;

                if (rolesToSendCount === 0) {
                    personsWithoutRoles.push(nombreCompleto);
                } else {
                    hasAnyRoles = true;
                    personSummaries.push(`${nombreCompleto} (${rolesToSendCount} ${rolesToSendCount === 1 ? 'rol' : 'roles'})`);
                }
            });

            // Crear mensaje amigable para el usuario
            let messageTitle = `${selectedPersons.length} ${selectedPersons.length === 1 ? 'persona seleccionada' : 'personas seleccionadas'}`;
            let messageBody = '';

            if (personSummaries.length > 0) {
                messageBody = personSummaries.join('<br>');
            }

            if (personsWithoutRoles.length > 0) {
                if (messageBody) messageBody += '<br><br>';
                messageBody += `<span style="color: #dc3545;">⚠️ Personas sin roles asignados:<br>${personsWithoutRoles.join('<br>')}</span>`;
            }

            // Mostrar información amigable
            Swal.fire({
                icon: hasAnyRoles ? 'info' : 'warning',
                title: messageTitle,
                html: messageBody || 'No hay personas con roles asignados.',
                confirmButtonText: 'Confirmar asignación',
                cancelButtonText: 'Cancelar',
                showCancelButton: true,
                confirmButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Verificar validaciones finales
                    if (!hasAnyRoles) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Roles requeridos',
                            text: 'Debe asignar al menos un rol a alguna de las personas seleccionadas.',
                            confirmButtonColor: '#007bff'
                        });
                        return false;
                    }

                    if (personsWithoutRoles.length > 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Roles incompletos',
                            text: `Las siguientes personas no tienen roles seleccionados: ${personsWithoutRoles.join(', ')}`,
                            confirmButtonColor: '#007bff'
                        });
                        return false;
                    }

                    // Si todo está bien, construir FormData manualmente y enviar
                    if (loader) {
                        loader.style.display = 'flex';
                    }

                    // Crear FormData manualmente con los datos correctos
                    const formData = new FormData();

                    // Agregar token CSRF
                    const csrfToken = document.querySelector('input[name="_token"]');
                    if (csrfToken) {
                        formData.append('_token', csrfToken.value);
                    }

                    // Agregar personas seleccionadas
                    selectedPersons.forEach(function(personaCheckbox) {
                        formData.append('selected_personas[]', personaCheckbox.value);
                    });

                    // Agregar assignments de roles (solo los roles que quedan en "Asignar Roles")
                    selectedPersons.forEach(function(personaCheckbox) {
                        const personaId = personaCheckbox.value;
                        const row = personaCheckbox.closest('tr');

                        // Obtener roles que quedan en "Asignar Roles" (badges existentes que no se quitaron + nuevos agregados)
                        const rolesInAssignment = [];
                        const roleManager = row.querySelector(`.role-manager[data-persona-id="${personaId}"]`);
                        if (roleManager) {
                            // Roles existentes que quedan (badges en "Asignar Roles")
                            const remainingBadges = roleManager.querySelectorAll('.role-tag[data-role-id]');
                            remainingBadges.forEach(function(badge) {
                                const roleId = badge.getAttribute('data-role-id');
                                if (roleId) {
                                    rolesInAssignment.push(roleId);
                                }
                            });

                            // Roles nuevos agregados (inputs hidden)
                            const dynamicRoles = roleManager.querySelectorAll('input[name="assignments[' + personaId + '][roles][]"]');
                            dynamicRoles.forEach(function(roleInput) {
                                rolesInAssignment.push(roleInput.value);
                            });
                        }

                        // Enviar solo los roles que quedan en "Asignar Roles"
                        rolesInAssignment.forEach(function(roleId) {
                            formData.append(`assignments[${personaId}][roles][]`, roleId);
                        });
                    });

                    // Enviar usando fetch en lugar de submit
                    fetch(roleAssignmentForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            return response.text();
                        }
                    })
                    .then(data => {
                        if (data) {
                            // Si hay respuesta HTML, recargar la página
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // En caso de error, recargar la página
                        window.location.reload();
                    });
                }
            });

            e.preventDefault(); // Siempre prevenir envío automático
            return false;
        }

        // Validación del formulario antes de enviar
        roleAssignmentForm.addEventListener('submit', validateForm);

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

        // Event listeners para botones de remover roles (iniciales)
        document.querySelectorAll('.remove-role-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const roleId = this.getAttribute('data-role-id');
                const personaId = this.closest('.role-manager').getAttribute('data-persona-id');
                const roleTag = this.closest('.role-tag');
                const roleName = roleTag.textContent.trim().replace('×', '').trim();
                removeRole(personaId, roleId, roleName);
            });
        });

        // Event listeners para select de agregar roles
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('add-role-select')) {
                const select = e.target;
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption.value) {
                    const roleId = selectedOption.value;
                    const roleName = selectedOption.getAttribute('data-role-name');
                    const personaId = select.closest('.role-manager').getAttribute('data-persona-id');
                    addRole(personaId, roleId, roleName);
                    // Reset select
                    select.value = '';
                }
            }
        });

        // Búsqueda reactiva
        let searchTimeout;
        document.getElementById('inputBuscar').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value;

            searchTimeout = setTimeout(function() {
                performSearch(searchTerm);
            }, 300); // Esperar 300ms después de que el usuario deje de escribir
        });

        function performSearch(searchTerm) {
            const formData = new FormData();
            formData.append('buscarpor', searchTerm);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch(window.location.pathname, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Actualizar la tabla con los resultados
                updateTable(data.html);
                // Actualizar la paginación
                updatePagination(data.pagination);
                // Re-inicializar los event listeners
                reinitializeEventListeners();
            })
            .catch(error => {
                console.error('Error en búsqueda:', error);
            });
        }

        function updateTable(html) {
            const tableBody = document.querySelector('tbody');
            tableBody.innerHTML = html;
        }

        function updatePagination(paginationHtml) {
            const paginationContainer = document.getElementById('tabla-personas');
            if (paginationContainer) {
                paginationContainer.innerHTML = paginationHtml;
            }
        }

        function reinitializeEventListeners() {
            // Re-inicializar checkboxes
            const newPersonaCheckboxes = document.querySelectorAll('.persona-checkbox');
            newPersonaCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    updateAssignButton();
                    toggleRoleSection();
                    toggleRoleContent();
                    updateMasterCheckbox();
                });
            });

            // Re-inicializar botones de remover roles
            document.querySelectorAll('.remove-role-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-role-id');
                    const personaId = this.closest('.role-manager').getAttribute('data-persona-id');
                    const roleTag = this.closest('.role-tag');
                    const roleName = roleTag.textContent.trim().replace('×', '').trim();
                    removeRole(personaId, roleId, roleName);
                });
            });

            // Re-inicializar selects de agregar roles
            document.querySelectorAll('.add-role-select').forEach(function(select) {
                select.addEventListener('change', function() {
                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption.value) {
                        const roleId = selectedOption.value;
                        const roleName = selectedOption.getAttribute('data-role-name');
                        const personaId = select.closest('.role-manager').getAttribute('data-persona-id');
                        addRole(personaId, roleId, roleName);
                        select.value = '';
                    }
                });
            });

            // Actualizar el estado de la interfaz después de la búsqueda
            updateAssignButton();
            toggleRoleSection();
            toggleRoleContent();
            updateMasterCheckbox();
        }

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection
