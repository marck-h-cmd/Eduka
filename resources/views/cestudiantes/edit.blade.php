@extends('cplantilla.bprincipal')
@section('titulo', 'Editar Estudiante')
@section('contenidoplantilla')
<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary { background: #007bff !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .btn-primary:hover { background-color: #0056b3 !important; transform: scale(1.01); }
    .btn-secondary { background: #6c757d !important; border: none; font-family: "Quicksand", sans-serif; font-weight: 700; }
    .form-control, .form-select { font-family: "Quicksand", sans-serif; border-color: #007bff; }
    .form-label { font-weight: 600; color: #004a92; }
    .invalid-feedback { display: block; }
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
                    <i class="fas fa-user-edit m-1"></i>&nbsp;Editar Estudiante
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex ">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>
                                Modifique los datos del estudiante. Todos los campos marcados con (*) son obligatorios.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-body rounded-0 border-0 pt-3 pb-2" style="background-color: #fcfffc !important">
                        <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST" id="formEditarEstudiante">
                            @csrf
                            @method('PUT')
                            
                            <!-- DATOS PERSONALES -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-user"></i> Datos Personales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombres" class="form-label">Nombres *</label>
                                            <input type="text" 
                                                   class="form-control @error('nombres') is-invalid @enderror" 
                                                   id="nombres" 
                                                   name="nombres" 
                                                   value="{{ old('nombres', $estudiante->persona->nombres) }}"
                                                   required>
                                            @error('nombres')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="apellidos" class="form-label">Apellidos *</label>
                                            <input type="text" 
                                                   class="form-control @error('apellidos') is-invalid @enderror" 
                                                   id="apellidos" 
                                                   name="apellidos" 
                                                   value="{{ old('apellidos', $estudiante->persona->apellidos) }}"
                                                   required>
                                            @error('apellidos')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="dni" class="form-label">DNI *</label>
                                            <input type="text" 
                                                   class="form-control @error('dni') is-invalid @enderror" 
                                                   id="dni" 
                                                   name="dni" 
                                                   maxlength="8"
                                                   value="{{ old('dni', $estudiante->persona->dni) }}"
                                                   required>
                                            @error('dni')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" 
                                                   class="form-control @error('telefono') is-invalid @enderror" 
                                                   id="telefono" 
                                                   name="telefono" 
                                                   maxlength="9"
                                                   value="{{ old('telefono', $estudiante->persona->telefono) }}">
                                            @error('telefono')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="genero" class="form-label">Género</label>
                                            <select class="form-control @error('genero') is-invalid @enderror" 
                                                    id="genero" 
                                                    name="genero">
                                                <option value="">Seleccione</option>
                                                <option value="M" {{ old('genero', $estudiante->persona->genero) == 'M' ? 'selected' : '' }}>Masculino</option>
                                                <option value="F" {{ old('genero', $estudiante->persona->genero) == 'F' ? 'selected' : '' }}>Femenino</option>
                                                <option value="Otro" {{ old('genero', $estudiante->persona->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                            @error('genero')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Personal</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $estudiante->persona->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" 
                                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                                   id="fecha_nacimiento" 
                                                   name="fecha_nacimiento" 
                                                   value="{{ old('fecha_nacimiento', $estudiante->persona->fecha_nacimiento ? $estudiante->persona->fecha_nacimiento->format('Y-m-d') : '') }}">
                                            @error('fecha_nacimiento')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                                      id="direccion" 
                                                      name="direccion" 
                                                      rows="2">{{ old('direccion', $estudiante->persona->direccion) }}</textarea>
                                            @error('direccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- DATOS ACADÉMICOS -->
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Datos Académicos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="emailUniversidad" class="form-label">Email Universitario *</label>
                                            <input type="email" 
                                                   class="form-control @error('emailUniversidad') is-invalid @enderror" 
                                                   id="emailUniversidad" 
                                                   name="emailUniversidad" 
                                                   value="{{ old('emailUniversidad', $estudiante->emailUniversidad) }}"
                                                   required>
                                            @error('emailUniversidad')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="id_escuela" class="form-label">Escuela</label>
                                            <select class="form-control @error('id_escuela') is-invalid @enderror" 
                                                    id="id_escuela" 
                                                    name="id_escuela">
                                                <option value="">Seleccione una escuela</option>
                                                @foreach($escuelas as $escuela)
                                                    <option value="{{ $escuela->id_escuela }}" 
                                                            {{ old('id_escuela', $estudiante->id_escuela) == $escuela->id_escuela ? 'selected' : '' }}>
                                                        {{ $escuela->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_escuela')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="id_curricula" class="form-label">Currícula</label>
                                            <select class="form-control @error('id_curricula') is-invalid @enderror" 
                                                    id="id_curricula" 
                                                    name="id_curricula">
                                                <option value="">Seleccione una currícula</option>
                                                @foreach($curriculas as $curricula)
                                                    <option value="{{ $curricula->id_curricula }}" 
                                                            {{ old('id_curricula', $estudiante->id_curricula) == $curricula->id_curricula ? 'selected' : '' }}>
                                                        {{ $curricula->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_curricula')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="estado" class="form-label">Estado *</label>
                                            <select class="form-control @error('estado') is-invalid @enderror" 
                                                    id="estado" 
                                                    name="estado"
                                                    required>
                                                <option value="Activo" {{ old('estado', $estudiante->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="Egresado" {{ old('estado', $estudiante->estado) == 'Egresado' ? 'selected' : '' }}>Egresado</option>
                                                <option value="Inactivo" {{ old('estado', $estudiante->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('estado')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="anio_ingreso" class="form-label">Año de Ingreso *</label>
                                            <input type="number" 
                                                   class="form-control @error('anio_ingreso') is-invalid @enderror" 
                                                   id="anio_ingreso" 
                                                   name="anio_ingreso" 
                                                   min="1900"
                                                   max="{{ date('Y') + 10 }}"
                                                   value="{{ old('anio_ingreso', $estudiante->anio_ingreso) }}"
                                                   required>
                                            @error('anio_ingreso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anio_egreso" class="form-label">Año de Egreso</label>
                                            <input type="number" 
                                                   class="form-control @error('anio_egreso') is-invalid @enderror" 
                                                   id="anio_egreso" 
                                                   name="anio_egreso" 
                                                   min="1900"
                                                   max="{{ date('Y') + 20 }}"
                                                   value="{{ old('anio_egreso', $estudiante->anio_egreso) }}">
                                            @error('anio_egreso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- BOTONES -->
                            <div class="row mt-4">
                                <div class="col-md-6 mb-2">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary btn-block" id="btnCancelar">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
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
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Validación de números solo en campos numéricos
        document.getElementById('dni').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
        });

        document.getElementById('telefono').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);
        });

        // Loader al cancelar
        document.getElementById('btnCancelar').addEventListener('click', function(e) {
            e.preventDefault();
            if (loader) {
                loader.style.display = 'flex';
            }
            setTimeout(() => {
                window.location.href = this.href;
            }, 800);
        });

        // Mostrar mensajes de error
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                html: '<ul style="text-align: left;">' +
                    @foreach ($errors->all() as $error)
                        '<li>{{ $error }}</li>' +
                    @endforeach
                    '</ul>',
                confirmButtonColor: '#007bff'
            });
        @endif

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection