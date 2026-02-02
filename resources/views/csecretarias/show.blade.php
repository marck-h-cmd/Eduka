@extends('cplantilla.bprincipal')
@section('titulo', 'Detalle de Secretaria')
@section('contenidoplantilla')
<style>
    .form-bordered { margin: 0; border: none; padding-top: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eaedf1; }
    .card-body.info { background: #f3f3f3; border-bottom: 1px solid rgba(0, 0, 0, .125); border-top: 1px solid rgba(0, 0, 0, .125); color: #F59D24; }
    .card-body.info p { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 600; color: #004a92; }
    .estilo-info { margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary { margin-top: 1rem; background: #007bff !important; border: none; transition: background-color 0.2s ease, transform 0.1s ease; margin-bottom: 0px; font-family: "Quicksand", sans-serif; font-weight: 700; font-size: clamp(0.9rem, 2.0vw, 0.9rem) !important; }
    .btn-primary:hover { background-color: #0056b3 !important; transform: scale(1.01); }
    .btn-action-group button { margin-right: 5px; }
    .badge-lg { font-size: 1rem; padding: 0.5rem 1rem; }
    .table th { background-color: #f8f9fa; }
    #loaderPrincipal[style*="display: flex"] { display: flex !important; justify-content: center; align-items: center; position: absolute !important; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: 2000; }
    .info-box { background: #f8f9fa; border-left: 4px solid #0A8CB3; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
    .detail-table { width: 100%; border-collapse: collapse; }
    .detail-table tr { border-bottom: 1px solid #e9ecef; }
    .detail-table th { text-align: left; padding: 12px 15px; width: 35%; background-color: #f1f8ff; color: #0A8CB3; font-weight: 600; }
    .detail-table td { padding: 12px 15px; }
    .detail-table tr:hover { background-color: #f8f9fa; }
    .section-title { color: #0A8CB3; border-bottom: 2px solid #0A8CB3; padding-bottom: 8px; margin-bottom: 20px; font-weight: 700; }
    .status-badge { font-size: 0.9rem; padding: 0.4rem 0.8rem; }
    .card-detail { border: 1px solid #0A8CB3; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
</style>
<div class="container-fluid" id="contenido-principal" style="position: relative;">
    @include('ccomponentes.loader', ['id' => 'loaderPrincipal'])
    <div class="row mt-4 ml-1 mr-1">
        <div class="col-12">
            <div class="box_block">
                <button class="estilo-info btn btn-block text-left rounded-0 btn_header header_6" type="button"
                    data-toggle="collapse" data-target="#collapseExample0" aria-expanded="true"
                    aria-controls="collapseExample"
                    style="background: #0A8CB3 !important; font-weight: bold; color: white;">
                    <i class="fas fa-user-tie m-1"></i>&nbsp;Detalle de Secretaria
                    <div class="float-right"><i class="fas fa-chevron-down"></i></div>
                </button>
                <div class="card-body info">
                    <div class="d-flex ">
                        <div>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill">
                            <p>
                                En esta sección, puedes visualizar toda la información detallada de la secretaria seleccionada.
                            </p>
                            <p>
                                Estimado Usuario: Aquí encontrarás datos personales, de contacto, laborales y de acceso al sistema.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapseExample0">
                    <div class="card card-detail rounded-0 border-0 pt-0 pb-2" style="background-color: #fcfffc !important">
                        <div class="card-body">
                            {{-- Botones de acción --}}


                            <div class="row">
                                {{-- Columna izquierda --}}
                                <div class="col-md-6">
                                    {{-- Datos Personales --}}
                                    <div class="info-box">
                                        <h5 class="section-title">
                                            <i class="fas fa-user"></i> Datos Personales
                                        </h5>
                                        <table class="detail-table">
                                            <tr>
                                                <th>ID Secretaria</th>
                                                <td><strong>{{ $secretaria->id_secretaria }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>DNI</th>
                                                <td><strong>{{ $secretaria->persona->dni }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Nombres</th>
                                                <td>{{ $secretaria->persona->nombres }}</td>
                                            </tr>
                                            <tr>
                                                <th>Apellidos</th>
                                                <td>{{ $secretaria->persona->apellidos }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nombre Completo</th>
                                                <td><strong>{{ $secretaria->persona->nombres }} {{ $secretaria->persona->apellidos }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Género</th>
                                                <td>
                                                    @if($secretaria->persona->genero == 'M')
                                                        <i class="fas fa-male text-primary"></i> Masculino
                                                    @elseif($secretaria->persona->genero == 'F')
                                                        <i class="fas fa-female text-danger"></i> Femenino
                                                    @else
                                                        {{ $secretaria->persona->genero ?? 'No especificado' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Fecha de Nacimiento</th>
                                                <td>
                                                    @if($secretaria->persona->fecha_nacimiento)
                                                        {{ $secretaria->persona->fecha_nacimiento->format('d/m/Y') }}
                                                        <small class="text-muted">({{ $secretaria->persona->fecha_nacimiento->age }} años)</small>
                                                    @else
                                                        <span class="text-muted">No registrado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    {{-- Datos de Contacto --}}
                                    <div class="info-box">
                                        <h5 class="section-title">
                                            <i class="fas fa-address-book"></i> Datos de Contacto
                                        </h5>
                                        <table class="detail-table">
                                            <tr>
                                                <th>Teléfono</th>
                                                <td>
                                                    @if($secretaria->persona->telefono)
                                                        <i class="fas fa-phone text-success"></i> 
                                                        <a href="tel:{{ $secretaria->persona->telefono }}">{{ $secretaria->persona->telefono }}</a>
                                                    @else
                                                        <span class="text-muted">No registrado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Email Personal</th>
                                                <td>
                                                    @if($secretaria->persona->email)
                                                        <i class="fas fa-envelope text-primary"></i> 
                                                        <a href="mailto:{{ $secretaria->persona->email }}">{{ $secretaria->persona->email }}</a>
                                                    @else
                                                        <span class="text-muted">No registrado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Email Universitario</th>
                                                <td>
                                                    <i class="fas fa-university text-info"></i> 
                                                    <a href="mailto:{{ $secretaria->emailUniversidad }}">
                                                        <strong>{{ $secretaria->emailUniversidad }}</strong>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Dirección</th>
                                                <td>
                                                    @if($secretaria->persona->direccion)
                                                        <i class="fas fa-map-marker-alt text-danger"></i> 
                                                        {{ $secretaria->persona->direccion }}
                                                    @else
                                                        <span class="text-muted">No registrado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- Columna derecha --}}
                                <div class="col-md-6">
                                    {{-- Datos Laborales --}}
                                    <div class="info-box">
                                        <h5 class="section-title">
                                            <i class="fas fa-briefcase"></i> Datos Laborales
                                        </h5>
                                        <table class="detail-table">
                                            <tr>
                                                <th>Fecha de Ingreso</th>
                                                <td>
                                                    @if($secretaria->fecha_ingreso)
                                                        <i class="fas fa-calendar-alt text-success"></i> 
                                                        {{ $secretaria->fecha_ingreso->format('d/m/Y') }}
                                                    @else
                                                        <span class="text-muted">No registrado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Estado</th>
                                                <td>
                                                    @if($secretaria->estado == 'Activo')
                                                        <span class="badge status-badge badge-success">
                                                            <i class="fas fa-check-circle"></i> ACTIVO
                                                        </span>
                                                    @else
                                                        <span class="badge status-badge badge-secondary">
                                                            <i class="fas fa-times-circle"></i> INACTIVO
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Estado Persona</th>
                                                <td>
                                                    @if($secretaria->persona->estado == 'Activo')
                                                        <span class="badge status-badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge status-badge badge-secondary">Inactivo</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    {{-- Información de Usuario --}}
                                    @if($secretaria->persona->usuario)
                                    <div class="info-box">
                                        <h5 class="section-title">
                                            <i class="fas fa-user-lock"></i> Información de Usuario del Sistema
                                        </h5>
                                        <table class="detail-table">
                                            <tr>
                                                <th>Usuario ID:</th>
                                                <td>{{ $secretaria->persona->usuario->id_usuario }}</td>
                                            </tr>
                                            <tr>
                                                <th>Username:</th>
                                                <td><code>{{ $secretaria->persona->usuario->username }}</code></td>
                                            </tr>
                                            <tr>
                                                <th>Email de acceso:</th>
                                                <td><code>{{ $secretaria->persona->usuario->email }}</code></td>
                                            </tr>
                                            <tr>
                                                <th>Estado de usuario:</th>
                                                <td>
                                                    @if($secretaria->persona->usuario->estado == 'Activo')
                                                        <span class="badge status-badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge status-badge badge-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($secretaria->persona->usuario->ultima_sesion)
                                            <tr>
                                                <th>Última sesión:</th>
                                                <td>
                                                    <i class="fas fa-clock text-muted"></i> 
                                                    {{ \Carbon\Carbon::parse($secretaria->persona->usuario->ultima_sesion)->format('d/m/Y H:i:s') }}
                                                    <small class="text-muted">({{ \Carbon\Carbon::parse($secretaria->persona->usuario->ultima_sesion)->diffForHumans() }})</small>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                    @endif

                                    {{-- Roles Asignados --}}
                                    @if($secretaria->persona->roles->count() > 0)
                                    <div class="info-box">
                                        <h5 class="section-title">
                                            <i class="fas fa-user-tag"></i> Roles Asignados
                                        </h5>
                                        <div>
                                            @foreach($secretaria->persona->roles as $rol)
                                                <span class="badge badge-primary mr-2 mb-2" style="font-size: 0.9rem; padding: 0.5rem 0.8rem;">
                                                    <i class="fas fa-shield-alt"></i> {{ $rol->nombre }}
                                                    @if($rol->pivot->estado == 'Activo')
                                                        <i class="fas fa-check-circle text-success ml-1"></i>
                                                    @else
                                                        <i class="fas fa-times-circle text-danger ml-1"></i>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Botones al final --}}
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <a href="{{ route('secretarias.index') }}" class="btn btn-secondary" id="volverBtnBottom">
                                        <i class="fas fa-arrow-left"></i> Volver al listado
                                    </a>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <a href="{{ route('secretarias.edit', $secretaria->id_secretaria) }}" class="btn btn-warning" id="editarBtnBottom">
                                        <i class="fas fa-edit"></i> Editar información
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('loaderPrincipal');
        const contenido = document.getElementById('contenido-principal');
        if (loader) loader.style.display = 'none';
        if (contenido) contenido.style.opacity = '1';

        // Loader para botones de volver
        const volverBtns = document.querySelectorAll('#volverBtn, #volverBtnBottom');
        volverBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        });

        // Loader para botones de editar
        const editarBtns = document.querySelectorAll('#editarBtn, #editarBtnBottom');
        editarBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (loader) {
                    loader.style.display = 'flex';
                }
                setTimeout(() => {
                    window.location.href = this.href;
                }, 800);
            });
        });

        // Mostrar mensajes de éxito o error con SweetAlert2
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#007bff',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session("error") }}',
                confirmButtonColor: '#007bff'
            });
        @endif

        window.addEventListener('pageshow', function(event) {
            if (loader) loader.style.display = 'none';
            if (contenido) contenido.style.opacity = '1';
        });
    });
</script>
@endsection