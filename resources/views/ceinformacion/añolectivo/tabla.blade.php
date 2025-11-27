@if ($anoslectivos->count())
<table class="table table-hover align-middle table-bordered ">
    <thead style="background-color: #1e293b; color: white;">
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Inicio</th>
            <th class="text-center">Fin</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($anoslectivos as $anio)
            <tr>
                <td>{{ $anio->nombre }}</td>
                <td>{{ \Carbon\Carbon::parse($anio->fecha_inicio)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($anio->fecha_fin)->format('d/m/Y') }}</td>
                <td>
                    @if($anio->estado === 'Activo')
                        <span class="badge text-white fw-semibold px-3 py-1 rounded-pill" style="background-color: #0284c7;">
                            Activo
                        </span>
                    @elseif($anio->estado === 'Planificación')
                        <span class="badge text-white fw-semibold px-3 py-1 rounded-pill" style="background-color: #64748b;">
                            Planificación
                        </span>
                    @elseif($anio->estado === 'Finalizado')
                        <span class="badge text-white fw-semibold px-3 py-1 rounded-pill" style="background-color: #7c3aed;">
                            Finalizado
                        </span>
                    @else
                        <span class="badge bg-secondary text-white fw-semibold px-3 py-1 rounded-pill">{{ $anio->estado }}</span>
                    @endif
                </td>
                <td class="text-center">
                    <button class="btn btn-outline-primary btn-sm toggle-detalle" data-id="{{ $anio->ano_lectivo_id }}">
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    @if($anio->estado === 'Finalizado')
                        <button class="btn btn-sm btn-secondary" disabled><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-secondary" disabled><i class="fas fa-trash-alt"></i></button>
                    @else
                        <a href="{{ route('aniolectivo.edit', $anio->ano_lectivo_id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('aniolectivo.destroy', $anio->ano_lectivo_id) }}" method="POST" class="d-inline-block form-eliminar">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>

            <!-- Fila desplegable -->
            <tr class="detalle-fila" id="detalle-{{ $anio->ano_lectivo_id }}" style="display: none;">
                <td colspan="5" class="bg-light text-start align-top">
                    <div class="p-3 text-start">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <p class="mb-1"><i class="fas fa-calendar me-2"></i> <strong>Nombre:</strong> {{ $anio->nombre }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <p class="mb-1"><i class="fas fa-id-badge me-2"></i> <strong>ID:</strong> {{ $anio->ano_lectivo_id }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <p class="mb-1"><i class="fas fa-clock me-2"></i> <strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($anio->fecha_inicio)->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <p class="mb-1"><i class="fas fa-clock me-2"></i> <strong>Fecha de Fin:</strong> {{ \Carbon\Carbon::parse($anio->fecha_fin)->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <p class="mb-1"><i class="fas fa-hourglass-half me-2"></i> <strong>Duración:</strong> {{ $anio->fecha_inicio->diffInDays($anio->fecha_fin) }} días</p>
                            </div>
                            <div class="col-md-12">
                                <p class="mb-1"><i class="fas fa-info-circle me-2"></i> <strong>Descripción:</strong> {{ $anio->descripcion ?? 'Sin descripción' }}</p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Paginación -->
<div class="d-flex justify-content-center">
    {{ $anoslectivos->links() }}
</div>
@else
    <div class="alert alert-info text-center">
        No se encontraron registros de años lectivos.
    </div>
@endif


<!-- Script para mostrar/ocultar detalles -->
<script>
    document.addEventListener('click', function (e) {
        const boton = e.target.closest('.toggle-detalle');
        if (!boton) return;

        const id = boton.getAttribute('data-id');
        const fila = document.getElementById('detalle-' + id);
        const icono = boton.querySelector('i');

        // Cerrar otras filas
        document.querySelectorAll('.detalle-fila').forEach(otraFila => {
            if (otraFila !== fila) {
                otraFila.style.display = 'none';
                const otroBoton = document.querySelector(`.toggle-detalle[data-id="${otraFila.id.replace('detalle-', '')}"] i`);
                if (otroBoton) {
                    otroBoton.classList.remove('fa-chevron-up');
                    otroBoton.classList.add('fa-chevron-down');
                }
            }
        });

        // Alternar fila seleccionada
        const visible = fila.style.display !== 'none';
        fila.style.display = visible ? 'none' : '';
        icono.classList.toggle('fa-chevron-down', visible);
        icono.classList.toggle('fa-chevron-up', !visible);

        if (!visible) {
            setTimeout(() => {
                fila.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 200);
        }
    });
</script>
<style>
    .pagination .page-item.active .page-link {
        background-color: #2f2ea1;
        border-color: #525bad;
    }
    .pagination .page-link {
        color: #484d97;
    }
</style>