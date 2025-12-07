@extends('cplantilla.bprincipal')
@section('titulo', 'Editar Secretaria')
@section('contenidoplantilla')
<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary { background: #007bff !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary:hover { background-color: #0056b3 !important; transform: scale(1.01); }
    .btn-secondary { background: #6c757d !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .btn-secondary:hover { background-color: #545b62 !important; transform: scale(1.01); }
    .form-control { border: 1px solid #ced4da; border-radius: 4px; padding: 10px 15px; font-size: 0.9rem; }
    .form-control:focus { border-color: #0A8CB3; box-shadow: 0 0 0 0.2rem rgba(10, 140, 179, 0.25); }
    .form-label { font-weight: 600; color: #0A8CB3; margin-bottom: 5px; }
    .required-field::after { content: " *"; color: #dc3545; }
    .section-title { color: #0A8CB3; border-bottom: 2px solid #0A8CB3; padding-bottom: 8px; margin-bottom: 20px; font-weight: 700; }
    .form-section { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #0A8CB3; }
    #loaderPrincipal[style*="display: flex"] { display: flex !important; justify-content: center; align-items: center; position: absolute !important; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: 2000; }
    .invalid-feedback { display: block; }
    
    /* Spinner para el loader */
    .spinner-container {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    .circle {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        animation: float 1s infinite ease-in-out;
    }
    .c1 { background-color: #0A8CB3; animation-delay: 0s; }
    .c2 { background-color: #FF5A6A; animation-delay: 0.1s; }
    .c3 { background-color: #FFD700; animation-delay: 0.2s; }
    .c4 { background-color: #000000; animation-delay: 0.3s; }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
</style>

<div class="container-fluid" id="contenido-principal" style="position: relative;">
    @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])

    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12">
            <div class="box_block">
                <!-- Header optimizado -->
                <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                    data-toggle="collapse" data-target="#collapseExample0" aria-expanded="true"
                    aria-controls="collapseExample"
                    style="background: #0A8CB3 !important; font-weight: bold; color: white;">
                    <i class="fas fa-user-edit m-1"></i>&nbsp;Editar Secretaria: {{ $secretaria->persona->nombres }} {{ $secretaria->persona->apellidos }}
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>

                <!-- Información contextual -->
                <div class="card-body info">
                    <div class="d-flex">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>En esta sección, puedes editar la información laboral de la secretaria seleccionada.</p>
                            <p>Estimado Usuario: Para modificar datos personales (nombres, DNI, etc.), usa la sección de edición de personas.</p>
                        </div>
                    </div>
                </div>

                <!-- Contenido colapsable -->
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-0 pb-2"
                        style="background-color: #fcfffc !important">

                        <!-- Formulario de edición SIMPLIFICADO -->
                        <form action="{{ route('secretarias.update', $secretaria->id_secretaria) }}" method="POST" id="editForm">
                            @csrf
                            @method('PUT')
                            
                            {{-- Mensajes de error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mb-4">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <h5><i class="fas fa-exclamation-triangle"></i> Errores de validación:</h5>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Información de Persona (solo lectura) --}}
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-user"></i> Información Personal (Solo Lectura)
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">DNI</label>
                                        <input type="text" class="form-control" value="{{ $secretaria->persona->dni }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Nombres</label>
                                        <input type="text" class="form-control" value="{{ $secretaria->persona->nombres }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" value="{{ $secretaria->persona->apellidos }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <a href="{{ route('personas.edit', $secretaria->persona->id_persona) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt"></i> Editar datos personales
                                    </a>
                                </div>
                            </div>

                            {{-- SECCIÓN: Datos de Secretaria (editables) --}}
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-briefcase"></i> Datos de Secretaria
                                </h5>

                                <div class="row">
                                    {{-- Email Universitario --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="emailUniversidad" class="form-label required-field">Email Universitario</label>
                                        <input type="email" 
                                               class="form-control @error('emailUniversidad') is-invalid @enderror" 
                                               id="emailUniversidad" 
                                               name="emailUniversidad" 
                                               value="{{ old('emailUniversidad', $secretaria->emailUniversidad) }}"
                                               required
                                               placeholder="correo@universidad.edu.pe">
                                        @error('emailUniversidad')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Este será el email de acceso al sistema.
                                        </small>
                                    </div>

                                    {{-- Fecha de Ingreso --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                                        <input type="date" 
                                               class="form-control @error('fecha_ingreso') is-invalid @enderror" 
                                               id="fecha_ingreso" 
                                               name="fecha_ingreso" 
                                               value="{{ old('fecha_ingreso', optional($secretaria->fecha_ingreso)->format('Y-m-d')) }}">
                                        @error('fecha_ingreso')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Estado --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="estado" class="form-label required-field">Estado</label>
                                        <select class="form-control @error('estado') is-invalid @enderror" 
                                                id="estado" 
                                                name="estado" 
                                                required>
                                            <option value="Activo" {{ old('estado', $secretaria->estado) == 'Activo' ? 'selected' : '' }}>
                                                Activo
                                            </option>
                                            <option value="Inactivo" {{ old('estado', $secretaria->estado) == 'Inactivo' ? 'selected' : '' }}>
                                                Inactivo
                                            </option>
                                        </select>
                                        @error('estado')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de acción CENTRADOS -->
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <button type="submit" class="btn btn-primary" style="width: 200px; height: 38px; padding: 6px 12px;">
                                            <i class="fas fa-save"></i> Actualizar Secretaria
                                        </button>
                                        <button type="button" onclick="window.location.href='{{ route('secretarias.index') }}'"
                                            class="btn btn-secondary" style="width: 120px; height: 38px; padding: 6px 12px;">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /**
     * Funciones para el formulario de edición de secretaria
     */

    // Función para mostrar indicador de carga
    function showLoading() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) {
            loader.style.display = 'flex';
            loader.innerHTML = `
                <div class="text-center">
                    <div class="spinner-container">
                        <div class="circle c1"></div>
                        <div class="circle c2"></div>
                        <div class="circle c3"></div>
                        <div class="circle c4"></div>
                    </div>
                    <div class="mt-3">
                        <h5 class="text-white">Procesando...</h5>
                    </div>
                </div>
            `;
        }
        if (contenido) contenido.style.opacity = '0.5';
    }

    $(document).ready(function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Loader para botón cancelar
        $(document).on('click', '.btn-secondary', function(e) {
            if ($(this).attr('onclick') && $(this).attr('onclick').includes('window.location.href')) {
                e.preventDefault();
                showLoading();
                setTimeout(() => {
                    window.location.href = "{{ route('secretarias.index') }}";
                }, 800);
            }
        });

        // Validación del formulario
        $('#editForm').on('submit', function(e) {
            // Verificar que el email tenga formato válido
            var email = $('#emailUniversidad').val();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            
            if (!emailRegex.test(email)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Email inválido',
                    text: 'Por favor, ingresa un email válido.',
                    confirmButtonColor: '#007bff'
                });
                return false;
            }

            // Mostrar confirmación antes de enviar
            e.preventDefault();
            
            Swal.fire({
                title: '¿Actualizar secretaria?',
                text: 'Se actualizarán los datos laborales de la secretaria.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar indicador de carga
                    showLoading();
                    
                    // Deshabilitar botón y cambiar texto
                    const guardarBtn = $('.btn-primary[type="submit"]');
                    if (guardarBtn.length) {
                        guardarBtn.prop('disabled', true);
                        guardarBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
                    }
                    
                    // Enviar formulario
                    $('#editForm').off('submit').submit();
                }
            });
        });

        // Mostrar mensajes de éxito o error con SweetAlert2
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#007bff',
                timer: 3000,
                timerProgressBar: true
            }).then(() => {
                window.location.href = "{{ route('secretarias.index') }}";
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session("error") }}',
                confirmButtonColor: '#007bff'
            }).then(() => {
                const guardarBtn = $('.btn-primary[type="submit"]');
                if (guardarBtn.length) {
                    guardarBtn.prop('disabled', false);
                    guardarBtn.html('<i class="fas fa-save"></i> Actualizar Secretaria');
                }
                if (loader) loader.style.display = 'none';
            });
        @endif

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
            
            // Restaurar botón de guardar si existe
            const guardarBtn = $('.btn-primary[type="submit"]');
            if (guardarBtn.length) {
                guardarBtn.prop('disabled', false);
                guardarBtn.html('<i class="fas fa-save"></i> Actualizar Secretaria');
            }
        });
    });
</script>
@endsection