@if ($grados->count())
<table class="table table-hover align-middle table-bordered text-center">
    <thead style="background-color: #e9d8fd; color: #4c1d95;">
        <tr>
            <th>Descripción</th>
            <th>Nivel Educativo</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grados as $grado)
            <tr>
                <td>{{ $grado->descripcion }}</td>
                <td>
                    <span class="badge fw-semibold px-3 py-1 rounded-pill"
                          style="background-color: #ede9fe; color: #6b21a8; font-size: 0.85rem;">
                        {{ strtoupper($grado->nivel_nombre) }}
                    </span>
                </td>
                <td class="text-center">
                    <!-- Botón para desplegar detalles -->
                    <button class="btn btn-outline-primary btn-sm toggle-detalle" data-id="{{ $grado->grado_id }}">
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <!-- Botón eliminar -->
                    <form action="{{ route('grados.destroy', ['id' => $grado->grado_id]) }}" method="POST" class="d-inline-block form-eliminar">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>

            <!-- Fila desplegable oculta -->
            <tr class="detalle-fila" id="detalle-{{ $grado->grado_id }}" style="display: none;">
                <td colspan="3" class="bg-light text-start align-top" style="text-align: left !important;">
                    <div class="p-3 text-start">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <p class="mb-1"><i class="fas fa-id-badge me-2"></i> <strong>ID:</strong> {{ $grado->grado_id }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <p class="mb-1"><i class="fas fa-layer-group me-2"></i> <strong>Grado:</strong> {{ $grado->nombre }}°</p>
                            </div>
                            <div class="col-md-12">
                                <p class="mb-1"><i class="fas fa-info-circle me-2"></i> <strong>Descripción:</strong> {{ $grado->descripcion }}</p>
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
    {{ $grados->links() }}
</div>
@else
    <div class="alert alert-info text-center">
        No se encontraron registros de grados.
    </div>
@endif

<!-- Script para detalles -->
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
        background-color: #6b2196;
        border-color: #9152ad;
    }
    .pagination .page-link {
        color: #814897;
    }
</style>