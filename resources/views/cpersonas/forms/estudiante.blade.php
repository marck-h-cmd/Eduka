<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="estudiante_emailUniversidad" class="estilo-info">
                Email Universitario * <i class="fas fa-info-circle text-info" title="Email institucional único para el estudiante"></i>
            </label>
            <div class="input-group">
                <input type="text" class="form-control @error('estudiante_emailUniversidad') is-invalid @enderror"
                    id="estudiante_emailUniversidad_username" name="estudiante_emailUniversidad_username"
                    value="{{ old('estudiante_emailUniversidad_username', $persona ?? null ? ($persona->estudiante ? explode('@', $persona->estudiante->emailUniversidad)[0] : '') : '') }}"
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
                value="{{ old('estudiante.anio_ingreso', $persona ?? null ? ($persona->estudiante ? $persona->estudiante->anio_ingreso : date('Y')) : date('Y')) }}"
                min="1900" max="{{ date('Y') + 10 }}" style="border-color: #007bff;" required>
            <small id="estudiante_anio_ingresoHelp" class="form-text text-danger" style="display: none;"></small>
            @error('estudiante_anio_ingreso')
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
                value="{{ old('estudiante.anio_egreso', $persona ?? null ? ($persona->estudiante ? $persona->estudiante->anio_egreso : '') : '') }}"
                style="border-color: #007bff;" min="1900" max="{{ date('Y') + 20 }}">
            <small id="estudiante_anio_egresoHelp" class="form-text text-danger" style="display: none;"></small>
            @error('estudiante_anio_egreso')
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
                        {{ (old('estudiante_id_escuela', $persona->estudiante->id_escuela ?? null) == $escuela->id_escuela) ? 'selected' : '' }}>
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
                            {{ (old('estudiante_id_curricula', $persona->estudiante->id_curricula ?? null) == $curricula->id_curricula) ? 'selected' : '' }}>
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
