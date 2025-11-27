<div>
    <div class="card " style="border: none">
        <div
            style="background: #E0F7FA; color: #0A8CB3; font-weight: bold; border: 2px solid #86D2E3; border-bottom: 2px solid #86D2E3; padding: 6px 20px; border-radius:4px 4px 0px 0px;">
            <i class="icon-phone mr-2"></i>
            Información de Contacto
        </div>
        <div class="card-body"
            style="border: 2px solid #86D2E3; border-top: none; border-radius: 0px 0px 4px 4px !important;">

            <div class="row form-group">
                <label class="col-md-2 col-form-label">
                    Celular actual <span style="color: #FF5A6A">(*)</span>
                </label>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text"
                            class="form-control @error('numeroCelularEstudiante') is-invalid @enderror"
                            id="numeroCelularEstudiante" name="numeroCelularEstudiante" placeholder="N.° celular"
                            value="{{ old('numeroCelularEstudiante') }}" inputmode="numeric">

                        @error('numeroCelularEstudiante')
                            <div class="invalid-feedback d-block text-start">{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-2 col-form-label">
                    Correo electrónico <span style="color: #FF5A6A">(*)</span>
                </label>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="form-control @error('correoEstudiante') is-invalid @enderror"
                            id="correoEstudiante" name="correoEstudiante" placeholder="correo@estudiante.com"
                            maxlength="100" value="{{ old('correoEstudiante') }}">
                        @error('correoEstudiante')
                            <div class="invalid-feedback d-block text-start">{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

          <!-- Mensaje informativo -->
            <div class="alert alert-info d-flex align-items-center my-2 " role="alert"
                style="background: #faf8f4; color: #02789E; border-left: 5px solid #04A1C6;">
                <i class="fas fa-info-circle me-2 mr-2" style="font-size: 1.2rem;"></i>
                <span>Puedes registrar el número de celular o el correo electrónico de los padres o apoderados.</span>
            </div>
        </div>
    </div>
</div>
