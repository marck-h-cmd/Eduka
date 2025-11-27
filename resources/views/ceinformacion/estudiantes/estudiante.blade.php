<!--SE UTILIZAN ETIQUETAS IDENTIFICATORIS ID U+ÚNICAS--->
<div id="tabla-estudiantes" class="table-responsive">
    @include('ccomponentes.loader', ['id' => 'loaderTabla']) {{-- otro ID único --}}

    <table id="add-row" class="table-hover table" style="border-radius: none; overflow: hidden;">
        <tbody style="font-family: 'Quicksand', sans-serif !important;">
            @foreach ($estudiante as $index => $itemRepresentante)
                <tr class="{{ $index % 2 == 0 ? 'even' : 'odd' }}">
                    <td class="text-center align-middle">
                        <button type="button" class="toggle-btn btn btn-sm" data-target="#collapseRow{{ $index }}"
                            title="Ver más">
                            <i class="fas fa-chevron-down" style="color: #0A8CB3;"></i>
                        </button>
                    </td>
                    <td class="text-center">{{ $itemRepresentante->dni }}</td>
                    <td>
                        {{ ucwords(strtolower($itemRepresentante->apellidos)) . ', ' . ucwords(strtolower($itemRepresentante->nombres)) }}
                    </td>
                    <td class="text-center">
                        <span class="badge badge-info"
                            style="background-color: #EC4079; font-weight:bold">{{ Str::substr($itemRepresentante->telefono, 0, 3) . ' ' . Str::substr($itemRepresentante->telefono, 3, 3) . ' ' . Str::substr($itemRepresentante->telefono, 6, 3) }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('estudiantes.ficha', $itemRepresentante->estudiante_id) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary  btn-expand-hover" style="font-weight:bold; border-radius: 0.48rem;">
                            <i class="fas fa-file-pdf mx-1"></i> Generar ficha
                        </a>

                    </td>
                </tr>
                <style>
                    .btn-expand-hover {
                        color: #0A8CB3;
                        border: 1px solid #0A8CB3;
                        transition: transform 0.1s ease, box-shadow 0.1s ease;
                    }

                    .btn-expand-hover:hover {
                        transform: scale(1.06);
                        background-color: #0A8CB3;
                        box-shadow: 0 2px 8px rgba(10, 140, 179, 0.3);
                        border: none;
                    }
                </style>
                {{-- Detalles expandibles --}}
                <tr class="collapse-row {{ $index % 2 == 0 ? 'even' : 'odd' }}" id="collapseRow{{ $index }}">
                    <td colspan="5">
                        <div class="p-3 d-flex flex-wrap gap-3">

                            {{-- Columna de datos --}}
                            <div class="flex-grow-1" style="min-width: 300px;">
                                <p><i class="icon-calendar mr-2"></i><strong>Fecha de Nacimiento:</strong>
                                    {{ $itemRepresentante->fecha_nacimiento }}</p>
                                <p><i class="icon-information mr-2"></i><strong>Género:</strong>
                                    {{ $itemRepresentante->genero == 'M' ? 'Masculino' : ($itemRepresentante->genero == 'F' ? 'Femenino' : 'No especificado') }}
                                </p>
                                <p><i class="icon-envelope mr-2"></i><strong>Correo:</strong>
                                    <a
                                        href="mailto:{{ $itemRepresentante->email }}">{{ $itemRepresentante->email }}</a>
                                </p>
                                <p><i class="icon-location-pin mr-2"></i><strong>Dirección:</strong>
                                    <a href="https://www.google.com/maps/search/{{ urlencode($itemRepresentante->direccion) }}"
                                        target="_blank">
                                        {{ $itemRepresentante->direccion }}
                                    </a>
                                </p>
                                <p><i class="icon-calendar mr-2"></i><strong>Fecha de Registro:</strong>
                                    {{ $itemRepresentante->fecha_registro }}
                                </p>
                            </div>

                            {{-- Columna de imagen --}}
                            <div class="text-center" style="min-width: 160px;">

                                @php
                                    // Ruta física del archivo dentro del storage
                                    $rutaFoto = storage_path(
                                        'app/public/estudiantes/' . ($itemRepresentante->foto_url ?? ''),
                                    );

                                    //viene de PHP Verificar si el archivo existe realmente isset verifica si existe y no es nula y file_exists, si está guardada en esa ruta
                                    $fotoExiste = isset($itemRepresentante->foto_url) && file_exists($rutaFoto);

                                    //Viene de laravel  Si existe, usarla; de lo contrario, mostrar imagen por defecto
                                    //asset Genera la URL pública hacia un archivo dentro de public/
                                    $foto = $fotoExiste
                                        ? asset('storage/estudiantes/' . $itemRepresentante->foto_url)
                                        : asset('storage/estudiantes/imgDocente.png');
                                @endphp
                                <!--
                                object-fit: cover hace que la imagen mantenga su proporción y se recorte si es necesario (sin deformarse).
                                draggable="false" Evita que el usuario pueda arrastrar la imagen desde la página.
                                oncontextmenu="return false;" Desactiva el clic derecho sobre la imagen, evitando que alguien la descargue fácilmente o vea sus propiedades.
                                -->
                                <img src="{{ $foto }}" alt="Foto del estudiante" class="img-thumbnail rounded"
                                    style="width: 150px; height: 160px; object-fit: cover;" draggable="false"
                                    oncontextmenu="return false;">
                                <p class="mt-2 fw-bold">Foto del estudiante</p>
                            </div>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!--onEachSide(1) limita los números de página mostrados alrededor de la página actual.-->
    <div id="tabla-estudiantes" class="d-flex justify-content-center mt-3">
        {{ $estudiante->onEachSide(1)->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tablaEstudiantes = document.getElementById('tabla-estudiantes');

        tablaEstudiantes.addEventListener('click', function(e) {
            const btn = e.target.closest('.toggle-btn');
            if (!btn) return;

            e.stopPropagation();

            const icon = btn.querySelector('i');
            const targetId = btn.getAttribute('data-target');
            const targetRow = document.querySelector(targetId);
            if (!targetRow) return;

            // Cierra cualquier otra fila abierta
            document.querySelectorAll('.collapse-row.show').forEach(row => {
                if (row !== targetRow) {
                    row.classList.remove('show');
                    const iconBtn = row.previousElementSibling.querySelector('.toggle-btn i');
                    if (iconBtn) {
                        iconBtn.classList.remove('fa-chevron-up');
                        iconBtn.classList.add('fa-chevron-down');
                    }
                }
            });

            const isVisible = targetRow.classList.contains('show');

            if (isVisible) {
                // Oculta la fila
                targetRow.classList.remove('show');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                // Muestra la fila
                targetRow.classList.add('show');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');

                // 🔽 Desplazamiento suave a la fila
                setTimeout(() => {
                    targetRow.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 150); // Espera un poco para que se aplique .show
            }
        });

        // Cierra la fila activa al hacer clic fuera de la tabla
        document.addEventListener('click', function(event) {
            const tabla = document.getElementById('tabla-estudiantes');
            const isClickInside = tabla.contains(event.target);

            // Si el clic fue fuera de la tabla, cerrar cualquier fila abierta
            if (!isClickInside) {
                document.querySelectorAll('.collapse-row.show').forEach(row => {
                    row.classList.remove('show');
                    const iconBtn = row.previousElementSibling.querySelector('.toggle-btn i');
                    if (iconBtn) {
                        iconBtn.classList.remove('fa-chevron-up');
                        iconBtn.classList.add('fa-chevron-down');
                    }
                });
            }
        });
    });
</script>

<style>
    #add-row td,
    #add-row th {
        padding: 4px 8px;
        font-size: 15.5px !important;
        vertical-align: middle;
        /*alineado verticalmente al centro */
        height: 47px;
        font-family: quicksand;
    }
</style>


<style>
    /* Oculta por defecto */
    .collapse-row {
        display: none;
        transition: all 0.3s ease;
        font-family: quicksand !important;
    }

    /* Al mostrar, se vuelve visible con animación */
    .collapse-row.show {
        display: table-row;
        animation: fadeIn 0.8s ease;
        font-family: quicksand !important;
    }

    /* Efecto de desvanecimiento suave */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>
