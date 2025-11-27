<div>
    <div class="card" style="border: none">
        <div
            style="background: #E0F7FA; color: #0A8CB3; font-weight: bold; border: 2px solid #86D2E3; border-bottom: 2px solid #86D2E3; padding: 6px 20px; border-radius:4px 4px 0px 0px;">
            <i class="icon-location-pin mr-2"></i>
            Información de Residencia
        </div>
        <div class="card-body"
            style="border: 2px solid #86D2E3; border-top: none; border-radius: 0px 0px 4px 4px !important;">
            <div class="row form-group">
                <label class="col-md-2 col-form-label">
                    Región <span style="color: #FF5A6A">(*)</span>
                </label>
                <div class="col-md-10">
                    <select id="regionEstudiante" name="regionEstudiante"
                        class="form-control @error('regionEstudiante') is-invalid @enderror">
                        <option value="" disabled {{ old('regionEstudiante') == '' ? 'selected' : '' }}>
                            Seleccionar
                            Región</option>
                    </select>
                    @error('regionEstudiante')
                        <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-2 col-form-label">
                    Provincia <span style="color: #FF5A6A">(*)</span>
                </label>
                <div class="col-md-4">
                    <select id="provinciaEstudiante" name="provinciaEstudiante"
                        class="form-control @error('provinciaEstudiante') is-invalid @enderror" disabled>
                        <option value="" disabled {{ old('provinciaEstudiante') == '' ? 'selected' : '' }}>
                            Seleccionar Provincia</option>
                    </select>
                    @error('provinciaEstudiante')
                        <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                    @enderror
                </div>

                <label class="col-md-2 col-form-label">
                    Distrito <span style="color: #FF5A6A">(*)</span>
                </label>
                <div class="col-md-4">
                    <select id="distritoEstudiante" name="distritoEstudiante"
                        class="form-control @error('distritoEstudiante') is-invalid @enderror" disabled>
                        <option value="" disabled {{ old('distritoEstudiante') == '' ? 'selected' : '' }}>
                            Seleccionar
                            Distrito</option>
                    </select>
                    @error('distritoEstudiante')
                        <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-2 col-form-label">Avenida o calle <span style="color: #FF5A6A">(*)</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control @error('calleEstudiante') is-invalid @enderror"
                        id="calleEstudiante" name="calleEstudiante" placeholder="Avenida o calle" maxlength="20"
                        value="{{ old('calleEstudiante') }}">
                    @error('calleEstudiante')
                        <div class="invalid-feedback d-block text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <label class="col-md-2 col-form-label">Número</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="numeroEstudiante" name="numeroEstudiante"
                        placeholder="149" maxlength="5" value="{{ old('numeroEstudiante') }}" inputmode="numeric">
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-2 col-form-label">Urbanización</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="urbanizacionEstudiante" name="urbanizacionEstudiante"
                        placeholder="Urbanización" maxlength="20" value="{{ old('urbanizacionEstudiante') }}">
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-2 col-form-label">Referencia</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="referenciaEstudiante" name="referenciaEstudiante"
                        placeholder="Referencia" maxlength="20" value="{{ old('referenciaEstudiante') }}">
                </div>
            </div>
        </div>
    </div>
</div>
