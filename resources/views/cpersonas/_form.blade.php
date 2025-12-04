{{-- Formulario compartido para crear/editar personas --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nombres" class="estilo-info">Nombres *</label>
            <input type="text"
                class="form-control @error('nombres') is-invalid @enderror" id="nombres"
                name="nombres" value="{{ old('nombres', $persona->nombres ?? '') }}"
                data-original-value="{{ $persona->nombres ?? '' }}" required
                style="border-color: #007bff;">
            @error('nombres')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="apellidos" class="estilo-info">Apellidos *</label>
            <input type="text"
                class="form-control @error('apellidos') is-invalid @enderror" id="apellidos"
                name="apellidos" value="{{ old('apellidos', $persona->apellidos ?? '') }}"
                data-original-value="{{ $persona->apellidos ?? '' }}" required
                style="border-color: #007bff;">
            @error('apellidos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="dni" class="estilo-info">DNI *</label>
            <input type="text" class="form-control @error('dni') is-invalid @enderror"
                id="dni" name="dni" value="{{ old('dni', $persona->dni ?? '') }}"
                data-original-value="{{ $persona->dni ?? '' }}" maxlength="8"
                style="border-color: #007bff;" pattern="[0-9]{8}"
                title="El DNI debe contener exactamente 8 dígitos" required>
            @error('dni')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <small id="dniHelp" class="form-text text-muted"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="telefono" class="estilo-info">Teléfono</label>
            <input type="text"
                class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                name="telefono" value="{{ old('telefono', $persona->telefono ?? '') }}"
                data-original-value="{{ $persona->telefono ?? '' }}" maxlength="9"
                style="border-color: #007bff;" pattern="[0-9]{9}"
                title="El teléfono debe contener exactamente 9 dígitos">
            @error('telefono')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <small id="telefonoHelp" class="form-text text-muted"></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="email" class="estilo-info">Email *</label>
            <div class="input-group">
                @php
                    $emailParts = isset($persona) ? explode('@', old('email', $persona->email ?? '')) : explode('@', old('email', ''));
                    $emailUsername = $emailParts[0] ?? '';
                    $emailDomain = $emailParts[1] ?? '';
                @endphp
                <input type="text"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email_username" name="email_username"
                    value="{{ old('email_username', $emailUsername) }}"
                    data-original-value="{{ $emailUsername }}"
                    style="border-color: #007bff;" placeholder="usuario" autocomplete="off" required>
                <div class="input-group-append">
                    <span class="input-group-text"
                        style="border-color: #007bff; background-color: #f8f9fa;">@</span>
                </div>
                <select class="form-control @error('email') is-invalid @enderror"
                        id="email_domain" name="email_domain"
                        data-original-value="{{ $emailDomain }}"
                        style="border-color: #007bff;" required>
                    <option value="">Seleccionar dominio</option>
                    <option value="unitru.edu.pe"
                        {{ old('email_domain', $emailDomain) === 'unitru.edu.pe' ? 'selected' : '' }}>unitru.edu.pe</option>
                    <option value="gmail.com"
                        {{ old('email_domain', $emailDomain) === 'gmail.com' ? 'selected' : '' }}>gmail.com</option>
                    <option value="hotmail.com"
                        {{ old('email_domain', $emailDomain) === 'hotmail.com' ? 'selected' : '' }}>hotmail.com</option>
                    <option value="outlook.com"
                        {{ old('email_domain', $emailDomain) === 'outlook.com' ? 'selected' : '' }}>outlook.com</option>
                </select>
            </div>
            @error('email')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <small class="form-text text-info">
                <i class="fas fa-info-circle"></i> Este email será utilizado para el envío de credenciales si se asigna un rol a la persona.
            </small>
            <small id="emailHelp" class="form-text text-muted"
                style="font-weight: bold;"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="fecha_nacimiento" class="estilo-info">Fecha de Nacimiento</label>
            <input type="date"
                class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                id="fecha_nacimiento" name="fecha_nacimiento"
                value="{{ old('fecha_nacimiento', isset($persona) && $persona->fecha_nacimiento ? $persona->fecha_nacimiento->format('Y-m-d') : '') }}"
                data-original-value="{{ isset($persona) && $persona->fecha_nacimiento ? $persona->fecha_nacimiento->format('Y-m-d') : '' }}"
                style="border-color: #007bff;" placeholder="dd/mm/aaaa">
            @error('fecha_nacimiento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <small id="fechaHelp" class="form-text text-muted"></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="genero" class="estilo-info">Género</label>
            <select class="form-control @error('genero') is-invalid @enderror"
                id="genero" name="genero" style="border-color: #007bff;"
                data-original-value="{{ $persona->genero ?? '' }}">
                <option value="">Seleccionar género</option>
                <option value="M" {{ old('genero', $persona->genero ?? '') == 'M' ? 'selected' : '' }}>
                    Masculino</option>
                <option value="F" {{ old('genero', $persona->genero ?? '') == 'F' ? 'selected' : '' }}>
                    Femenino</option>
                <option value="Otro" {{ old('genero', $persona->genero ?? '') == 'Otro' ? 'selected' : '' }}>
                    Otro</option>
            </select>
            @error('genero')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="direccion" class="estilo-info">Dirección</label>
            <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion"
                data-original-value="{{ $persona->direccion ?? '' }}" rows="3" style="border-color: #007bff;">{{ old('direccion', $persona->direccion ?? '') }}</textarea>
            @error('direccion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

{{-- Gestión de roles con tabs optimizada --}}
<div class="form-group">
    <label class="estilo-info">Asignación de Roles</label>
    <small class="form-text text-muted mb-3">
        <strong>Haz clic en los roles que deseas asignar a esta persona</strong><br>
        <i class="fas fa-info-circle text-info"></i> Para cada rol seleccionado, se habilitará su pestaña de configuración.
    </small>

    {{-- Tarjetas de selección de roles --}}
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="card-body">
            <div class="row">
                @foreach ($roles as $rol)
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="role-selector-card text-center p-3 border rounded position-relative"
                             style="background: white; transition: all 0.3s ease; cursor: pointer;"
                             data-role-id="{{ $rol->id_rol }}"
                             data-role-name="{{ $rol->nombre }}">
                            {{-- Checkbox oculto para el formulario --}}
                            <input type="checkbox" name="roles[]" value="{{ $rol->id_rol }}"
                                   id="role_checkbox_{{ $rol->id_rol }}" class="d-none"
                                   data-original-checked="{{ isset($persona) && $persona->roles->where('id_rol', $rol->id_rol)->count() > 0 ? 'true' : 'false' }}"
                                   {{ (isset($persona) && $persona->roles->where('id_rol', $rol->id_rol)->count() > 0) || in_array($rol->id_rol, old('roles', [])) ? 'checked' : '' }}>

                            {{-- Icono representativo del rol --}}
                            <div class="mb-2">
                                @if ($rol->nombre == 'Administrador')
                                    <i class="fas fa-crown fa-2x text-warning role-icon"></i>
                                @elseif($rol->nombre == 'Docente')
                                    <i class="fas fa-chalkboard-teacher fa-2x text-info role-icon"></i>
                                @elseif($rol->nombre == 'Estudiante')
                                    <i class="fas fa-user-graduate fa-2x text-success role-icon"></i>
                                @elseif($rol->nombre == 'Secretaria')
                                    <i class="fas fa-user-tie fa-2x text-secondary role-icon"></i>
                                @elseif($rol->nombre == 'Representante')
                                    <i class="fas fa-user-friends fa-2x text-primary role-icon"></i>
                                @else
                                    <i class="fas fa-user-tag fa-2x text-secondary role-icon"></i>
                                @endif
                            </div>

                            {{-- Información del rol --}}
                            <div class="font-weight-bold text-dark mb-1">{{ $rol->nombre }}</div>
                            <small class="text-muted d-block mb-2">{{ $rol->descripcion }}</small>

                            {{-- Estado de selección --}}
                            @php
                                $isSelected = (isset($persona) && $persona->roles->where('id_rol', $rol->id_rol)->count() > 0) || in_array($rol->id_rol, old('roles', []));
                            @endphp
                            <span class="badge {{ $isSelected ? 'badge-success' : 'badge-secondary' }} role-status-badge"
                                  id="status_badge_{{ $rol->id_rol }}">
                                <i class="fas fa-{{ $isSelected ? 'check-circle' : 'plus-circle' }}"></i>
                                {{ $isSelected ? 'Seleccionado' : 'Seleccionar' }}
                            </span>

                            {{-- Indicador visual de selección --}}
                            <div class="role-checkmark position-absolute" style="top: 10px; right: 10px; display: {{ $isSelected ? 'block' : 'none' }};">
                                <i class="fas fa-check-circle fa-lg text-success"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sistema de paneles colapsables para configuración de roles --}}
    <div id="role-config-container" style="display: {{ isset($persona) && $persona->roles->count() > 0 ? 'block' : 'none' }};">
        <div class="accordion" id="roleAccordion">

            {{-- Panel Administrador --}}
            <div class="card role-panel" id="admin-panel" style="display: none;">
                <div class="card-header" id="admin-heading">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-decoration-none w-100 text-left" type="button"
                                data-toggle="collapse" data-target="#admin-collapse" aria-expanded="true" aria-controls="admin-collapse">
                            <i class="fas fa-crown text-warning mr-2"></i>
                            <strong>Configuración de Administrador</strong>
                            <i class="fas fa-chevron-down float-right"></i>
                        </button>
                    </h5>
                </div>
                <div id="admin-collapse" class="collapse show" aria-labelledby="admin-heading" data-parent="#roleAccordion">
                    <div class="card-body">
                        <div class="alert alert-warning border-0 mb-0">
                            <i class="fas fa-info-circle fa-lg mr-3 float-left"></i>
                            <strong>Rol de Administrador Seleccionado</strong><br>
                            Este rol otorga acceso completo al sistema administrativo. No requiere configuración adicional.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel Docente --}}
            <div class="card role-panel" id="docente-panel" style="display: none;">
                <div class="card-header" id="docente-heading">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-decoration-none w-100 text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#docente-collapse" aria-expanded="false" aria-controls="docente-collapse">
                            <i class="fas fa-chalkboard-teacher text-info mr-2"></i>
                            <strong>Configuración de Docente</strong>
                            <i class="fas fa-chevron-down float-right"></i>
                        </button>
                    </h5>
                </div>
                <div id="docente-collapse" class="collapse" aria-labelledby="docente-heading" data-parent="#roleAccordion">
                <div class="card-body">
                    @include('cpersonas.forms.docente', ['persona' => $persona ?? null, 'especialidades' => $especialidades])
                </div>
                </div>
            </div>

            {{-- Panel Estudiante --}}
            <div class="card role-panel" id="estudiante-panel" style="display: none;">
                <div class="card-header" id="estudiante-heading">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-decoration-none w-100 text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#estudiante-collapse" aria-expanded="false" aria-controls="estudiante-collapse">
                            <i class="fas fa-user-graduate text-success mr-2"></i>
                            <strong>Configuración de Estudiante</strong>
                            <i class="fas fa-chevron-down float-right"></i>
                        </button>
                    </h5>
                </div>
                <div id="estudiante-collapse" class="collapse" aria-labelledby="estudiante-heading" data-parent="#roleAccordion">
                    <div class="card-body">
                        @include('cpersonas.forms.estudiante', ['persona' => $persona ?? null, 'escuelas' => $escuelas, 'curriculas' => $curriculas])
                    </div>
                </div>
            </div>

            {{-- Panel Secretaria --}}
            <div class="card role-panel" id="secretaria-panel" style="display: none;">
                <div class="card-header" id="secretaria-heading">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-decoration-none w-100 text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#secretaria-collapse" aria-expanded="false" aria-controls="secretaria-collapse">
                            <i class="fas fa-user-tie text-secondary mr-2"></i>
                            <strong>Configuración de Secretaria</strong>
                            <i class="fas fa-chevron-down float-right"></i>
                        </button>
                    </h5>
                </div>
                <div id="secretaria-collapse" class="collapse" aria-labelledby="secretaria-heading" data-parent="#roleAccordion">
                    <div class="card-body">
                        @include('cpersonas.forms.secretaria', ['persona' => $persona ?? null])
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Manejo de errores de roles --}}
@error('roles')
    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
@enderror
@error('roles.*')
    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
@enderror
