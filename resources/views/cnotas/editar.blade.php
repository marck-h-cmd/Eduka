@extends('cplantilla.bprincipal')
@section('titulo','Registro de Notas')
@section('contenidoplantilla')
<style>
        .estilo-info {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;

        }

        @media (max-width: 576px) {
            .margen-movil {
                margin-left: -29px !important;
                margin-right: -29px !important;
            }

            .margen-movil-2 {
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>

<div class="container-fluid margen-movil-2">
    <div class="row mt-4 mr-1 ml-1">
        <div class="col-md-12">
            <div class="card">
                <!-- Cabecera de la tarjeta con el nombre de la asignatura y detalles del curso -->
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="background-color: #1e5981 !important;">
                    <h4 class="mb-0">
                        <i class="fas fa-list-alt"></i> Registro de Notas: {{ $asignatura->nombre }}
                    </h4>
                    <span>{{ $curso->grado->nombre }} {{ $curso->grado->nivel->nombre }} "{{ $curso->seccion->nombre }}" - {{ $curso->anoLectivo->nombre }}</span>
                </div>
                <div class="card-body">
                    <!-- Información del período actual de evaluación -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Período actual de evaluación: <strong>{{ $periodoActual->nombre }}</strong> ({{ $periodoActual->fecha_inicio->format('d/m/Y') }} - {{ $periodoActual->fecha_fin->format('d/m/Y') }})
                    </div>

                    <!-- Formulario para guardar las notas -->
                    <form action="{{ route('notas.actualizar') }}" method="POST" id="formNotas">
                        @csrf
                        <!-- IDs ocultos para identificar el curso y el período -->
                        <input type="hidden" name="curso_asignatura_id" value="{{ $cursoAsignatura->curso_asignatura_id }}">
                        <input type="hidden" name="periodo_id" value="{{ $periodoActual->periodo_id }}">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover border">
                                <thead class="bg-light">
                                    <tr>
                                        <th>N° Matrícula</th>
                                        <th>Estudiante</th>
                                        <!-- Encabezados de los períodos de evaluación -->
                                        @foreach($periodos as $periodo)
                                            <th class="{{ $periodo->periodo_id == $periodoActual->periodo_id ? 'bg-warning text-dark' : '' }}">
                                                {{ $periodo->nombre }}
                                            </th>
                                        @endforeach
                                        <th>Promedio</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Itera sobre cada estudiante y muestra sus notas -->
                                    @forelse($notasEstudiantes as $index => $item)
                                        <tr>
                                            <td>{{ $item['numero_matricula'] }}</td>
                                            <td>{{ $item['estudiante'] }}</td>

                                            <!-- Muestra las notas de cada período para el estudiante -->
                                            @foreach($item['notas_periodos'] as $notaPeriodo)
                                                <td class="{{ $notaPeriodo['editable'] ? 'bg-light-warning' : '' }}">
                                                    @if($notaPeriodo['editable'])
                                                        <!-- Campo editable solo para el período actual -->
                                                        <input type="hidden" name="notas[{{ $index }}][matricula_id]" value="{{ $item['matricula_id'] }}">
                                                        <input type="number"
                                                               name="notas[{{ $index }}][calificacion]"
                                                               class="form-control form-control-sm"
                                                               min="0"
                                                               max="20"
                                                               step="0.01"
                                                               value="{{ $notaPeriodo['nota'] }}"
                                                               placeholder="0-20">
                                                    @else
                                                        <!-- Nota no editable o guion si no hay nota -->
                                                        {{ $notaPeriodo['nota'] ?? '-' }}
                                                    @endif
                                                </td>
                                            @endforeach

                                            <!-- Promedio del estudiante -->
                                            <td class="fw-bold">{{ $item['promedio'] ?? 'Pendiente' }}</td>
                                            <!-- Observaciones para el estudiante -->
                                            <td>
                                                @if($periodoActual)
                                                    <input type="text"
                                                           name="notas[{{ $index }}][observaciones]"
                                                           class="form-control form-control-sm"
                                                           maxlength="255"
                                                           placeholder="Observaciones para {{ $item['estudiante'] }}"
                                                           value="{{ $notaPeriodo['observaciones'] ?? '' }}">

                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- Mensaje si no hay estudiantes matriculados -->
                                        <tr>
                                            <td colspan="{{ count($periodos) + 4 }}" class="text-center">No hay estudiantes matriculados en este curso</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Botones para regresar o guardar -->
                        <div class="d-flex justify-content-center mt-4 gap-4">
                            <a href="{{ route('notas.inicio') }}" class="btn btn-secondary me-2 mr-4 w-100"  style="font-weight:bold">
                                <i class="fas fa-arrow-left mx-2"></i> Regresar
                            </a>
                            <button type="button" id="btnGuardarNotas" class="btn btn-success w-100"  style="font-weight:bold">
                                <i class="fas fa-save mx-2"></i> Guardar Calificaciones
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos para resaltar el período editable y ajustar los campos de entrada -->
<style>
    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
    .form-control-sm {
        height: 30px;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>

@endsection

@section('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script para mensajes globales con SweetAlert2 -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mensajes de éxito
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        @endif

        // Mensajes de error
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Entendido'
        });
        @endif

        // Mensajes de información
        @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Información',
            text: '{{ session('info') }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
        @endif

        // Verificar si la página fue cargada correctamente a través del formulario
        @if(!session()->has('edicion_notas'))
            Swal.fire({
                icon: 'error',
                title: 'Acceso incorrecto',
                text: 'Por favor, acceda a través del formulario de selección de curso y asignatura',
                confirmButtonColor: '#d33',
                allowOutsideClick: false
            }).then((result) => {
                window.location.href = '{{ route("notas.inicio") }}';
            });
        @endif

        // Agregar validación para los campos de calificación
        const notasInputs = document.querySelectorAll('input[name^="notas"][name$="[calificacion]"]');

        // Aplicar validación a cada campo de nota
        notasInputs.forEach(input => {
            // Validación mientras el usuario escribe
            input.addEventListener('input', function() {
                validarNota(this);
            });

            // Validación cuando el campo pierde el foco
            input.addEventListener('blur', function() {
                validarNota(this, true);
            });
        });

        // Función para validar que la nota esté entre 0 y 20
        function validarNota(input, showMessage = false) {
            const valor = parseFloat(input.value);

            // Si el campo está vacío, es válido (se considera como nota no registrada)
            if (input.value === '') {
                input.classList.remove('is-invalid');
                input.classList.remove('is-valid');
                return true;
            }

            // Verificar si el valor es un número y está en el rango correcto
            if (isNaN(valor) || valor < 0 || valor > 20) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');

                if (showMessage) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Valor incorrecto',
                        text: 'La nota debe ser un número entre 0 y 20',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }

                return false;
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                return true;
            }
        }

        // Agregar validación al formulario completo antes de enviar
        document.getElementById('btnGuardarNotas').addEventListener('click', function() {
            let formValido = true;
            let notasInvalidas = 0;

            // Verificar todas las notas
            notasInputs.forEach(input => {
                if (!validarNota(input, false)) {
                    formValido = false;
                    notasInvalidas++;
                }
            });

            // Si hay notas inválidas, mostrar mensaje y detener el envío
            if (!formValido) {
                Swal.fire({
                    icon: 'error',
                    title: 'Errores de validación',
                    text: `Hay ${notasInvalidas} nota(s) con valores incorrectos. Las notas deben estar entre 0 y 20.`,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Revisar'
                });
                return;
            }

            // Si todo es válido, confirmar el envío
            Swal.fire({
                title: '¿Guardar calificaciones?',
                text: 'Las calificaciones serán registradas para el período actual',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formNotas').submit();
                }
            });
        });
    });
</script>
@endsection
