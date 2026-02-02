<table class="table-hover table table-custom text-center"
       style="border:1px solid #0A8CB3; border-radius:10px;">

    <thead class="table-hover estilo-info">
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Estudiante</th>
            <th>Proceso</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($procesos as $p)
            <tr>
                <td>{{ $p->id_estudiante_proceso }}</td>

                <td>{{ $p->codigo_expediente ?? '-' }}</td>

                <td>{{ $p->estudiante->nombres }} {{ $p->estudiante->apellidos }}</td>

                <td>{{ $p->proceso->nombre }}</td>

                <td>{{ $p->fecha_inicio }}</td>

                <td>{{ $p->fecha_fin ?? '-' }}</td>

                <td>
                    <span class="badge badge-{{ 
                        $p->estado == 'Finalizado' ? 'success' : 
                        ($p->estado == 'En curso' ? 'primary' :
                        ($p->estado == 'Anulado' ? 'danger' : 'warning')) }}">
                        {{ $p->estado }}
                    </span>
                </td>

                <td class="btn-action-group">

                    <a href="{{ route('estudiante_procesos.edit', $p->id_estudiante_proceso) }}" 
                       class="btn btn-link p-0">
                        <i class="fas fa-pen" style="color:#007bff; font-size:1.2rem;"></i>
                    </a>

                    <button type="button" class="btn btn-link p-0"
                        onclick="confirmDelete({{ $p->id_estudiante_proceso }}, '{{ $p->codigo_expediente }}')">
                        <i class="fas fa-times" style="color:#dc3545; font-size:1.3rem;"></i>
                    </button>

                    <form id="delete-form-{{ $p->id_estudiante_proceso }}"
                          action="{{ route('estudiante_procesos.destroy', $p->id_estudiante_proceso) }}"
                          method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
        @empty
            <tr><td colspan="8">No hay expedientes registrados</td></tr>
        @endforelse
    </tbody>

</table>
