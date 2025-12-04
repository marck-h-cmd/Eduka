@extends('cplantilla.bprincipal')
@section('titulo', 'Gestión de Secretarias')
@section('contenidoplantilla')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus"></i> Asignar Rol de Secretaria
                    </h4>
                </div>

                <form action="{{ route('secretarias.store') }}" method="POST" id="formAsignarSecretaria">
                    @csrf
                    
                    <div class="card-body">
                        {{-- Mensajes de error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h5><i class="fas fa-exclamation-triangle"></i> Errores de validación:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Información del proceso --}}
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Proceso de asignación:</h6>
                            <ol class="mb-0">
                                <li>Selecciona una persona existente de la lista</li>
                                <li>Completa los datos específicos de secretaria</li>
                                <li>Se asignará automáticamente el rol de "Secretaria"</li>
                                <li>Se creará un usuario con credenciales que serán enviadas por email</li>
                            </ol>
                        </div>

                        {{-- SECCIÓN 1: Selección de Persona --}}
                        <div class="border-bottom pb-3 mb-4">
                            <h5 class="text-primary">
                                <i class="fas fa-user"></i> Paso 1: Seleccionar Persona
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_persona">Persona <span class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('id_persona') is-invalid @enderror" 
                                            id="id_persona" 
                                            name="id_persona" 
                                            required>
                                        <option value="">-- Seleccione una persona --</option>
                                        @foreach($personas as $persona)
                                            <option value="{{ $persona['id_persona'] }}" 
                                                    {{ old('id_persona') == $persona['id_persona'] ? 'selected' : '' }}>
                                                {{ $persona['dni'] }} - {{ $persona['nombre_completo'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_persona')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Solo aparecen personas que NO tienen asignado el rol de Secretaria
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Información de la persona seleccionada --}}
                        <div id="info-persona" class="alert alert-secondary" style="display: none;">
                            <h6><i class="fas fa-user-circle"></i> Información de la persona seleccionada:</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>DNI:</strong> <span id="persona-dni"></span>
                                </div>
                                <div class="col-md-8">
                                    <strong>Nombre completo:</strong> <span id="persona-nombre"></span>
                                </div>
                            </div>
                        </div>

                        {{-- SECCIÓN 2: Datos de Secretaria --}}
                        <div class="border-bottom pb-3 mb-4 mt-4">
                            <h5 class="text-primary">
                                <i class="fas fa-briefcase"></i> Paso 2: Datos de Secretaria
                            </h5>
                        </div>

                        <div class="row">
                            {{-- Email Universitario --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emailUniversidad">
                                        Email Universitario <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('emailUniversidad') is-invalid @enderror" 
                                           id="emailUniversidad" 
                                           name="emailUniversidad" 
                                           placeholder="secretaria@unitru.edu.pe"
                                           value="{{ old('emailUniversidad') }}"
                                           required>
                                    @error('emailUniversidad')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-key"></i> 
                                        Este email será usado para acceder al sistema
                                    </small>
                                </div>
                            </div>

                            {{-- Fecha de Ingreso --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                                    <input type="date" 
                                           class="form-control @error('fecha_ingreso') is-invalid @enderror" 
                                           id="fecha_ingreso" 
                                           name="fecha_ingreso" 
                                           value="{{ old('fecha_ingreso', date('Y-m-d')) }}">
                                    @error('fecha_ingreso')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Resumen de acciones --}}
                        <div class="alert alert-success mt-3">
                            <h6><i class="fas fa-check-circle"></i> Al guardar se realizarán las siguientes acciones:</h6>
                            <ul class="mb-0">
                                <li>✅ Se registrará en la tabla <code>secretarias</code></li>
                                <li>✅ Se asignará el rol "Secretaria" en <code>persona_roles</code></li>
                                <li>✅ Se creará un usuario automáticamente en <code>usuarios</code></li>
                                <li>✅ Se generará un username basado en nombre y apellido</li>
                                <li>✅ Se generará una contraseña temporal automáticamente</li>
                                <li>✅ Se enviarán las credenciales al email universitario</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('secretarias.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Asignar Rol de Secretaria
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar Select2
        $('#id_persona').select2({
            theme: 'bootstrap4',
            placeholder: '-- Seleccione una persona --',
            allowClear: true,
            language: {
                noResults: function() {
                    return "No se encontraron resultados";
                },
                searching: function() {
                    return "Buscando...";
                }
            }
        });

        // Mostrar información de la persona seleccionada
        $('#id_persona').on('change', function() {
            var selectedText = $(this).find('option:selected').text();
            
            if ($(this).val()) {
                var parts = selectedText.split(' - ');
                var dni = parts[0];
                var nombre = parts[1];
                
                $('#persona-dni').text(dni);
                $('#persona-nombre').text(nombre);
                $('#info-persona').slideDown();
            } else {
                $('#info-persona').slideUp();
            }
        });

        // Validación del formulario
        $('#formAsignarSecretaria').on('submit', function(e) {
            if (!$('#id_persona').val()) {
                e.preventDefault();
                alert('Por favor, seleccione una persona');
                $('#id_persona').focus();
                return false;
            }

            if (!$('#emailUniversidad').val()) {
                e.preventDefault();
                alert('Por favor, ingrese el email universitario');
                $('#emailUniversidad').focus();
                return false;
            }

            // Confirmar antes de enviar
            return confirm('¿Está seguro de asignar el rol de Secretaria a esta persona? Se creará un usuario y se enviarán las credenciales por email.');
        });
    });
</script>
@endpush