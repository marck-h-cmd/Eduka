@extends('cplantilla.bprincipal')
@section('titulo', 'Gestión de Docentes')
@section('contenidoplantilla')
    <style>
        :root {
            --color-principal: #0A8CB3;
            --color-secundario: #F59D24;
            --color-fondo: #fcfffc;
            --color-texto: #004a92;
            --color-borde: #eaedf1;
            --color-success: #28a745;
            --color-danger: #dc3545;
            --color-warning: #ffc107;
            --color-secondary: #6c757d;
        }

        /* Estilos generales */
        .form-bordered {
            margin: 0;
            border: none;
            padding-top: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed var(--color-borde);
        }

        .card-body.info {
            background: #f3f3f3;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            border-top: 1px solid rgba(0, 0, 0, .125);
            color: var(--color-secundario);
        }

        .card-body.info p {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 600;
            color: var(--color-texto);
        }

        .estilo-info {
            margin-bottom: 0px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.0vw, 0.9rem);
        }

        /* Botones generales */
        .btn-action-group button {
            margin-right: 5px;
        }

        .btn-action-group .btn-link {
            margin-right: 8px;
            padding: 0 6px;
            border: none;
            background: none;
            box-shadow: none;
        }

        .btn-action-group .btn-link:focus {
            outline: none;
            box-shadow: none;
        }

        /* Botón primario específico */
        .btn.btn-primary {
            background: var(--color-principal) !important;
            border: none;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .btn.btn-primary:hover {
            background-color: #08769a !important;
            transform: scale(1.01);
        }

        /* Botón primario con estilo bloque */
        .btn-primary.btn-block-estilo {
            margin-top: 1rem;
            background: linear-gradient(135deg, var(--color-principal) 0%, #08769a 100%) !important;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
        }

        .btn-primary.btn-block-estilo:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Botón limpiar específico */
        .btn-limpiar-especial {
            border: 1px solid var(--color-secondary) !important;
            color: var(--color-secondary) !important;
            background: transparent !important;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.2s ease, color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            text-decoration: none;
        }

        .btn-limpiar-especial:hover {
            background: var(--color-secondary) !important;
            color: white !important;
            text-decoration: none;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Tabla */
        .table-custom {
            border: 1px solid var(--color-principal);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table-custom thead {
            background: var(--color-principal) !important;
            color: white;
        }

        .table-custom tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .table-custom tbody tr:nth-of-type(even) {
            background-color: #ffffff;
        }

        .table-hover tbody tr:hover {
            background-color: #e8f4ff !important;
            transition: background-color 0.2s ease;
        }

        /* Paginación */
        .pagination {
            display: flex;
            justify-content: center;
            padding: 1rem 0;
            list-style: none;
            gap: 0.3rem;
            flex-wrap: wrap;
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
            background-color: var(--color-principal) !important;
            color: white !important;
            border-color: var(--color-principal) !important;
        }

        .pagination .disabled .page-link {
            color: #ccc;
            border-color: #ccc;
        }

        /* Loader */
        #loaderPrincipal[style*="display: flex"] {
            display: flex !important;
            justify-content: center;
            align-items: center;
            position: absolute !important;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 2000;
            background: rgba(255, 255, 255, 0.9);
        }

        /* Estilos para filtros */
        .filtros-container {
            background: #ffffff;
            border: 1px solid var(--color-borde);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .filtro-group {
            margin-bottom: 1rem;
        }

        .filtro-group label {
            font-weight: 600;
            color: var(--color-texto);
            margin-bottom: 8px;
            display: block;
            font-family: "Quicksand", sans-serif;
        }

        .btn-filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .btn-filter {
            padding: 8px 16px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            background: white;
            color: #495057;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .btn-filter:hover {
            border-color: var(--color-principal);
            color: var(--color-principal);
        }

        .btn-filter.active {
            background: var(--color-principal);
            color: white;
            border-color: var(--color-principal);
        }

        /* Estadísticas */
        .estadisticas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .estadistica-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            border-top: 4px solid var(--color-principal);
            transition: transform 0.2s ease;
        }

        .estadistica-card:hover {
            transform: translateY(-2px);
        }

        .estadistica-card.orange {
            border-top-color: var(--color-secundario);
        }

        .estadistica-card.green {
            border-top-color: var(--color-success);
        }

        .estadistica-card.purple {
            border-top-color: #6f42c1;
        }

        .estadistica-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--color-principal);
        }

        .estadistica-card.orange .estadistica-icon {
            color: var(--color-secundario);
        }

        .estadistica-card.green .estadistica-icon {
            color: var(--color-success);
        }

        .estadistica-card.purple .estadistica-icon {
            color: #6f42c1;
        }

        .estadistica-valor {
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-texto);
            margin-bottom: 5px;
            line-height: 1;
        }

        .estadistica-label {
            font-size: 0.9rem;
            color: var(--color-secondary);
            font-weight: 600;
        }

        /* Tarjetas de información responsive */
        .info-docente-card {
            background: #f8f9fa;
            border-left: 3px solid var(--color-principal);
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .info-docente-card.orange {
            border-left-color: var(--color-secundario);
        }

        .info-label {
            font-weight: 600;
            color: var(--color-texto);
            font-size: 0.8rem;
        }

        /* Badges */
        .badge-custom {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-sin-info {
            background: var(--color-secondary);
            color: white;
        }

        /* Badges de estado */
        .badge-success {
            background-color: var(--color-success) !important;
        }

        .badge-danger {
            background-color: var(--color-danger) !important;
        }

        .badge-warning {
            background-color: var(--color-warning) !important;
        }

        .badge-info {
            background-color: var(--color-principal) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filtros-container {
                padding: 15px;
            }

            .btn-filter-group {
                flex-direction: column;
            }

            .btn-filter {
                width: 100%;
                justify-content: center;
            }

            .estadisticas-grid {
                grid-template-columns: 1fr;
            }

            .table-responsive {
                border: none;
            }

            .btn-action-group {
                display: flex;
                flex-direction: column;
                gap: 8px;
                align-items: center;
            }

            .btn-action-group .btn-link {
                margin-right: 0;
            }

            .btn-primary.btn-block-estilo,
            .btn-limpiar-especial {
                padding: 12px !important;
                font-size: 0.95rem;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .estadisticas-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="container-fluid" id="contenido-principal" style="position: relative;">
        @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])

        <div class="row mt-4 ml-1 mr-1">
            <div class="col-12">
                <div class="box_block">
                    <!-- Encabezado -->
                    <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                        data-toggle="collapse" data-target="#collapseExample0" aria-expanded="true"
                        aria-controls="collapseExample"
                        style="background: var(--color-principal) !important; font-weight: bold; color: white;">
                        <i class="fas fa-chalkboard-teacher m-1"></i>&nbsp;Gestión de Docentes
                        <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                    </button>

                    <div class="card-body info">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-exclamation-circle fa-2x text-warning"></i>
                            </div>
                            <div>
                                <p class="mb-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Gestiona docentes, asigna roles y consulta información de personas sin rol asignado.
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-user-check mr-1"></i>
                                    Los datos incluyen información personal, roles, especialidad y credenciales.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="collapse show" id="collapseExample0">
                        <div class="card card-body rounded-0 border-0 pt-4 pb-4"
                            style="background-color: var(--color-fondo) !important">

                            <!-- Estadísticas -->
                            {{-- <div class="estadisticas-grid">
                                <div class="estadistica-card">
                                    <div class="estadistica-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="estadistica-valor">{{ $estadisticas['total_personas'] }}</div>
                                    <div class="estadistica-label">Total Personas</div>
                                </div>

                                <div class="estadistica-card orange">
                                    <div class="estadistica-icon">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <div class="estadistica-valor">{{ $estadisticas['sin_rol'] }}</div>
                                    <div class="estadistica-label">Sin Rol Asignado</div>
                                </div>

                                <div class="estadistica-card green">
                                    <div class="estadistica-icon">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <div class="estadistica-valor">{{ $estadisticas['docentes'] }}</div>
                                    <div class="estadistica-label">Docentes Activos</div>
                                </div>

                                <div class="estadistica-card purple">
                                    <div class="estadistica-icon">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <div class="estadistica-valor">{{ $estadisticas['con_usuario'] }}</div>
                                    <div class="estadistica-label">Con Usuario</div>
                                </div>
                            </div> --}}

                            <!-- Filtros -->
                            <div class="filtros-container">
                                <form id="formFiltros" method="GET" action="{{ route('docentes.index') }}" class="mb-0">
                                    <div class="row">
                                        <!-- Búsqueda -->
                                        <div class="col-lg-4 col-md-12 mb-3">
                                            <div class="filtro-group">
                                                <label class="d-flex align-items-center">
                                                    <i class="fas fa-search mr-2"></i>Búsqueda General
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-white border-right-0">
                                                            <i class="fas fa-filter text-muted"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="buscarpor" id="inputBuscar"
                                                        class="form-control border-left-0"
                                                        placeholder="Nombre, DNI, email, especialidad..."
                                                        value="{{ $buscarpor }}" autocomplete="off">
                                                </div>
                                                <small class="form-text text-muted mt-1">
                                                    <i class="fas fa-lightbulb mr-1"></i>
                                                    Busca en nombres, apellidos, DNI, email, especialidad
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Filtro por tipo -->
                                        <div class="col-lg-4 col-md-12 mb-3">
                                            <div class="filtro-group">
                                                <label class="d-flex align-items-center">
                                                    <i class="fas fa-user-tag mr-2"></i>Tipo de Persona
                                                </label>
                                                <div class="btn-filter-group">
                                                    <button type="button"
                                                        class="btn-filter {{ $filtroTipo == 'todos' ? 'active' : '' }}"
                                                        onclick="setFiltroTipo('todos')">
                                                        <i class="fas fa-users mr-1"></i>Todos
                                                    </button>
                                                    <button type="button"
                                                        class="btn-filter {{ $filtroTipo == 'sin_rol' ? 'active' : '' }}"
                                                        onclick="setFiltroTipo('sin_rol')">
                                                        <i class="fas fa-user-times mr-1"></i>Sin Rol
                                                    </button>
                                                    <button type="button"
                                                        class="btn-filter {{ $filtroTipo == 'docentes' ? 'active' : '' }}"
                                                        onclick="setFiltroTipo('docentes')">
                                                        <i class="fas fa-chalkboard-teacher mr-1"></i>Docentes
                                                    </button>
                                                </div>
                                                <input type="hidden" name="filtro_tipo" id="filtro_tipo"
                                                    value="{{ $filtroTipo }}">
                                            </div>
                                        </div>

                                        <!-- Filtro por estado -->
                                        <div class="col-lg-4 col-md-12 mb-3">
                                            <div class="filtro-group">
                                                <label class="d-flex align-items-center">
                                                    <i class="fas fa-toggle-on mr-2"></i>Estado
                                                </label>
                                                <div class="btn-filter-group">
                                                    <button type="button"
                                                        class="btn-filter {{ $filtroEstado == 'activo' ? 'active' : '' }}"
                                                        onclick="setFiltroEstado('activo')">
                                                        <i class="fas fa-check-circle mr-1"></i>Activos
                                                    </button>
                                                    <button type="button"
                                                        class="btn-filter {{ $filtroEstado == 'inactivo' ? 'active' : '' }}"
                                                        onclick="setFiltroEstado('inactivo')">
                                                        <i class="fas fa-times-circle mr-1"></i>Inactivos
                                                    </button>
                                                    <button type="button"
                                                        class="btn-filter {{ $filtroEstado == 'todos' ? 'active' : '' }}"
                                                        onclick="setFiltroEstado('todos')">
                                                        <i class="fas fa-globe mr-1"></i>Todos
                                                    </button>
                                                </div>
                                                <input type="hidden" name="filtro_estado" id="filtro_estado"
                                                    value="{{ $filtroEstado }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-2">
                                            <button type="submit" class="btn btn-primary btn-block w-100 py-3">
                                                <i class="fas fa-search mr-2"></i>Aplicar Filtros
                                            </button>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <a href="{{ route('docentes.index') }}"
                                                class="btn-limpiar-especial w-100 py-3">
                                                <i class="fas fa-eraser mr-2"></i>Limpiar Filtros
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tabla -->
                            <div id="alerts-container" class="mt-3"></div>

                            @if ($personas->count() > 0)
                                <div class="table-responsive mt-4">
                                    <table class="table table-hover table-custom">
                                        <thead class="estilo-info">
                                            <tr>
                                                <th scope="col" class="align-middle">ID</th>
                                                <th scope="col" class="align-middle">Nombres y Apellidos</th>
                                                <th scope="col" class="align-middle">DNI</th>
                                                <th scope="col" class="align-middle">Contacto</th>
                                                <th scope="col" class="align-middle">Roles</th>
                                                <th scope="col" class="align-middle">Información Docente</th>
                                                <th scope="col" class="align-middle">Usuario</th>
                                                <th scope="col" class="align-middle">Estado</th>
                                                <th scope="col" class="align-middle">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($personas as $persona)
                                                <tr>
                                                    <td class="align-middle">
                                                        <span
                                                            class="badge badge-light border">#{{ $persona->id_persona }}</span>
                                                    </td>
                                                    <td class="align-middle" style="min-width: 230px;">
                                                        <strong class="d-block">{{ $persona->nombres }}
                                                            {{ $persona->apellidos }}</strong>

                                                    </td>
                                                    <td class="align-middle">
                                                        <i
                                                            class="fas fa-id-card mr-1"></i>{{ $persona->dni ?: 'Sin DNI' }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{-- <div class="info-docente-card"> --}}
                                                            <div><i
                                                                    class="fas fa-envelope fa-sm mr-2"></i>{{ $persona->email ?: 'Sin email' }}
                                                            </div>
                                                            @if ($persona->telefono)
                                                                <div class="mt-1"><i
                                                                        class="fas fa-phone fa-sm mr-2"></i>{{ $persona->telefono }}
                                                                </div>
                                                            @endif
                                                        {{-- </div> --}}
                                                    </td>
                                                    <td class="align-middle">
                                                        @if ($persona->roles->count() > 0)
                                                            @foreach ($persona->roles as $rol)
                                                                <span class="badge badge-info badge-custom mb-1 d-block">
                                                                    <i
                                                                        class="fas fa-user-tag mr-1"></i>{{ $rol->nombre }}
                                                                </span>
                                                            @endforeach
                                                        @else
                                                            <span class="badge badge-warning badge-custom">
                                                                <i class="fas fa-exclamation-triangle mr-1"></i>Sin roles
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        @if ($persona->docente)
                                                            <div class="info-docente-card">
                                                                <div>
                                                                    <span class="info-label">Especialidad:</span><br>
                                                                    {{ $persona->docente->especialidad }}
                                                                </div>
                                                                <div class="mt-2">
                                                                    <span class="info-label">Contratación:</span><br>
                                                                    {{ \Carbon\Carbon::parse($persona->docente->fecha_contratacion)->format('d/m/Y') }}
                                                                </div>
                                                                @if ($persona->docente->emailUniversidad)
                                                                    <div class="mt-2">
                                                                        <span class="info-label">Email Inst.:</span><br>
                                                                        <small>{{ $persona->docente->emailUniversidad }}</small>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="badge badge-secondary badge-custom">
                                                                <i class="fas fa-info-circle mr-1"></i>No es docente
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        @if ($persona->usuario)
                                                            <div class="info-docente-card orange">
                                                                <div>
                                                                    <span class="info-label">Usuario:</span><br>
                                                                    <strong>{{ $persona->usuario->username }}</strong>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <span class="info-label">Email:</span><br>
                                                                    <small>{{ $persona->usuario->email }}</small>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <span
                                                                        class="badge badge-{{ $persona->usuario->estado == 'Activo' ? 'success' : 'danger' }} badge-custom">
                                                                        {{ $persona->usuario->estado }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="badge badge-light border badge-custom">
                                                                <i class="fas fa-user-times mr-1"></i>Sin usuario
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        <span
                                                            class="badge badge-{{ $persona->estado == 'Activo' ? 'success' : 'danger' }} badge-custom">
                                                            <i class="fas fa-circle fa-xs mr-1"></i>{{ $persona->estado }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle ">
                                                        <div class="btn-action-group d-flex flex-column flex-md-row gap-3">
                                                            @if ($persona->estado == 'Activo' && $persona->roles->count() == 0)
                                                                <a href="{{ route('docentes.create') }}?persona_id={{ $persona->id_persona }}"
                                                                    class="btn btn-sm btn-success btn-action mx-1.5"
                                                                    title="Asignar como Docente">
                                                                    <i class="fas fa-user-plus"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('docentes.show', $persona) }}"
                                                                class="btn btn-sm btn-info btn-action mx-1.5"
                                                                title="Ver Detalles">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            @if ($persona->docente)
                                                                <a href="{{ route('docentes.edit', $persona) }}"
                                                                    class="btn btn-sm btn-warning btn-action mx-1.5"
                                                                    title="Editar Docente">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-action mx-1.5"
                                                                title="Cambiar Estado"
                                                                onclick="confirmarEliminar({{ $persona->id_persona }}, '{{ $persona->nombres }} {{ $persona->apellidos }}')">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                            <form id="delete-form-{{ $persona->id_persona }}"
                                                                action="{{ route('docentes.destroy', $persona) }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Paginación -->
                                <div class="mt-4">
                                    {{ $personas->links() }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-users-slash fa-4x text-muted"></i>
                                    </div>
                                    <h4 class="text-muted mb-2">No se encontraron resultados</h4>
                                    <p class="text-muted mb-4">No hay personas que coincidan con los filtros aplicados.</p>
                                    <a href="{{ route('docentes.index') }}" class="btn btn-primary">
                                        <i class="fas fa-redo mr-2"></i>Ver todos los registros
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Inicializar filtro por defecto a docentes
        document.addEventListener('DOMContentLoaded', function() {
            const filtroTipo = document.getElementById('filtro_tipo');
            if (!filtroTipo.value) {
                filtroTipo.value = 'docentes';
                // Marcar botón de docentes como activo
                document.querySelector('[onclick="setFiltroTipo(\'docentes\')"]').classList.add('active');
            }

            const loader = document.getElementById('loaderPrincipal');
            if (loader) loader.style.display = 'none';

            // Mostrar mensajes
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#0A8CB3',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#0A8CB3'
                });
            @endif
        });

        // Funciones para filtros
        function setFiltroTipo(tipo) {
            document.getElementById('filtro_tipo').value = tipo;
            document.querySelectorAll('[onclick^="setFiltroTipo"]').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[onclick="setFiltroTipo('${tipo}')"]`).classList.add('active');
        }

        function setFiltroEstado(estado) {
            document.getElementById('filtro_estado').value = estado;
            document.querySelectorAll('[onclick^="setFiltroEstado"]').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[onclick="setFiltroEstado('${estado}')"]`).classList.add('active');
        }

        // Función para confirmar eliminación
        function confirmarEliminar(personaId, nombrePersona) {
            Swal.fire({
                title: '¿Cambiar estado?',
                html: `¿Desea cambiar el estado de <b>${nombrePersona}</b> a Inactivo?<br><small class="text-muted">La persona dejará de ser visible en las listas activas</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${personaId}`).submit();
                }
            });
        }

        // Loader para enlaces
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-action');
            if (target && target.tagName === 'A') {
                e.preventDefault();
                const loader = document.getElementById('loaderPrincipal');
                if (loader) loader.style.display = 'flex';
                setTimeout(() => {
                    window.location.href = target.href;
                }, 300);
            }
        });
    </script>
@endsection
