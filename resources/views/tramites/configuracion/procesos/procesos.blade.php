<table class="table-hover table table-custom text-center" style="border: 1px solid #0A8CB3; border-radius: 10px;">
    <thead class="table-hover estilo-info">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Duración</th>
            <th>Pago</th>
            <th>Opciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($procesos as $proceso)
            <tr>
                <td>{{ $proceso->id_proceso }}</td>
                <td>{{ $proceso->nombre }}</td>
                <td>{{ $proceso->duracion_estimada_dias }} días</td>
                <td>
                    @if($proceso->requiere_pago)
                        <span class="badge badge-info">S/ {{ number_format($proceso->monto_pago,2) }}</span>
                    @else
                        <span class="badge badge-success">No requiere</span>
                    @endif
                </td>

                <td class="btn-action-group">
                    <a href="{{ route('procesos.show', $proceso->id_proceso) }}" class="btn btn-link p-0">
                        <i class="fas fa-eye" style="color:#17a2b8; font-size:1.2rem;"></i>
                    </a>

                    <a href="{{ route('procesos.edit', $proceso->id_proceso) }}" class="btn btn-link p-0">
                        <i class="fas fa-pen" style="color:#007bff; font-size:1.2rem;"></i>
                    </a>

                    <button type="button" class="btn btn-link p-0"
                        onclick="confirmDelete({{ $proceso->id_proceso }}, '{{ $proceso->nombre }}')">
                        <i class="fas fa-times" style="color:#dc3545; font-size:1.3rem;"></i>
                    </button>

                    <form id="delete-form-{{ $proceso->id_proceso }}" 
                          action="{{ route('procesos.destroy', $proceso->id_proceso) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No hay procesos registrados</td></tr>
        @endforelse
    </tbody>
</table>