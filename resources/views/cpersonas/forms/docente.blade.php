<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="docente_emailUniversidad" class="estilo-info">
                Email Universitario * <i class="fas fa-info-circle text-info" title="Email institucional único para el docente"></i>
            </label>
            <div class="input-group">
                <input type="text" class="form-control @error('docente_emailUniversidad') is-invalid @enderror"
                    id="docente_emailUniversidad_username" name="docente_emailUniversidad_username"
                    value="{{ old('docente_emailUniversidad_username', $persona ?? null ? ($persona->docente ? explode('@', $persona->docente->emailUniversidad)[0] : '') : '') }}"
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
    <div class="col-md-6">
        <div class="form-group">
            <label for="docente_fecha_contratacion" class="estilo-info">
                Fecha de Contratación <i class="fas fa-calendar-alt text-primary" title="Fecha en que inició su contrato docente"></i>
            </label>
            <input type="date" class="form-control @error('docente.fecha_contratacion') is-invalid @enderror"
                id="docente_fecha_contratacion" name="docente[fecha_contratacion]"
                value="{{ old('docente.fecha_contratacion', $persona ?? null ? ($persona->docente ? ($persona->docente->fecha_contratacion ? \Carbon\Carbon::parse($persona->docente->fecha_contratacion)->format('Y-m-d') : '') : '') : '') }}"
                style="border-color: #007bff;">
            <small id="docente_fecha_contratacionHelp" class="form-text text-danger" style="display: none;"></small>
            @error('docente_fecha_contratacion')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="docente_especialidades" class="estilo-info">
                Especialidades <i class="fas fa-graduation-cap text-secondary" title="Áreas de especialización del docente"></i>
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

            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;" id="especialidades-container">
                @foreach($especialidades as $especialidad)
                    <div class="form-check especialidad-item" style="padding: 8px; border-radius: 4px; transition: background-color 0.2s;" data-nombre="{{ strtolower($especialidad->nombre) }}">
                        <input class="form-check-input especialidad-checkbox" type="checkbox"
                            name="docente[especialidades][]" value="{{ $especialidad->id_especialidad }}"
                            id="especialidad_{{ $especialidad->id_especialidad }}"
                            {{ in_array($especialidad->id_especialidad, old('docente.especialidades', $persona ?? null ? ($persona->docente ? $persona->docente->especialidades->pluck('id_especialidad')->toArray() : []) : [])) ? 'checked' : '' }}>
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
