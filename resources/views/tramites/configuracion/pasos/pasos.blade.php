<table class="table-hover table table-custom text-center"
       style="border:1px solid #0A8CB3; border-radius:10px;">

    <thead class="table-hover estilo-info">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Duración</th>
            <th>Documento</th>
            <th>Validación</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($pasos as $paso)
            <tr>
                <td>{{ $paso->id_paso }}</td>

                <td>{{ $paso->nombre }}</td>

                <td>{{ $paso->tipo_paso }}</td>

                <td>{{ $paso->duracion_dias }} días</td>

                <td>
                    @if($paso->requiere_documento)
                        <span class="badge badge-info">Sí</span>
                    @else
                        <span class="badge badge-secondary">No</span>
                    @endif
                </td>

                <td>
                    @if($paso->requiere_validacion)
                        <span class="badge badge-warning">Sí</span>
                    @else
                        <span class="badge badge-secondary">No</span>
                    @endif
                </td>

                <td>
                    <span class="badge badge-{{ $paso->estado == 'Activo' ? 'success':'danger' }}">
                        {{ $paso->estado }}
                    </span>
                </td>

                <td class="btn-action-group">

                    <a href="{{ route('pasos.edit', $paso->id_paso) }}" class="btn btn-link p-0">
                        <i class="fas fa-pen" style="color:#007bff; font-size:1.2rem;"></i>
                    </a>

                    <button type="button" class="btn btn-link p-0"
                        onclick="confirmDelete({{ $paso->id_paso }}, '{{ $paso->nombre }}')">
                        <i class="fas fa-times" style="color:#dc3545; font-size:1.3rem;"></i>
                    </button>

                    <form id="delete-form-{{ $paso->id_paso }}"
                          action="{{ route('pasos.destroy', $paso->id_paso) }}"
                          method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
        @empty
            <tr><td colspan="8">No hay pasos registrados</td></tr>
        @endforelse
    </tbody>

</table>
