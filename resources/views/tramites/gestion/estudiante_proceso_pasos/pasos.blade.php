<table class="table-hover table table-custom text-center"
       style="border:1px solid #0A8CB3; border-radius:10px;">

    <thead class="table-hover estilo-info">
        <tr>
            <th>ID</th>
            <th>Código Expediente</th>
            <th>Paso</th>
            <th>Inicio</th>
            <th>Entrega</th>
            <th>Validación</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($pasos as $p)
            <tr>
                <td>{{ $p->id_estudiante_proceso_paso }}</td>

                <td>{{ $p->estudianteProceso->codigo_expediente }}</td>

                <td>{{ $p->paso->nombre }}</td>

                <td>{{ $p->fecha_inicio ?? '-' }}</td>

                <td>{{ $p->fecha_entrega ?? '-' }}</td>

                <td>{{ $p->fecha_validacion ?? '-' }}</td>

                <td>
                    <span class="badge badge-{{ 
                        $p->estado == 'Aprobado' ? 'success' :
                        ($p->estado == 'En progreso' ? 'primary' :
                        ($p->estado == 'Rechazado' ? 'danger' :
                        ($p->estado == 'Vencido' ? 'dark' : 'warning'))) }}">
                        {{ $p->estado }}
                    </span>
                </td>

                <td class="btn-action-group">

                    <a href="{{ route('estudiante_proceso_pasos.edit', $p->id_estudiante_proceso_paso) }}"
                       class="btn btn-link p-0">
                        <i class="fas fa-pen" style="color:#007bff; font-size:1.2rem;"></i>
                    </a>

                    <button type="button" class="btn btn-link p-0"
                        onclick="confirmDelete({{ $p->id_estudiante_proceso_paso }})">
                        <i class="fas fa-times" style="color:#dc3545; font-size:1.3rem;"></i>
                    </button>

                    <form id="delete-form-{{ $p->id_estudiante_proceso_paso }}"
                          action="{{ route('estudiante_proceso_pasos.destroy', $p->id_estudiante_proceso_paso) }}"
                          method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
        @empty
            <tr><td colspan="8">No hay pasos asignados</td></tr>
        @endforelse
    </tbody>

</table>
