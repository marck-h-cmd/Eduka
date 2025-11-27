@extends('cplantilla.bprincipal')
@section('titulo', 'Registro y listado de docentes')
@section('contenidoplantilla')

    <style>
        .form-bordered {
            margin: 0;
            border: none;
            padding-top: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eaedf1;
        }

        .card-body.info {
            background: #f3f3f3;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            border-top: 1px solid rgba(0, 0, 0, .125);
            color: #F59D24;
        }

        .card-body.info p {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 600;
            color: #004a92;
        }


        @media (max-width: 576px) {
            .margen-movil {
                margin-left: -29px !important;
                margin-right: -29px !important;
            }

            .margen-movil-2 {
                margin: 0 !important;
                padding: 0 !important;
            }
        }
.estilo-info {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;

        }

    </style>

    <style type="text/css" data-glamor=""></style>
    <meta name="react-film" content="version=1.2.1-master.db29968">
    <meta name="botframework-webchat:bundle:variant" content="full">
    <meta name="botframework-webchat:bundle:version" content="4.3.1-master.98c662f">
    <meta name="botframework-webchat:core:version" content="4.3.1-master.98c662f">
    <meta name="botframework-webchat:ui:version" content="4.3.1-master.98c662f">
    <style type="text/css">
        .fancybox-margin {
            margin-right: 10px;
        }
    </style>

    <div class="container-fluid margen-movil-2" id="contenido-principal" style="position: relative;">
        @include('ccomponentes.loader', ['id' => 'loaderPrincipal']) {{-- Usa este ID --}}

        <div class="row mt-4 ml-1 mr-1" id="contenido-principal" style="position: relative;">
            <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">
                <div class="box_block">
                    <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                        data-toggle="collapse" data-target="#collapseExample0" aria-expanded="true"
                        aria-controls="collapseExample"
                        style="background: #0A8CB3 !important; font-weight: bold; color: white;">
                        <i class="fas fa-file-signature m-1"></i>&nbsp;Registro y listado de docentes
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>

                    <div class="card-body info">
                        <div class="d-flex ">
                            <div class="@*flex-fill align-content-le*@">
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                            <div class="p-2 flex-fill">
                                <p>
                                    En esta sección, podrás añadir nuevos docentes y consultar la información de los que
                                    ya están registrados.
                                </p>
                                <p>
                                    Estimado Usuario: Asegúrate de revisar cuidadosamente los datos antes de guardarlos, ya
                                    que esta información será utilizada para la gestión académica y administrativa del
                                    docente. Cualquier modificación posterior debe ser realizada con responsabilidad y
                                    siguiendo los protocolos establecidos por la institución.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="collapse show" id="collapseExample0">
                        <div class="card card-body rounded-0 border-0 pt-0 pb-2"
                            style="background-color: #fcfffc !important">
                            <div class="row align-items-center">
                                <!-- Botón a la izquierda -->

                                <div class="col-md-6 mb-md-0 d-flex justify-content-start">
                                    <a href="{{ route('docente.create') }}" class="btn btn-primary no-recargar w-100"
                                        data-url="{{ route('docente.create') }}" id="nuevoRegistroBtn">
                                        Registrar Docente
                                    </a>
                                </div>

                                <!-- Buscador a la derecha -->
                                <div class="col-md-6 d-flex justify-content-md-end justify-content-start estilo-info">
                                    <form id="formBuscar" method="GET" class="w-100" style="max-width: 100%;">
                                        <div class="input-group">
                                            <input id="inputBuscar" name="buscarpor" class="form-control mt-3"
                                                type="search" placeholder="Buscar por N.° de DNI o Apellidos"
                                                aria-label="Search" value="{{ $buscarpor }}" autocomplete="off"
                                                style="border-color: #ef8235;">
                                            <button class="btn btn-primary nuevo-boton" type="submit"
                                                style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- SweetAlert2 -->
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const formBuscar = document.getElementById('formBuscar');
                                    const inputBuscar = document.getElementById('inputBuscar');
                                    const btnRegistrar = document.getElementById('nuevoRegistroBtn');

                                    // Validación de búsqueda con SweetAlert
                                    formBuscar.addEventListener('submit', function(e) {
                                        const valor = inputBuscar.value.trim();

                                        if (valor === '') {
                                            e.preventDefault();
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Campo vacío',
                                                text: 'Ingrese un N.° de DNI o Apellido para realizar la búsqueda.',
                                                showConfirmButton: false,
                                                timer: 800
                                            });
                                        } else {
                                            // Feedback animado (opcional)
                                            Swal.fire({
                                                toast: true,
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Buscando docente...',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        }
                                    });

                                });

                                document.getElementById('inputBuscar').addEventListener('input', function() {
                                    const valor = this.value.trim();

                                    if (valor === '') {
                                        fetch('{{ route('registrardocente.index') }}', {
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                }
                                            })
                                            .then(response => response.text())
                                            .then(html => {
                                                document.querySelector('#tabla-docentes').innerHTML = html;
                                            });
                                    }
                                });
                                //PARA QUE NO SE ACTUALICE TODO AL BUSCAR, SINO SOLO EL CONTENIDO DE LA TABLA
                                document.getElementById('formBuscar').addEventListener('submit', function(e) {
                                    e.preventDefault();
                                    //TOMAMOS EL TEXTO SIN ESPACIOS
                                    const valor = inputBuscar.value.trim();
                                    //SE USA EL X-REQ PARA TRABAJAR CON EL AJAX DEL CONTROLADOR, SINO NO SIRVE
                                    fetch(`{{ route('registrardocente.index') }}?buscarpor=${encodeURIComponent(valor)}`, {
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest'
                                            }
                                        })
                                        .then(response => response.text())
                                        .then(html => {
                                            document.querySelector('#tabla-docentes').innerHTML = html;
                                        });
                                });
                            </script>

                            <div class="row form-bordered align-items-center"></div>

                            <div class="table-responsive mt-2">
                                <table class="table-hover table text-center"
                                    style="border: 1px solid #0A8CB3; border-radius: 10px; overflow: hidden;">
                                    <thead class="  table-hover estilo-info"
                                        style="background-color: #f8f9fa; color: #0A8CB3; border:#0A8CB3 !important">
                                        <tr>
                                            <th class="text-center"style="width: 30px;" ></th>
                                            <th class="text-center" scope="col">N.° DNI</th>
                                            <th class="text-center"scope="col">Nombre Completo</th>
                                            <th class="text-center"scope="col">Especialidad</th>
                                            <th class="text-center"scope="col">Opciones</th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div id="tabla-docentes" style="position: relative;">
                                @include('ceinformacion.docentes.docente', [
                                    'docente' => $docente,
                                ])
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <br>
        </div>


    <style>
        .btn-primary {
            margin-top: 1rem;
            background: #ef8235 !important;
            border: none;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;

        }

        .btn-primary:hover {
            background-color: #db7025 !important;
            transform: scale(1.01);
        }
    </style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('modal_success_docente'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('modal_success_docente') }}',
            confirmButtonColor: '#28a745',
            timer: 1200,
            showConfirmButton: false
        });
    });
</script>
@endif

    <style>
        .btn-action-group button {
            margin-right: 5px;
        }

        .toggle-btn {
            padding: 0;
            border: none;
            background: none;
            cursor: pointer;
            /* Solo aquí */
        }

        .toggle-btn i {
            font-size: 0.9rem;
            color: #007bff;
            pointer-events: none;
            /* Para que el icono no capture eventos y se maneje en el botón */
        }

        /* Bicolor de filas */
        .table-custom tbody tr:nth-of-type(odd) {
            background-color: #f6f3f1;
        }

        .table-custom tbody tr:nth-of-type(even) {
            background-color: #e0e0e0;
        }

        /* El detalle tendrá el mismo color que la fila anterior DETALLE DE IMPARES*/
        .collapse-row.odd {
            background-color: #f5f5f5;
        }

        /* El detalle tendrá el mismo color que la fila anterior DETALLE DE PARES*/
        .collapse-row.even {
            background-color: #e0e0e0;
        }

        /* Hover en toda la fila (sin cambiar cursor) */
        .table-hover tbody tr:hover {
            background-color: #fff9e7 !important;
        }
    </style>

    <style>
        /* Paginación */
        .pagination {
            display: flex;
            justify-content: left;
            padding: 1rem 0;
            list-style: none;
            gap: 0.3rem;
        }

        .pagination li a,
        .pagination li span {
            color: var(--color-principal);
            border: 1px solid var(--color-principal);
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .pagination li a:hover,
        .pagination li span:hover {
            background-color: rgb(216, 168, 101);
            /* Color gris cuando el cursor pasa por encima */
            color: #333;
        }

        /* Páginas activas con fondo negro */
        .pagination .page-item.active .page-link {
            background-color: #cd6a22 !important;
            /* Fondo negro para la página activa */
            color: white !important;
            /* Texto blanco en la página activa */
            border-color: #000000 !important;
            /* Borde negro */
        }

        /* Páginas deshabilitadas */
        .pagination .disabled .page-link {
            color: #ccc;
            border-color: #ccc;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');

                // Solo reemplazar si la página actual es HTTPS
                if (window.location.protocol === "https:") {
                    url = url.replace("http://", "https://");
                }
                let buscarpor = $('#inputBuscar').val();

                const loader = document.getElementById('loaderTabla'); // apunta al loader de tabla
                const contenedor = document.getElementById('tabla-docentes');

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        buscarpor: buscarpor
                    },
                    beforeSend: function() {
                        loader.style.display = 'flex';
                        contenedor.style.opacity = '0.5'; // opcional: efecto de atenuado
                    },
                    success: function(data) {
                        $('#tabla-docentes').html(data);
                    },
                    complete: function() {
                        loader.style.display = 'none';
                        contenedor.style.opacity = '1';
                    },
                    error: function() {
                        alert('Ocurrió un error al cargar los datos.');
                    }
                });
            });
        });
    </script>

<!-- Modal de Edición de Docente -->
<div class="modal fade" id="modalEditarDocente" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formEditarDocente" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Editar docente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_profesor_id" name="profesor_id">

          <div class="mb-3">
            <label for="edit_direccion">Dirección</label>
            <input type="text" class="form-control" id="edit_direccion" name="direccion">
          </div>

          <div class="mb-3">
            <label for="edit_telefono">Teléfono</label>
            <input type="number" class="form-control" id="edit_telefono" name="telefono">
          </div>

          <div class="mb-3">
            <label for="edit_email">Correo</label>
            <input type="email" class="form-control" id="edit_email" name="email">
          </div>

          <div class="mb-3">
            <label for="edit_especialidad">Especialidad</label>
            <input type="text" class="form-control" id="edit_especialidad" name="especialidad">
          </div>

          <div class="mb-3">
            <label for="edit_fecha">Fecha de Contratación</label>
            <input type="date" class="form-control" id="edit_fecha" name="fecha_contratacion">
          </div>

          <div class="mb-3">
            <label for="edit_estado">Estado</label>
            <select class="form-control" id="edit_estado" name="estado">
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
              <option value="Licencia">Licencia</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
