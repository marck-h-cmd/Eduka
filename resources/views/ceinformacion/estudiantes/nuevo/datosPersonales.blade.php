<div>
    <div class="card " style="border: none">
        <div
            style="background: #E0F7FA; color: #0A8CB3; font-weight: bold; border: 2px solid #86D2E3; border-bottom: 2px solid #86D2E3; padding: 6px 20px; border-radius:4px 4px 0px 0px;">
            <i class="icon-graduation mr-2"></i>
            Datos Personales
        </div>

        <div class="card-body"
            style="border: 2px solid #86D2E3; border-top: none; border-radius: 0 0 4px 4px !important;">

            {{-- Apellidos --}}
            <div class="row form-group">
                <label class="col-md-2 col-form-label">Apellido paterno <span style="color:#FF5A6A;">(*)</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control @error('apellidoPaternoEstudiante') is-invalid @enderror"
                        id="apellidoPaternoEstudiante" name="apellidoPaternoEstudiante"
                        placeholder="Ingrese el apellido paterno" maxlength="100"
                        value="{{ old('apellidoPaternoEstudiante') }}">
                    @error('apellidoPaternoEstudiante')
                        <span class="invalid-feedback d-block text-start">{{ $message }}</span>
                    @enderror
                </div>

                <label class="col-md-2 col-form-label">Apellido materno <span style="color:#FF5A6A;">(*)</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control @error('apellidoMaternoEstudiante') is-invalid @enderror"
                        id="apellidoMaternoEstudiante" name="apellidoMaternoEstudiante"
                        placeholder="Ingrese el apellido materno" maxlength="100"
                        value="{{ old('apellidoMaternoEstudiante') }}">
                    @error('apellidoMaternoEstudiante')
                        <span class="invalid-feedback d-block text-start">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Nombres --}}
            <div class="row form-group">
                <label class="col-md-2 col-form-label">Nombres <span style="color:#FF5A6A;">(*)</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control @error('nombreEstudiante') is-invalid @enderror"
                        id="nombreEstudiante" name="nombreEstudiante" placeholder="Ingrese los nombres completos"
                        maxlength="100" value="{{ old('nombreEstudiante') }}">
                    @error('nombreEstudiante')
                        <span class="invalid-feedback d-block text-start">{{ $message }}</span>
                    @enderror
                </div>
                <label class="col-md-2 col-form-label">Sexo <span style="color:#FF5A6A;">(*)</span></label>
                <div class="col-md-4">
                    <select class="form-control @error('generoEstudiante') is-invalid @enderror" id="generoEstudiante"
                        name="generoEstudiante">
                        <option value="" disabled {{ old('generoEstudiante') == '' ? 'selected' : '' }}>
                            Seleccione el sexo</option>
                        <option value="M" {{ old('generoEstudiante') == 'M' ? 'selected' : '' }}>Masculino
                        </option>
                        <option value="F" {{ old('generoEstudiante') == 'F' ? 'selected' : '' }}>Femenino
                        </option>
                    </select>
                    @error('generoEstudiante')
                        <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Género y DNI --}}
            <div class="row form-group">

                <label class="col-md-2 col-form-label">N.° DNI <span style="color:#FF5A6A;">(*)</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control @error('dniEstudiante') is-invalid @enderror"
                        id="dniEstudiante" name="dniEstudiante" maxlength="8" placeholder="Ingerese N.° DNI"
                        value="{{ old('dniEstudiante') }}" inputmode="numeric">
                    @error('dniEstudiante')
                        <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                    @enderror
                    <div id="dni-error" class="mt-1 d-none" style="font-size: smaller; color: #dc3545;">
                        Ya existe un estudiante registrado con este N.° de DNI.
                    </div>
                </div>

                <label class="col-md-2 col-form-label">Fecha de Nacimiento <span
                        style="color:#FF5A6A;">(*)</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control @error('fechaNacimientoEstudiante') is-invalid @enderror"
                        id="fechaNacimientoEstudiante" name="fechaNacimientoEstudiante" placeholder="YYYY-MM-DD"
                        value="{{ old('fechaNacimientoEstudiante') }}"
                        style="background-color: white !important; color:black !important">
                    @error('fechaNacimientoEstudiante')
                        <div class="invalid-feedback d-block text-start feedback-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- Observaciones --}}
            <div class="row form-group">
                <label class="col-md-2 col-form-label">Observaciones</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="referencia_" name="referencia_"
                        placeholder="Agregue observaciones sobre el estudiante" maxlength="100">
                </div>
            </div>


        </div>
    </div>

    {{-- Sección foto --}}
    <div class="card" style="border: none">
        <div
            style="background: #E0F7FA; color: #0A8CB3; font-weight: bold; border: 2px solid #86D2E3; border-bottom: 2px solid #86D2E3; padding: 6px 20px; border-radius:4px 4px 0px 0px;">
            <i class="icon-camera mr-2"></i>
            Foto de Identificación
        </div>
        <div class="card-body"
            style="border: 2px solid #86D2E3; border-top: none; border-radius: 0px 0px 4px 4px !important;">
            <div class="row form-group align-items-center">
                <label class="col-md-2 col-form-label">
                    Foto del estudiante
                </label>

                <div class="col-md-10" id="seleccionar">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="foto" id="foto"
                            accept="image/*" onchange="previewImage(event)">
                        <label class="custom-file-label text-2xs" for="foto" id="foto-label"
                            style="border-color: #DAA520; font-size:x-small !important"></label>
                        <span id="mostrarTexto" style="color:#FF5A6A; font-size:0.7rem">Tamaño
                            carné o según los requisitos de la I. E.</span>

                    </div>
                </div>

                <div class="col-md-3 text-center">
                    <img id="img-preview" src="#" alt="Vista previa" class="img-fluid rounded d-none mt-2"
                        style="min-height: 160px; max-height: 160px; border: 1px solid #DAA520; padding: 4px;">
                </div>
            </div>
        </div>
    </div>

</div>


{{-- Estilos --}}
<style>
    .form-control.custom-gold {
        border: 1.5px solid #DAA520 !important;
        background-color: white !important;
    }

    .custom-file-label::after {
        content: "Seleccionar" !important;
        font-size: small;
        background-color: #DAA520;
        color: white;
        border-left: none;
    }

    @media (max-width: 576px) {
        .margen-movil {
            margin-left: -29px !important;
            margin-right: -29px !important;
        }
    }
</style>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
    // Verificación DNI
    $('#dniEstudiante').on('input', function() {
        const dni = $(this).val();
        if (dni.length === 8) {
            $.get('{{ route('verificar.dni') }}', {
                dni
            }, function(response) {
                if (response.existe) {
                    $('#dni-error').removeClass('d-none');
                    $('#dniEstudiante').addClass('is-invalid');
                } else {
                    $('#dni-error').addClass('d-none');
                    $('#dniEstudiante').removeClass('is-invalid');
                }
            });
        } else {
            $('#dni-error').addClass('d-none');
            $('#dniEstudiante').removeClass('is-invalid');
        }
    });

    // Flatpickr
    flatpickr("#fechaNacimientoEstudiante", {
        dateFormat: "Y-m-d",
        maxDate: "today",
        locale: "es",
        onChange: (selectedDates, dateStr, instance) => {
            const input = instance.input;
            const feedback = input.parentElement.querySelector('.feedback-message');
            if (dateStr) {
                input.classList.remove('is-invalid');
                if (feedback) feedback.remove();
                input.classList.add('is-valid');
            }
        }
    });

    function previewImage(event) {
        const input = event.target;
        const label = document.getElementById('foto-label');
        const preview = document.getElementById('img-preview');
        const mostrar = document.getElementById('seleccionar');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validación estricta del tipo MIME
            if (!file.type.startsWith('image/')) {
                alert('Por favor, seleccione solo archivos de imagen.');
                input.value = ''; // Limpia el campo
                label.textContent = 'Seleccionar imagen';
                preview.classList.add('d-none');
                preview.src = '#';
                return;
            }

            label.textContent = file.name;

            // Mostrar imagen en vista previa
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
        //son para el campo de buscar, pasa de 10 a 7 columnas
        mostrar.classList.remove('col-md-10');
        mostrar.classList.add('col-md-7');



    }
</script>
