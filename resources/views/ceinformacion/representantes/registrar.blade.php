@extends('cplantilla.bprincipal')
@section('titulo', 'Registrar Representantes Legales')
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

        .estilo-info {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
        }

        .btn-primary {
            margin-top: 1rem;
            background: #50da35 !important;
            border: none;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
        }

        .btn-primary:hover {
            background-color: #6ee11c !important;
            transform: scale(1.01);
        }

        .btn-danger {
            background: #dc3545 !important;
            border: none;
            transition: background-color 0.2s ease, transform 0.1s ease;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important;
        }

        .btn-danger:hover {
            background-color: #b52a37 !important;
            transform: scale(1.01);
        }

        .btn-action-group button {
            margin-right: 5px;
        }

        .toggle-btn {
            padding: 0;
            border: none;
            background: none;
            cursor: pointer;
        }

        .toggle-btn i {
            font-size: 0.9rem;
            color: #007bff;
            pointer-events: none;
        }

        .table-custom tbody tr:nth-of-type(odd) {
            background-color: #f5f5f5;
        }

        .table-custom tbody tr:nth-of-type(even) {
            background-color: #e0e0e0;
        }

        .collapse-row.odd {
            background-color: #f5f5f5;
        }

        .collapse-row.even {
            background-color: #e0e0e0;
        }

        .table-hover tbody tr:hover {
            background-color: #eeffe7 !important;
        }

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
            background-color: #f1f1f1;
            color: #333;
        }

        .pagination .page-item.active .page-link {
            background-color: #0A8CB3 !important;
            color: white !important;
            border-color: #000000 !important;
        }

        .pagination .disabled .page-link {
            color: #ccc;
            border-color: #ccc;
        }

        .collapse-row {
            transition: all 0.3s ease-in-out;
            display: none;
        }

        .collapse-row.show {
            display: table-row !important;
        }

        .form-control:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, .25);
        }
    </style>

    <div class="container-fluid" id="contenido-principal" style="position: relative;">
        @include('ccomponentes.loader', ['id' => 'loaderPrincipalRep'])

        <div class="row mt-4 ml-1 mr-1">
            <div class="col-12">
                <div class="box_block">
                    <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                        data-toggle="collapse" data-target="#collapseExample0" aria-expanded="true"
                        aria-controls="collapseExample"
                        style="background: #0A8CB3 !important; font-weight: bold; color: white;">
                        <i class="fas fa-file-signature m-1"></i>&nbsp;Registro y listado de representantes legales
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>
                    <div class="card-body info">
                        <div class="d-flex ">
                            <div>
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                            <div class="p-2 flex-fill">
                                <p>
                                    En esta sección, podrás añadir nuevos representantes legales y consultar la información
                                    de los que ya están registrados.
                                </p>
                                <p>
                                    Estimado Usuario: Asegúrate de revisar cuidadosamente los datos antes de guardarlos, ya
                                    que esta información será utilizada para la gestión académica y administrativa.
                                    Cualquier modificación posterior debe ser realizada con responsabilidad y siguiendo los
                                    protocolos establecidos por la institución.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="collapse show" id="collapseExample0">
                        <div class="card card-body rounded-0 border-0 pt-0 pb-2"
                            style="background-color: #fcfffc !important">
                            <div class="row align-items-center">
                                <!-- Agregado mt-3 para separar de la card de información -->
                                <div class="col-md-6 mb-md-0 d-flex justify-content-start">
                                    <a href="{{ route('representantes.pdf') }}"
                                        class="btn btn-primary w-100"
                                        id="nuevoRegistroBtn" target="_blanck">
                                        <i class="fa fa-file-pdf mr-2"></i> Exportar PDF
                                    </a>
                                </div>
                                <div
                                    class="col-md-6 d-flex justify-content-md-end justify-content-start estilo-info">
                                    <form id="formBuscar" method="GET" class="w-100" style="max-width: 100%;">
                                        <div class="input-group" style="align-items: stretch;">
                                            <input id="inputBuscar" name="buscarpor" class="form-control mt-3" type="search"
                                                placeholder="Buscar por DNI o Apellidos" aria-label="Search"
                                                value="{{ $buscarpor }}" autocomplete="off"
                                                style="border-color: #89eb27;">
                                            <button class="btn btn-primary nuevo-boton" type="submit"
                                                style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row form-bordered align-items-center"></div>

                            <div class="table-responsive mt-2">
                                <table class="table-hover table text-center"
                                    style="border: 1px solid #0A8CB3; border-radius: 10px; overflow: hidden;">
                                    <thead class="table-hover estilo-info"
                                        style="background-color: #f8f9fa; color: #0A8CB3; border:#0A8CB3 !important">
                                        <tr>
                                            <th class="text-center" style="width: 30px;"></th>
                                            <th class="text-center">N.° DNI</th>
                                            <th class="text-center">Nombres Completos</th>
                                            <th class="text-center">Parentesco</th>
                                            <th class="text-center">N.° Celular</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="tabla-representantes" style="position: relative;">
                                @include('ceinformacion.representantes.representante', [
                                    'representante' => $representante,
                                ])
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('loaderPrincipalRep');
            const contenido = document.getElementById('contenido-principal');

            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });

        window.addEventListener('pageshow', function(event) {
            const loader = document.getElementById('loaderPrincipalRep');
            const contenido = document.getElementById('contenido-principal');

            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });



        document.getElementById('inputBuscar').addEventListener('input', function() {
            const valor = this.value.trim();
            if (valor === '') {
                fetch("{{ route('registrarrepresentante.index') }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.querySelector('#tabla-representantes').innerHTML = html;
                    });
            }
        });

         document.getElementById('formBuscar').addEventListener('submit', function(e) {
            e.preventDefault();
            const valor = document.getElementById('inputBuscar').value.trim();
            fetch(`{{ route('registrarrepresentante.index') }}?buscarpor=${encodeURIComponent(valor)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.querySelector('#tabla-representates').innerHTML = html;
                });
        });
    </script>


    <!-- Cambiar el contenido de la tabla-->
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

                const loader = document.getElementById('loaderTablaRepresentantes'); // apunta al loader de tabla
                const contenedor = document.getElementById('tabla-representantes');

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        buscarpor: buscarpor
                    },
                    beforeSend: function() {
                        loader.style.display = 'flex';
                        loader.style.display = 'flex';
                        contenedor.style.opacity = '0.5'; // opcional: efecto de atenuado
                    },
                    success: function(data) {
                        $('#tabla-representantes').html(data);
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

@endsection
