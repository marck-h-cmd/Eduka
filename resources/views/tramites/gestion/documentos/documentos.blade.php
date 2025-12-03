<table class="table-hover table table-custom text-center"
       style="border:1px solid #0A8CB3; border-radius:10px;">

    <thead class="table-hover estilo-info">
        <tr>
            <th>ID</th>
            <th>Expediente</th>
            <th>Paso</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Formato</th>
            <th>Peso</th>
            <th>Opciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($documentos as $d)
            <tr>
                <td>{{ $d->id_documento }}</td>

                <td>{{ $d->estudianteProceso->codigo_expediente }}</td>

                <td>{{ $d->paso ? $d->paso->paso->nombre : '-' }}</td>

                <td>{{ $d->nombre_original }}</td>

                <td>{{ $d->tipo_documento }}</td>

                <td>{{ $d->formato }}</td>

                <td>{{ number_format($d->tamanio_bytes / 1024, 2) }} KB</td>

                <td class="btn-action-group">

                    <a href="{{ route('documentos.show', $d->id_documento) }}"
                       class="btn btn-link p-0">
                        <i class="fas fa-eye" style="color:#0A8CB3; font-size:1.3rem;"></i>
                    </a>

                    <a href="{{ route('documentos.edit', $d->id_documento) }}"
                       class="btn btn-link p-0">
                        <i class="fas fa-pen" style="color:#007bff; font-size:1.2rem;"></i>
                    </a>

                    <button type="button" class="btn btn-link p-0"
                        onclick="confirmDelete({{ $d->id_documento }})">
                        <i class="fas fa-trash" style="color:#dc3545; font-size:1.3rem;"></i>
                    </button>

                    <form id="delete-form-{{ $d->id_documento }}"
                          action="{{ route('documentos.destroy', $d->id_documento) }}"
                          method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
        @empty
            <tr><td colspan="8">No hay documentos registrados</td></tr>
        @endforelse
    </tbody>

</table>
