@extends('cplantilla.bprincipal')
@section('titulo', 'Crear Nuevo Docente')
@section('contenidoplantilla')
<style>
    .form-bordered {
        margin: 0;
        border: none;
        padding-top: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #eaedf1;
    }

    .card-body.info {
        background: #f3f3f3;
        border-bottom: 1px solid rgba(0, 0, 0, .125);
        border-top: 1px solid rgba(0, 0, 0, .125);
        color: #F59D24;
    }

    .card-body.info p {
        margin-bottom: 0px;
        font-family: "Quicksand", sans-serif;
        font-weight: 600;
        color: #004a92;
    }

    .estilo-info {
        margin-bottom: 0px;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
    }

    .btn-primary {
        background: #007bff !important;
        border: none;
        transition: background-color 0.2s ease, transform 0.1s ease;
        margin: 0;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
        font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
    }

    .btn-primary:hover {
        background-color: #0056b3 !important;
        transform: scale(1.01);
    }

    .btn-secondary {
        background: #6c757d !important;
        border: none;
        transition: background-color 0.2s ease, transform 0.1s ease;
        font-family: "Quicksand", sans-serif;
        font-weight: 700;
    }

    .btn-secondary:hover {
        background-color: #545b62 !important;
        transform: scale(1.01);
    }

    .is-valid {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }

    #loaderPrincipal[style*="display: flex"] {
        display: flex !important;
        justify-content: center;
        align-items: center;
        position: absolute !important;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        z-index: 2000;
    }

    .persona-info {
        background: #e8f4f8;
        border: 2px solid #0A8CB3;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .persona-info h5 {
        color: #0A8CB3;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .persona-detail-row {
        margin-bottom: 8px;
        color: #333;
    }

    .persona-detail-row strong {
        color: #004a92;
        font-weight: 600;
    }

    .alert-info-auto {
        background: #fff3cd;
        border: 2px solid #ffc107;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .alert-info-auto .icon-auto {
        color: #ffc107;
        font-size: 1.5rem;
    }

    .alert-info-auto p {
        margin-bottom: 0;
        color: #856404;
        font-weight: 600;
    }

    .roles-display {
        margin-top: 15px;
    }

    .roles-display .badge {
        font-size: 0.9rem;
        padding: 6px 12px;
    }
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
                    <i class="fas fa-chalkboard-teacher m-1"></i>&nbsp;Registrar Nuevo Docente
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x" style="color: #0A8CB3;"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p class="mb-0" style="font-size:1.1rem; color:#004a92; font-weight:700;">
                                Complete el siguiente formulario para registrar un nuevo docente. Los campos marcados con * son obligatorios.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-3 pb-2" style="background-color: #f8fbff !important; border: 1px solid #0A8CB3; margin-top: 18px;">
                        
                        <!-- Alerta informativa sobre credenciales automáticas -->
                        <div class="alert-info-auto">
                            <div class="d-flex align-items-center">
                                <div class="icon-auto mr-3">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <p style="font-size: 1rem;">
                                        <strong>Generación Automática de Credenciales:</strong> El usuario, contraseña y correo institucional se generarán automáticamente y serán enviados al email de la persona registrada.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('docentes.store') }}" id="formDocente">
                            @csrf

                            <input type="hidden" name="id_persona" value="{{ $personaPreseleccionada->id_persona ?? '' }}">

                            <!-- Información de la persona seleccionada -->
                            @if(isset($personaPreseleccionada))
                            <div class="persona-info">
                                <h5><i class="fas fa-user-circle mr-2"></i>Información de la Persona</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="persona-detail-row">
                                            <strong><i class="fas fa-user mr-2"></i>Nombre Completo:</strong> {{ $personaPreseleccionada->nombres }} {{ $personaPreseleccionada->apellidos }}
                                        </div>
                                        <div class="persona-detail-row">
                                            <strong><i class="fas fa-id-card mr-2"></i>DNI:</strong> {{ $personaPreseleccionada->dni ?? 'No especificado' }}
                                        </div>
                                        <div class="persona-detail-row">
                                            <strong><i class="fas fa-envelope mr-2"></i>Email Personal:</strong> {{ $personaPreseleccionada->email ?? 'No especificado' }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="persona-detail-row">
                                            <strong><i class="fas fa-phone mr-2"></i>Teléfono:</strong> {{ $personaPreseleccionada->telefono ?? 'No especificado' }}
                                        </div>
                                        <div class="persona-detail-row">
                                            <strong><i class="fas fa-venus-mars mr-2"></i>Género:</strong> {{ $personaPreseleccionada->genero ?? 'No especificado' }}
                                        </div>
                                        <div class="persona-detail-row">
                                            <strong><i class="fas fa-map-marker-alt mr-2"></i>Dirección:</strong> {{ $personaPreseleccionada->direccion ?? 'No especificado' }}
                                        </div>
                                    </div>
                                </div>
                                
                                @if(isset($personaPreseleccionada->roles) && $personaPreseleccionada->roles->count() > 0)
                                <div class="roles-display">
                                    <strong><i class="fas fa-user-tag mr-2"></i>Roles Asignados:</strong>
                                    <div class="mt-2">
                                        @foreach($personaPreseleccionada->roles as $rol)
                                            <span class="badge badge-info mr-1">{{ $rol->nombre }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif

                            <!-- Campos del formulario de docente -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="especialidad"><i class="fas fa-graduation-cap mr-2"></i>Especialidad *</label>
                                        <select class="form-control @error('especialidad') is-invalid @enderror" 
                                                id="especialidad" 
                                                name="especialidad" 
                                                required>
                                            <option value="">Seleccione una especialidad</option>
                                            <option value="Ingeniería de Sistemas" {{ old('especialidad') == 'Ingeniería de Sistemas' ? 'selected' : '' }}>Ingeniería de Sistemas</option>
                                            <option value="Ingeniería de Software" {{ old('especialidad') == 'Ingeniería de Software' ? 'selected' : '' }}>Ingeniería de Software</option>
                                            <option value="Ciencias de la Computación" {{ old('especialidad') == 'Ciencias de la Computación' ? 'selected' : '' }}>Ciencias de la Computación</option>
                                            <option value="Matemáticas" {{ old('especialidad') == 'Matemáticas' ? 'selected' : '' }}>Matemáticas</option>
                                            <option value="Estadística" {{ old('especialidad') == 'Estadística' ? 'selected' : '' }}>Estadística</option>
                                            <option value="Física" {{ old('especialidad') == 'Física' ? 'selected' : '' }}>Física</option>
                                            <option value="Química" {{ old('especialidad') == 'Química' ? 'selected' : '' }}>Química</option>
                                            <option value="Biología" {{ old('especialidad') == 'Biología' ? 'selected' : '' }}>Biología</option>
                                            <option value="Ingeniería Industrial" {{ old('especialidad') == 'Ingeniería Industrial' ? 'selected' : '' }}>Ingeniería Industrial</option>
                                            <option value="Ingeniería Civil" {{ old('especialidad') == 'Ingeniería Civil' ? 'selected' : '' }}>Ingeniería Civil</option>
                                            <option value="Ingeniería Mecánica" {{ old('especialidad') == 'Ingeniería Mecánica' ? 'selected' : '' }}>Ingeniería Mecánica</option>
                                            <option value="Ingeniería Eléctrica" {{ old('especialidad') == 'Ingeniería Eléctrica' ? 'selected' : '' }}>Ingeniería Eléctrica</option>
                                            <option value="Ingeniería Electrónica" {{ old('especialidad') == 'Ingeniería Electrónica' ? 'selected' : '' }}>Ingeniería Electrónica</option>
                                            <option value="Arquitectura" {{ old('especialidad') == 'Arquitectura' ? 'selected' : '' }}>Arquitectura</option>
                                            <option value="Administración de Empresas" {{ old('especialidad') == 'Administración de Empresas' ? 'selected' : '' }}>Administración de Empresas</option>
                                            <option value="Contabilidad" {{ old('especialidad') == 'Contabilidad' ? 'selected' : '' }}>Contabilidad</option>
                                            <option value="Economía" {{ old('especialidad') == 'Economía' ? 'selected' : '' }}>Economía</option>
                                            <option value="Derecho" {{ old('especialidad') == 'Derecho' ? 'selected' : '' }}>Derecho</option>
                                            <option value="Psicología" {{ old('especialidad') == 'Psicología' ? 'selected' : '' }}>Psicología</option>
                                            <option value="Educación" {{ old('especialidad') == 'Educación' ? 'selected' : '' }}>Educación</option>
                                            <option value="Comunicación" {{ old('especialidad') == 'Comunicación' ? 'selected' : '' }}>Comunicación</option>
                                            <option value="Diseño Gráfico" {{ old('especialidad') == 'Diseño Gráfico' ? 'selected' : '' }}>Diseño Gráfico</option>
                                            <option value="Marketing" {{ old('especialidad') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                            <option value="Turismo" {{ old('especialidad') == 'Turismo' ? 'selected' : '' }}>Turismo</option>
                                            <option value="Otra" {{ old('especialidad') == 'Otra' ? 'selected' : '' }}>Otra</option>
                                        </select>
                                        @error('especialidad')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Área de especialización del docente</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_contratacion"><i class="fas fa-calendar-alt mr-2"></i>Fecha de Contratación *</label>
                                        <input type="date" class="form-control @error('fecha_contratacion') is-invalid @enderror" 
                                               id="fecha_contratacion" 
                                               name="fecha_contratacion" 
                                               value="{{ old('fecha_contratacion', date('Y-m-d')) }}" 
                                               required
                                               max="{{ date('Y-m-d') }}">
                                        @error('fecha_contratacion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Fecha en que se contrató al docente</small>
                                    </div>
                                </div>
                            </div>

           

                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>Registrar Docente
                                        </button>
                                        <a href="{{ route('docentes.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        const form = document.getElementById('formDocente');

        // Ocultar loader al cargar
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Mostrar loader al enviar formulario
        if (form) {
            form.addEventListener('submit', function() {
                if (loader && contenido) {
                    loader.style.display = 'flex';
                    contenido.style.opacity = '0.5';
                }
            });
        }

        // Validación de fecha de contratación (no puede ser futura)
        const fechaContratacion = document.getElementById('fecha_contratacion');
        if (fechaContratacion) {
            fechaContratacion.addEventListener('change', function() {
                const fechaSeleccionada = new Date(this.value);
                const fechaActual = new Date();
                fechaActual.setHours(0, 0, 0, 0);

                if (fechaSeleccionada > fechaActual) {
                    this.setCustomValidity('La fecha de contratación no puede ser futura');
                    this.reportValidity();
                } else {
                    this.setCustomValidity('');
                }
            });
        }

        // Validación en tiempo real de especialidad
        const especialidad = document.getElementById('especialidad');
        if (especialidad) {
            especialidad.addEventListener('change', function() {
                if (this.value) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        }

        // Manejar evento pageshow para ocultar loader al volver atrás
        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection