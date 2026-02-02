{{ $roles->links() }}
<table class="table-hover table table-custom text-center" style="border: 1px solid #0A8CB3; border-radius: 10px; overflow: hidden;">
    <thead class="table-hover estilo-info">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripción</th>
            <th scope="col">Personas Asignadas</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($roles as $rol)
            <tr>
                <td>{{ $rol->id_rol }}</td>
                <td>{{ $rol->nombre }}</td>
                <td>{{ $rol->descripcion ?: 'Sin descripción' }}</td>
                <td>{{ $rol->personas()->count() }}</td>
                <td class="btn-action-group">
                    <a href="{{ route('roles.show', $rol->id_rol) }}" class="btn btn-link btn-sm p-0" title="Ver">
                        <i class="fas fa-eye" style="color: #17a2b8; font-size: 1.2rem;"></i>
                    </a>
                    <a href="{{ route('roles.edit', $rol->id_rol) }}" class="btn btn-link btn-sm p-0 btn-editar-rol" title="Editar">
                        <i class="fas fa-pen" style="color: #007bff; font-size: 1.2rem;"></i>
                    </a>
                    <form action="{{ route('roles.destroy', $rol->id_rol) }}" method="POST" class="d-inline" id="delete-form-{{ $rol->id_rol }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-link btn-sm p-0 btn-eliminar-rol" title="Eliminar" onclick="confirmDelete({{ $rol->id_rol }}, '{{ $rol->nombre }}')">
                            <i class="fas fa-times" style="color: #dc3545; font-size: 1.3rem;"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No hay roles registrados</td>
            </tr>
        @endforelse
    </tbody>
</table>
