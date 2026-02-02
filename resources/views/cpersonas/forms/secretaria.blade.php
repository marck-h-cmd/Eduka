<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="secretaria_emailUniversidad" class="estilo-info">
                Email Universitario * <i class="fas fa-info-circle text-info" title="Email institucional único para la secretaria"></i>
            </label>
            <div class="input-group">
                <input type="text" class="form-control @error('secretaria_emailUniversidad') is-invalid @enderror"
                    id="secretaria_emailUniversidad_username" name="secretaria_emailUniversidad_username"
                    value="{{ old('secretaria_emailUniversidad_username', $persona ?? null ? ($persona->secretaria ? explode('@', $persona->secretaria->emailUniversidad)[0] : '') : '') }}"
                    style="border-color: #007bff;" placeholder="usuario" autocomplete="off">
                <div class="input-group-append">
                    <span class="input-group-text" style="border-color: #007bff; background-color: #f8f9fa;">@</span>
                </div>
                <select class="form-control @error('secretaria_emailUniversidad') is-invalid @enderror"
                    id="secretaria_emailUniversidad_domain" name="secretaria_emailUniversidad_domain"
                    style="border-color: #007bff;" required>
                    <option value="unitru.edu.pe" selected>unitru.edu.pe</option>
                </select>
            </div>
            <small class="form-text text-muted">Debe ser único en el sistema administrativo</small>
            <small id="secretaria_emailHelp" class="form-text text-danger" style="display: none;"></small>
            @error('secretaria_emailUniversidad')
                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="secretaria_fecha_ingreso" class="estilo-info">
                Fecha de Ingreso <i class="fas fa-calendar-plus text-success" title="Fecha en que inició sus funciones"></i>
            </label>
            <input type="date" class="form-control @error('secretaria.fecha_ingreso') is-invalid @enderror"
                id="secretaria_fecha_ingreso" name="secretaria[fecha_ingreso]"
                value="{{ old('secretaria.fecha_ingreso', $persona ?? null ? ($persona->secretaria ? $persona->secretaria->fecha_ingreso : date('Y-m-d')) : date('Y-m-d')) }}"
                style="border-color: #007bff;">
            <small id="secretaria_fecha_ingresoHelp" class="form-text text-danger" style="display: none;"></small>
            @error('secretaria_fecha_ingreso')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>
