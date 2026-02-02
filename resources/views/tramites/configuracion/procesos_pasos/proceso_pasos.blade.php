@php
    $agrupado = $proceso_pasos->getCollection()->groupBy(fn($pp) => $pp->proceso->nombre);
@endphp

<style>
    .card-header.estilo-info {
        background: #0A8CB3 !important;
        color: #fff !important;
        border-bottom: 2px solid #086f8d;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
    }

    .arrow-rotate {
        transition: transform .3s ease;
        font-size: 1.2rem;
    }
    .collapsed .arrow-rotate {
        transform: rotate(0deg);
    }
    .arrow-rotate {
        transform: rotate(90deg);
    }

    .card-header:hover {
        background: #0c9fcf !important;
    }

    .table-custom {
        border: 1px solid #0A8CB3;
    }

    .badge-success { background-color: #28a745 !important; }
    .badge-danger { background-color: #dc3545 !important; }
    .badge-warning { background-color: #ffc107 !important; color:#000 !important; }
    .badge-secondary { background-color:#6c757d !important; }
</style>

<div class="accordion" id="accordionProcesos">

    @foreach ($agrupado as $procesoNombre => $items)

        <div class="card mb-2" style="border:1px solid #0A8CB3; border-radius:6px;">

            <div class="card-header estilo-info collapsed"
                 data-toggle="collapse"
                 data-target="#collapse-{{ Str::slug($procesoNombre) }}"
                 aria-expanded="false"
                 style="cursor:pointer;">

                <span>
                    <i class="fas fa-folder-open mr-2"></i>
                    {{ $procesoNombre }}
                </span>

                <i class="fas fa-chevron-right arrow-rotate"></i>
            </div>
            <div id="collapse-{{ Str::slug($procesoNombre) }}"
                 class="collapse"
                 data-parent="#accordionProcesos">

                <div class="card-body p-0">

                    <table class="table table-hover text-center table-custom mb-0">
                        <thead class="estilo-info">
                            <tr>
                                <th>Paso</th>
                                <th>Orden</th>
                                <th>Obligatorio</th>
                                <th>Días Plazo</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($items as $pp)
                                <tr>
                                    <td>{{ $pp->paso->nombre }}</td>

                                    <td>{{ $pp->orden }}</td>

                                    <td>
                                        @if($pp->es_obligatorio)
                                            <span class="badge badge-warning">Sí</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>

                                    <td>{{ $pp->dias_plazo ? $pp->dias_plazo . ' días' : '-' }}</td>

                                    <td>
                                        <span class="badge badge-{{ $pp->estado == 'Activo' ? 'success' : 'danger' }}">
                                            {{ $pp->estado }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('proceso_pasos.edit', [$pp->id_proceso, $pp->id_paso]) }}"
                                           class="btn btn-link p-0">
                                            <i class="fas fa-pen" style="color:#007bff; font-size:1.2rem;"></i>
                                        </a>

                                        <button class="btn btn-link p-0"
                                                onclick="confirmDelete({{ $pp->id_proceso }}, {{ $pp->id_paso }}, '{{ $pp->paso->nombre }}')">
                                            <i class="fas fa-times" style="color:#dc3545; font-size:1.3rem;"></i>
                                        </button>

                                        <form id="delete-form-{{ $pp->id_proceso }}-{{ $pp->id_paso }}"
                                              action="{{ route('proceso_pasos.destroy', [$pp->id_proceso, $pp->id_paso]) }}"
                                              method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>

        </div>

    @endforeach

</div>
