<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('titulo', 'Inicio | Intranet Eduka Perú')</title>
    <link rel="icon" href="{{ asset('imagenes/imgLogo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('imagenes/imgLogo.png') }}" type="image/png">

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 🔹 jQuery primero -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!--PARA EL DISEÑO DE TABLER-->


    <!-- Fonts and icons -->
    <script src="{{ asset('adminlte/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('adminlte/assets/css/fonts.min.css') }}"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!-- Bootstrap 5 CSS -->
    <!-- ============================= -->
    <!--  Bootstrap 5.3.3 - CSS Oficial -->
    <!-- ============================= -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('adminlte/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/assets/css/atlantis.min.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('adminlte/assets/css/demo.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.css') }}">
    <!-- jQuery (requerido) -->
    <!-- PARA EL CALENDAR-->
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js') }}"></script>

    <script src="{{ asset('https://cdn.jsdelivr.net/npm/flatpickr') }}"></script>
    <!-- Bootstrap Notify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css') }}">

    <!--

<link href="{{ asset('pace/themes/nuna_int/css/style_asistencia.css') }}" rel="stylesheet">
<link href="{{ asset('pace/themes/nuna_int/plugins/alertifyjs/css/themes/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('pace/themes/nuna_int/plugins/alertifyjs/css/alertify.css') }}" rel="stylesheet">
<link href="{{ asset('pace/themes/nuna_int/plugins/fancy/jquery.fancybox.css') }}" rel="stylesheet">
<link href="{{ asset('pace/themes/nuna_int/plugins/magnific/magnific-popup.css') }}" rel="stylesheet">
<link href="{{ asset('pace/themes/nuna_int/css/style_elements.css') }}" rel="stylesheet">
<link href="{{ asset('Content/themes/nuna_int/css/style_actividad.css') }}" rel="stylesheet">
<link href="{{ asset('Content/themes/nuna_int/css/style_ReporteSubvenciones.css') }}" rel="stylesheet">
 -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script type="text/javascript" async=""
        src="https://www.google-analytics.com/gtm/js?id=GTM-KP42DWZ&amp;t=gtag_UA_125387370_2&amp;cid=979822549.1745649107">
    </script>
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
    <script type="text/javascript" async=""
        src="https://www.googletagmanager.com/gtag/js?id=G-ZLTZ3530TL&amp;cx=c&amp;gtm=457e55r0za200&amp;tag_exp=101509157~102015666~103116026~103130498~103130500~103200004~103233427~103252644~103252646~104481633~104481635">
    </script>
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-125387370-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-125387370-2', {
            'optimize_id': 'GTM-KP42DWZ'
        });
    </script>

    <!--
    <script>
        (function(h, o, t, j, a, r) {
            h.hj = h.hj || function() {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {
                hjid: 1431523,
                hjsv: 6
            };
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script>
    <script async="" src="https://static.hotjar.com/c/hotjar-1431523.js?sv=6"></script>
     Hotjar Tracking Code for http://localhost:2254/ -->


    @stack('css-extra')
</head>

<body>

    <style>
        body {
            background-image: url("{{ asset('imagenes/imgFondoIntranet.png') }}");
            z-index: -1;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            font-family: "Quicksand", sans-serif !important;

        }

        body,
        input,
        button,
        select,
        textarea,
        a,
        td,
        li,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        br,
        h6 {
            font-family: "Quicksand", sans-serif !important;
        }

        p,
        th,
        strong {
            font-family: "Quicksand", sans-serif !important;
            font-weight: 800 !important;
            /* negrita ligera (puedes usar 700 para más intensidad) */

            /* ligeramente más grande que el tamaño base */
        }
    </style>


    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" style="background-color: #0F3E61;">

                <a class="logo">

                    <img src="{{ asset('imagenes/Imagen1.png') }}" alt="Logo de la empresa" style="height: 70px;">
                </a>

                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>

            <!-- End Logo Header -->
            <style>
                .tooltip-wrapper {
                    position: relative;
                    display: inline-block;
                }

                .tooltip-wrapper .custom-tooltip {
                    visibility: hidden;
                    background-color: #DD1558;
                    color: white;
                    text-align: center;
                    border-radius: 6px;
                    padding: 6px 10px;
                    position: absolute;
                    top: 125%;
                    left: 50%;
                    transform: translateX(-50%);
                    white-space: nowrap;
                    opacity: 0;
                    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
                    z-index: 9999;
                }

                .tooltip-wrapper .custom-tooltip::after {
                    content: "";
                    position: absolute;
                    top: -6px;
                    left: 50%;
                    transform: translateX(-50%);
                    border-width: 6px;
                    border-style: solid;
                    border-color: transparent transparent #DD1558 transparent;
                }

                .tooltip-wrapper:hover .custom-tooltip {
                    visibility: visible;
                    opacity: 1;
                    transform: translateX(-50%) translateY(2px);
                }
            </style>
            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" style="background-color: #114871;">

                <div class="container-fluid">

                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <div class="tooltip-wrapper">
                                <a class="nav-link evitar-recarga" href="{{ route('rutarrr1') }}">
                                    <i class="fas fa-home" style="color: white"></i>
                                </a>
                                <div class="custom-tooltip">Ir a inicio</div>
                            </div>
                        </li>

                        <style>
                            .nav-link:hover i {
                                color: #0e4067 !important;
                                transition: color 0.3s ease;
                            }
                        </style>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                document.querySelectorAll('.evitar-recarga').forEach(link => {
                                    link.addEventListener('click', function(e) {
                                        const destino = this.href;
                                        const actual = window.location.href;

                                        if (actual === destino || actual.split('?')[0] === destino) {
                                            e.preventDefault();

                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Ya estás aquí',
                                                text: 'Actualmente estás visualizando esta sección.',
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 1000,
                                                timerProgressBar: true
                                            });
                                        }
                                    });
                                });
                            });
                        </script>

                        <!-- BOTÓN DE APERTURA -->
                        <li class="nav-item dropdown hidden-caret">
                            <div class="tooltip-wrapper">
                                <a href="#correo" class="nav-link" onclick="handleContactClick(event)">
                                    <i class="fa fa-envelope" style="color: white"></i>
                                </a>
                                <div class="custom-tooltip">¿Necesitas ayuda?</div>
                            </div>
                        </li>

                        <script>
                            function handleContactClick(event) {
                                event.preventDefault(); // evita salto al hash

                                // Detectar tamaño de pantalla
                                const ancho = window.innerWidth;

                                // Si es móvil (menor a 768px), abrir mail
                                if (ancho < 768) {
                                    window.location.href =
                                        'mailto:rcroblesro@unitru.edu.pe?subject=Soporte Eduka&body=Hola, necesito ayuda con...';
                                } else {
                                    // En pantallas grandes, abrir el modal normal
                                    abrirModalMensaje();
                                }
                            }
                        </script>


                        <!-- MODAL BOTÓN AYUDA-->
                        <div id="modalMensaje" class="modal-overlay" style="display: none;">
                            <div class="modal-content">
                                <a class="logo mb-3" style="text-align: center;">
                                    <img src="{{ asset('img_eduka.png') }}" alt="Logo de la empresa"
                                        style="height: 44px;">
                                </a>

                                <button class="cerrar" onclick="cerrarModalMensaje()">x</button>

                                <h2>
                                    Comunícate con nuestros Asesores
                                </h2>

                                <p class="text-center mb-2">
                                    Soy tu tío Eduka, tu asistente virtual de Eduka Perú. Estoy aquí para ayudarte con
                                    tus consultas sobre registros, reportes y demás.
                                </p>

                                <!-- Línea divisoria ajustada -->
                                <hr style="border: none; border-top: 2px solid #28AECE; margin: 8px 0;">

                                <form method="POST" action="{{ route('send.email') }}">
                                    @csrf
                                    <div class="form-group mb-1">
                                        <label for="name" class="font-weight-bold">Nombre</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Nombre de Usuario" autocomplete="off"
                                            value="{{ auth()->user()->nombres }}">
                                    </div>

                                    <div class="form-group mb-1">
                                        <label for="email" class="font-weight-bold">Correo electrónico</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="tucorreo@ejemplo.com" autocomplete="off"
                                            value="{{ auth()->user()->email }}">
                                    </div>

                                    <div class="form-group mb-1">
                                        <label for="message" class="font-weight-bold">Mensaje</label>
                                        <textarea name="message" id="message" class="form-control" rows="5" placeholder="Escribe tu mensaje aquí"
                                            required></textarea>
                                    </div>

                                    <div class="modal-actions text-center">
                                        <button type="button" onclick="cerrarModalMensaje()"
                                            class="btn btn_blue">Cancelar</button>
                                        <button type="submit" class="btn btn_blue px-4 py-2"
                                            style="border-radius: 5px;">
                                            <i class="fas fa-paper-plane"></i> Enviar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- ESTILOS -->
                        <style>
                            .modal-overlay {
                                position: fixed;
                                top: 0;
                                left: 0;
                                right: 0;
                                bottom: 0;
                                background: rgba(0, 0, 0, 0.5);
                                z-index: 99999;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                padding: 1rem;
                                overflow-y: auto;
                            }

                            .modal-content {
                                background: white;
                                width: 100%;
                                max-width: 600px;
                                padding: 20px;
                                border-radius: 10px;
                                position: relative;
                                box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
                                font-family: "Quicksand", sans-serif;
                                z-index: 100000;
                            }

                            /* Responsive para móviles */
                            @media (max-width: 576px) {
                                .modal-content {
                                    padding: 15px;
                                }

                                .modal-content h2 {
                                    font-size: 18px;
                                }

                                .modal-content p {
                                    font-size: 14px;
                                }
                            }

                            .modal-content h2 {
                                font-size: 22px;
                                color: #28AECE;
                                margin-bottom: 15px;
                                font-weight: bold;
                                text-align: center;
                                font-family: "Quicksand", sans-serif;
                            }

                            .modal-content p {
                                font-size: 15px;
                                margin-bottom: 15px;
                                color: #5a5a5a;
                                text-align: center;
                                font-family: "Quicksand", sans-serif;
                            }

                            .modal-content label {
                                display: block;
                                margin-top: 10px;
                                font-weight: bold;
                            }

                            .modal-content input,
                            .modal-content textarea {
                                width: 100%;
                                padding: 8px;
                                margin-top: 2px;
                                border: 1px solid #F49414 !important;
                                border-radius: 5px;
                            }

                            .modal-actions {
                                display: flex;
                                justify-content: flex-end;
                                gap: 10px;
                                margin-top: 20px;
                            }

                            .modal-actions button:first-child {
                                background: #ccc;
                                color: white;
                            }

                            .modal-actions button:last-child {
                                background: #e91e63;
                                color: white;
                            }

                            .cerrar {
                                position: absolute;
                                top: 10px;
                                right: 15px;
                                border: none;
                                background: transparent;
                                font-size: 24px;
                                font-weight: bold;
                                cursor: pointer;
                                color: #aaa;
                            }
                        </style>

                        <!-- SCRIPTS -->
                        <script>
                            function abrirModalMensaje() {
                                document.getElementById("modalMensaje").style.display = "flex";
                                document.body.style.overflow = "hidden";
                            }

                            function cerrarModalMensaje() {
                                document.getElementById("modalMensaje").style.display = "none";
                                document.body.style.overflow = "auto";
                            }
                        </script>


                        <li class="nav-item dropdown hidden-caret d-none d-md-block">

                            <div class="tooltip-wrapper">
                                <a class="nav-link" data-toggle="dropdown" href="#frecuente" aria-expanded="false">
                                    <i class="fas fa-layer-group" style="color: white"></i>
                                </a>

                                <div id="quick"
                                    class="dropdown-menu quick-actions quick-actions-primary animated fadeIn d-none">
                                    <div class="quick-actions-header" style="background: #e91e63;">
                                        <span class="title mb-1">Operaciones Frecuentes</span>
                                        <span class="subtitle op-8">Registre adecuadamente los datos</span>

                                        @if (auth()->user()->persona && auth()->user()->persona->roles->contains('nombre', 'Administrador'))
                                            <script>
                                                document.getElementById('quick').classList.remove('d-none');
                                            </script>
                                        @endif
                                    </div>
                                    @if (auth()->user()->persona && auth()->user()->persona->roles->contains('nombre', 'Administrador'))
                                        <div class="quick-actions-scroll scrollbar-outer">
                                            <div class="quick-actions-items">
                                                <div class="row m-0">
                                                    <a class="col-6 col-md-4 p-0"
                                                        href="{{ route('matriculas.create') }}">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-file-1"></i>
                                                            <span class="text">Matrícula Regular</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="{{ route('notas.inicio') }}">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-pen"></i>
                                                            <span class="text">Registrar Notas</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0"
                                                        href="{{ route('notas.consulta') }}">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-list"></i>
                                                            <span class="text">Ver Reporte de Notas</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0"
                                                        href="{{ route('registrarcurso.index') }}">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-file-1"></i>
                                                            <span class="text">Registrar Cursos</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0"
                                                        href="{{ route('registrardocente.index') }}">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-user-3"></i>
                                                            <span class="text">Registrar Docentes</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0"
                                                        href="{{ route('estudiante.index') }}">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-user-1"></i>
                                                            <span class="text">Registrar Estudiantes</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="custom-tooltip">Operaciones Frecuentes</div>
                            </div>

                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="{{ asset('adminlte/assets/img/profile.jpg') }}"
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img
                                                    src="{{ asset('adminlte/assets/img/profile.jpg') }}"
                                                    class="avatar-img rounded"></div>
                                            <div class="u-text">
                                                <h4>{{ auth()->user()->nombres }}<br>{{ auth()->user()->apellidos }}
                                                </h4>
                                                <p class="text-muted">{{ auth()->user()->email }}</p>
                                                <a href="#" class="btn btn-xs btn-secondary btn-sm"
                                                    style="background-color: #e91e63 !important; border: none">Ver
                                                    Perfil</a>
                                            </div>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>


                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>

                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Cerrar sesión
                                        </a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user nuevo-user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="{{ asset('imagenes/imgDocente.png') }}" alt="..."
                                class="avatar-img rounded-circle" style="border: 1px solid #4b4e51">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" aria-expanded="true">

                                <span>
                                    {{ auth()->user()->nombres }}
                                    <span class="user-level">{{ auth()->user()->rol }}</span>

                                </span>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <ul class="nav nav-primary">
                        <!--
      <li class="nav-item active">
       <a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
        <i class="fas fa-home"></i>
        <p>OPCIONES</p>
        <span class="caret"></span>
       </a>
       <div class="collapse" id="dashboard">
        <ul class="nav nav-collapse">
         <li>
          <a href="adminlte/demo1/index.html">
           <span class="sub-item">Matrículas</span>
          </a>
         </li>
         <li>
          <a href="adminlte/demo2/index.html">
           <span class="sub-item">Notas</span>
          </a>
         </li>
         <li>
          <a href="adminlte/demo2/index.html">
           <span class="sub-item">Asistencia</span>
          </a>
         </li>
        </ul>
       </div>
      </li>
    -->
                        @if (auth()->user()->persona && auth()->user()->persona->roles->contains('nombre', 'Administrador'))
                            <li class="nav-item active mt-3">
                                <a data-toggle="collapse" href="#matriculas1"
                                    class="collapsed d-flex align-items-center justify-content-between btn-matricula"
                                    aria-expanded="false"
                                    style="background-color: #347f65  !important; border-radius: 9px; color: white;  ">
                                    <div class="d-flex align-items-center">
                                        <i class="far fa-id-card"></i>
                                        <p class="mb-0 ms-2">Matrículas</p>
                                    </div>
                                    <i class="fas fa-angle-down rotate-icon d-none "></i>
                                </a>

                                <div class="collapse" id="matriculas1">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('matriculas.create') }}">
                                                <span class="sub-item">Matrícula Regular</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('matriculas.index') }}">
                                                <span class="sub-item">Consultar Matrículas</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item active mt-3">
                                <a data-toggle="collapse" href="#pagos"
                                    class="collapsed d-flex align-items-center justify-content-between"
                                    aria-expanded="false"
                                    style="background-color: #b68a39 !important; border-radius: 9px;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        <p>Pagos</p>
                                    </div>
                                    <i class="fas fa-angle-down rotate-icon d-none "></i>
                                </a>
                                <div class="collapse" id="pagos">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('conceptospago.index') }}">
                                                <span class="sub-item">Conceptos de Pagos</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('pagos.index') }}">
                                                <span class="sub-item">Pagos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item active mt-3">
                                <a data-toggle="collapse" href="#asistencia-admin"
                                    class="collapsed d-flex align-items-center justify-content-between"
                                    aria-expanded="false" style="background-color: #3a6f92 !important">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-check"></i>
                                        <p>Asistencia</p>
                                    </div>
                                    <!--<i class="fas fa-angle-down rotate-icon"></i>-->
                                </a>
                                <div class="collapse" id="asistencia-admin">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('asistencia.admin-index') }}">
                                                <span class="sub-item">Administrar Asistencias</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('asistencia.verificar') }}">
                                                <span class="sub-item">Verificar Justificaciones</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('asistencia.reporte-general') }}">
                                                <span class="sub-item">Reportes Generales</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                        @if (auth()->user()->persona && auth()->user()->persona->roles->contains('nombre', 'Profesor'))
                            <li class="nav-item active mt-3">
                                <a data-toggle="collapse" href="#asistencia"
                                    class="collapsed d-flex align-items-center justify-content-between"
                                    aria-expanded="false" style="background-color: #3a6f92 !important">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-invoice-dollar me-2"></i>
                                        <p>Asistencias</p>
                                    </div>
                                    <!--<i class="fas fa-angle-down rotate-icon"></i>-->
                                </a>
                                <div class="collapse" id="asistencia">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('asistencia.index') }}">
                                                <span class="sub-item">Asistencia Diaria</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif

                        <li class="nav-item active mt-3">
                            <a data-toggle="collapse" href="#notas"
                                class="collapsed d-flex align-items-center justify-content-between btn-nuevo"
                                aria-expanded="false"
                                style="background-color: #7a2e40 !important; border-radius: 9px; display:">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clipboard-list me-2"></i>
                                    <p class="mb-0">Notas</p>
                                </div>
                                <i class="fas fa-angle-down rotate-icon d-none "></i>
                            </a>

                            <div class="collapse" id="notas">
                                <ul class="nav nav-collapse">
                                    @if (auth()->user()->persona && (auth()->user()->persona->roles->contains('nombre', 'Administrador') || auth()->user()->persona->roles->contains('nombre', 'Profesor')))
                                        <li>
                                            <a href="{{ route('notas.inicio') }}">
                                                <span class="sub-item">Registrar Notas</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->persona && auth()->user()->persona->roles->contains('nombre', 'Representante'))
                                        <li>
                                            <a href="{{ route('notas.misEstudiantes') }}">
                                                <span class="sub-item">Mis Estudiantes</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->persona && auth()->user()->persona->roles->contains('nombre', 'Administrador'))
                                        <li>
                                            <a href="{{ route('notas.consulta') }}">
                                                <span class="sub-item">Ver Notas</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>

                        @if (auth()->user()->persona && auth()->user()->persona->roles->contains('nombre', 'Representante'))
                            <li class="nav-item active mt-3">
                                <a data-toggle="collapse" href="#asistencia-representante"
                                    class="collapsed d-flex align-items-center justify-content-between"
                                    aria-expanded="false" style="background-color: #3a6f92 !important">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        <p class="mb-0">Asistencia</p>
                                    </div>
                                    <!--<i class="fas fa-angle-down rotate-icon"></i>-->
                                </a>
                                <div class="collapse" id="asistencia-representante">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('asistencia.misEstudiantes') }}">
                                                <span class="sub-item">Mis Estudiantes</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                        <style>
                            .rotate-icon {
                                transition: transform 0.3s ease;
                            }

                            a[aria-expanded="true"] .rotate-icon {
                                transform: rotate(180deg);
                            }
                        </style>
                        @if (auth()->user()->persona && auth()->user()->persona->roles->contains('nombre', 'Administrador'))
                            <li class="nav-section">
                                <span class="sidebar-mini-icon">
                                    <i class="fa fa-ellipsis-h"></i>
                                </span>
                                <h4 class="text-section">OPCIONES</h4>
                            </li>


                            <li class="nav-item active mb-2">
                                <a data-toggle="collapse" href="#base" class="collapsed" aria-expanded="false"
                                    style="background-color: #a9a97d !important; border-color: #ccc; color: #333;">
                                    <i class="fas fa-university" style="color: #333;"></i>
                                    <p style="margin-bottom: 0;">Gestión Académica</p>
                                    <span class="caret"></span>
                                </a>

                                <div class="collapse" id="base">

                                    <ul class="nav nav-collapse">

                                        <li>
                                            <a href="{{ route('asignaturas.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Asignaturas</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('periodos-evaluacion.index') }}"
                                                class="evitar-recarga">
                                                <span class="sub-item">Periodos de Evaluación</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('registrarcurso.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Registrar Cursos</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item active mb-2">
                                <a data-toggle="collapse" href="#docente" class="collapsed" aria-expanded="false"
                                    style="background-color: #a9a97d !important; border-color: #ccc; color: #333;">
                                    <i class="fas fa-chalkboard-teacher" style="color: #333;"></i>
                                    <p style="margin-bottom: 0;">Gestión Docentes</p>
                                    <span class="caret"></span>
                                </a>

                                <div class="collapse" id="docente">

                                    <ul class="nav nav-collapse">

                                        <li>
                                            <a href="{{ route('cursoasignatura.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Carga Académica</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item active mb-2">
                                <a data-toggle="collapse" href="#Estudiantil" class="collapsed"
                                    aria-expanded="false"
                                    style="background-color: #a9a97d !important; border-color: #ccc; color: #333;">
                                    <i class="fas fa-grip-horizontal" style="color: white;"></i>
                                    <p>Gestión Estudiantil</p>
                                    <span class="caret"></span>
                                </a>

                                <div class="collapse" id="Estudiantil">

                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('estudiante.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Estudiantes</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('registrarrepresentante.index') }}"
                                                class="evitar-recarga">
                                                <span class="sub-item">Representantes</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item active mb-2">
                                <a data-toggle="collapse" href="#Personal" class="collapsed" aria-expanded="false"
                                    style="background-color: #a9a97d !important; border-color: #ccc; color: #333;">
                                    <i class="fas fa-grip-horizontal" style="color: white;"></i>
                                    <p>Plana Docente</p>
                                    <span class="caret"></span>
                                </a>

                                <div class="collapse" id="Personal">

                                    <ul class="nav nav-collapse">

                                        <li>
                                            <a href="{{ route('registrardocente.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Docentes</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item active mb-2">
                                <a data-toggle="collapse" href="#Educativa" class="collapsed" aria-expanded="false"
                                    style="background-color: #a9a97d !important; border-color: #ccc; color: #333;">
                                    <i class="fas fa-grip-horizontal" style="color: white;"></i>
                                    <p>Estructura Educativa</p>
                                    <span class="caret"></span>
                                </a>

                                <div class="collapse" id="Educativa">

                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('registrarnivel.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Niveles Educativos</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('aulas.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Aulas</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('grados.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Grados</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('secciones.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Secciones</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('aniolectivo.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Año Lectivo</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <!--
      <li class="nav-item">
       <a data-toggle="collapse" href="#matriculas">
        <i class="far fa-id-card"></i>
        <p>Matrículas</p>
        <span class="caret"></span>
       </a>
       <div class="collapse" id="matriculas">
        <ul class="nav nav-collapse">
         <li>
          <a href="{{ route('matriculas.index') }}">
           <span class="sub-item">Matrícula Regular</span>
          </a>
         </li>
         <li>
          <a href="{{ route('conceptospago.index') }}">
           <span class="sub-item">Conceptos de Pagos</span>
          </a>
         </li>
         <li>
          <a href="{{ route('pagos.index') }}">
           <span class="sub-item">Pagos</span>
          </a>
         </li>
        </ul>
       </div>
      </li>
-->
                            <li class="nav-item active mb-2">
                                <a data-toggle="collapse" href="#Sistema" class="collapsed" aria-expanded="false"
                                    style="background-color: #a9a97d !important; border-color: #ccc; color: #333;">
                                    <i class="fas fa-cogs" style="color: #333;"></i>
                                    <p>Sistema</p>
                                    <span class="caret"></span>
                                </a>

                                <div class="collapse" id="Sistema">

                                    <ul class="nav nav-collapse">

                                        <li>
                                            <a href="{{ route('feriados.index') }}" class="evitar-recarga">
                                                <span class="sub-item">Feriados</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item active mb-2">
                                <a data-toggle="collapse" href="#Usuarios" class="collapsed" aria-expanded="false"
                                    style="background-color: #a9a97d !important; border-color: #ccc; color: #333;">
                                    <i class="fas fa-grip-horizontal" style="color: white;"></i>
                                    <p>Gestión de Usuarios</p>
                                    <span class="caret"></span>
                                </a>

                                <div class="collapse" id="Usuarios">

                                    <ul class="nav nav-collapse">

                                        <li>
                                            <a href="{{ route('usuarios.index') }}">
                                                <span class="sub-item">Detalle Usuario</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('personas.index') }}">
                                                <span class="sub-item">Personas</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('roles.index') }}">
                                                <span class="sub-item">Roles</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item active mb-2">
                                <a data-toggle="collapse" href="#Tramites" class="collapsed" aria-expanded="false"
                                    style="background-color: #a9a97d !important; border-color: #ccc; color: #333;">
                                    <i class="fas fa-folder-open" style="color: white;"></i>
                                    <p>Gestión de Trámites</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="Tramites">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a data-toggle="collapse" href="#ConfigTramites" class="collapsed" aria-expanded="false">
                                                <span class="sub-item"><i class="fas fa-cogs mr-1"></i> Configuración</span>
                                            </a>
                                            <div class="collapse" id="ConfigTramites">
                                                <ul class="nav nav-collapse">
                                                    <li>
                                                        <a href="{{ route('procesos.index') }}">
                                                            <span class="sub-item">Procesos</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('pasos.index') }}">
                                                            <span class="sub-item">Pasos</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('proceso_pasos.index') }}">
                                                            <span class="sub-item">Estructura del Proceso</span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <a data-toggle="collapse" href="#OperacionTramites" class="collapsed" aria-expanded="false">
                                                <span class="sub-item"><i class="fas fa-tasks mr-1"></i> Gestión</span>
                                            </a>
                                            <div class="collapse" id="OperacionTramites">
                                                <ul class="nav nav-collapse">
                                                    <li>
                                                        <a href="{{ route('estudiante_procesos.index') }}">
                                                            <span class="sub-item">Expedientes</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('estudiante_proceso_pasos.index') }}">
                                                            <span class="sub-item">Avance por Paso</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('documentos.index') }}">
                                                            <span class="sub-item">Documentos</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="content">
                @php
    // Fecha límite para mostrar el carousel
    $fechaLimite = \Carbon\Carbon::create(2025, 11, 06); // Año, mes, día
    $hoy = \Carbon\Carbon::now();
@endphp

@if (Request::is('rutarrr1') && $hoy->lte($fechaLimite))
    <div class="carousel-container d-none d-md-block">
        <div id="flyerCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="{{ asset('imagenes/flyer1.png') }}" alt="Flyer 1"
                        oncontextmenu="return false;" ondragstart="return false;"
                        style="user-select: none;">
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('imagenes/flyer3.png') }}" alt="Flyer 3"
                        oncontextmenu="return false;" ondragstart="return false;"
                        style="user-select: none;">
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('imagenes/flyer2.png') }}" alt="Flyer 2"
                        oncontextmenu="return false;" ondragstart="return false;"
                        style="user-select: none;">
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Ajustes para contenedor principal */
        .main-panel>.content {
            padding: 0 !important;
            height: calc(100vh - 70px);
            overflow: hidden;
        }

        /* Contenedor del carrusel */
        .carousel-container {
            height: 100%;
            width: 100%;
        }

        /* Estilos para el carrusel y el contenedor de slides */
        #flyerCarousel,
        .carousel-inner {
            height: 100%;
        }

        /* Estilos para los elementos del carrusel */
        .carousel-item {
            height: 100%;
            text-align: center;
        }

        /* Centrado de imágenes */
        .carousel-item img {
            max-height: calc(100vh - 100px);
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            margin: 0 auto;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Controles del carrusel */
        .carousel-control-prev,
        .carousel-control-next {
            width: 10%;
            opacity: 0.7;
            z-index: 5;
        }
    </style>
@endif


                @yield('contenidoplantilla')
                @if (session('modal_success'))
                    <!-- Modal -->
                    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-success shadow-lg">
                                <div class="modal-header bg-light border-0 justify-content-center">
                                    <img src="{{ asset('img_eduka.png') }}" alt="Logo" style="height: 60px;">
                                </div>
                                <div class="modal-body text-center">
                                    <h5 class="text-success fw-bold d-flex justify-content-center align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="#198754" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 11.001 8a8 8 0 0115.998 0zM6.97 11.03a.75.75 0 001.07 0l3.992-3.992a.75.75 0 00-1.06-1.06L7.5 9.44 6.1 8.03a.75.75 0 00-1.06 1.06l1.93 1.94z" />
                                        </svg>
                                        ¡Éxito!
                                    </h5>
                                    <p class="mt-2">{{ session('modal_success') }}</p>
                                </div>
                                <div class="modal-footer justify-content-center border-0">
                                    <button type="button" class="btn btn-outline-success px-4"
                                        data-bs-dismiss="modal">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Script para mostrar el modal y cerrarlo automáticamente -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const modalElement = document.getElementById('successModal');
                            const modal = new bootstrap.Modal(modalElement);
                            modal.show();

                            setTimeout(() => {
                                modal.hide();
                            }, 5000); // 5000 ms = 5 segundos
                        });
                    </script>
                @endif


            </div>
        </div>

    </div>

    <!-- Custom template | don't include it in your project!
  <div class="custom-template">
   <div class="title">Settings</div>
   <div class="custom-content">
    <div class="switcher">
     <div class="switch-block">
      <h4>Logo Header</h4>
      <div class="btnSwitch">
       <button type="button" class="changeLogoHeaderColor" data-color="dark"></button>
       <button type="button" class="selected changeLogoHeaderColor" data-color="blue"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
       <br/>
       <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
       <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
      </div>
     </div>
     <div class="switch-block">
      <h4>Navbar Header</h4>
      <div class="btnSwitch">
       <button type="button" class="changeTopBarColor" data-color="dark"></button>
       <button type="button" class="changeTopBarColor" data-color="blue"></button>
       <button type="button" class="changeTopBarColor" data-color="purple"></button>
       <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
       <button type="button" class="changeTopBarColor" data-color="green"></button>
       <button type="button" class="changeTopBarColor" data-color="orange"></button>
       <button type="button" class="changeTopBarColor" data-color="red"></button>
       <button type="button" class="changeTopBarColor" data-color="white"></button>
       <br/>
       <button type="button" class="changeTopBarColor" data-color="dark2"></button>
       <button type="button" class="selected changeTopBarColor" data-color="blue2"></button>
       <button type="button" class="changeTopBarColor" data-color="purple2"></button>
       <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
       <button type="button" class="changeTopBarColor" data-color="green2"></button>
       <button type="button" class="changeTopBarColor" data-color="orange2"></button>
       <button type="button" class="changeTopBarColor" data-color="red2"></button>
      </div>
     </div>
     <div class="switch-block">
      <h4>Sidebar</h4>
      <div class="btnSwitch">
       <button type="button" class="selected changeSideBarColor" data-color="white"></button>
       <button type="button" class="changeSideBarColor" data-color="dark"></button>
       <button type="button" class="changeSideBarColor" data-color="dark2"></button>
      </div>
     </div>
     <div class="switch-block">
      <h4>Background</h4>
      <div class="btnSwitch">
       <button type="button" class="changeBackgroundColor" data-color="bg2"></button>
       <button type="button" class="changeBackgroundColor selected" data-color="bg1"></button>
       <button type="button" class="changeBackgroundColor" data-color="bg3"></button>
       <button type="button" class="changeBackgroundColor" data-color="dark"></button>
      </div>
     </div>
    </div>
   </div>

   <div class="custom-toggle">
    <i class="flaticon-settings"></i>
   </div>
  </div>-->
    <!-- End Custom template -->
    </div>
    <!-- Core JS Files -->
    <script src="{{ asset('adminlte/assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('adminlte/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('adminlte/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('adminlte/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('adminlte/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('adminlte/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('adminlte/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('adminlte/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('adminlte/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('adminlte/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->


    <!-- jQuery Vector Maps -->
    <script src="{{ asset('adminlte/assets/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('adminlte/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('adminlte/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('adminlte/assets/js/atlantis.min.js') }}"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('adminlte/assets/js/setting-demo.js') }}"></script>
    @yield('scripts')

    <script>
        if (performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
            location.href = "{{ route('login') }}"; // redirige directo si vuelve con botón atrás
        }
    </script>

    <link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

    <style>
        /* ========================
     PANTALLA DE BIENVENIDA
  =========================*/
        #welcomeSplash {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #143853;
            /* Fondo EDUKA sobrio */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            opacity: 0;
            pointer-events: none;
            transform: scale(1.05);
            transition: opacity 1.2s ease, transform 1.2s ease;
        }

        #welcomeSplash.show {
            opacity: 1;
            pointer-events: auto;
            transform: scale(1);
        }

        #welcomeSplash .content {
            text-align: center;
            animation: fadeSlide 2s ease forwards;
        }

        #welcomeSplash img {
            width: 300px;
            opacity: 0;
            animation: fadeZoom 2s ease forwards;
        }

        @keyframes fadeZoom {
            0% {
                opacity: 0;
                transform: scale(0.7) rotate(-10deg);
            }

            60% {
                opacity: 1;
                transform: scale(1.2) rotate(2deg);
            }

            100% {
                opacity: 1;
                transform: scale(1) rotate(0);
            }
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========================
     ESTILOS DEL TOUR INTROJS
  =========================*/
        .introjs-tooltip {
            background: #1c1c1c !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 18px !important;
            font-family: "Quicksand", sans-serif !important;
            font-size: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .introjs-tooltip-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 5px;
            color: #b68a39 !important;
            font-family: "Quicksand", sans-serif !important;
            /* Dorado EDUKA */
        }

        .introjs-overlay {
            background: rgba(0, 0, 0, 0.75) !important;
        }

        .introjs-helperLayer {
            background: transparent !important;
            border: 2px solid #b68a39 !important;
            border-radius: 12px !important;
        }

        .introjs-progressbar {
            background: #7a2e40 !important;
        }

        .introjs-button {
            border-radius: 8px !important;
            padding: 8px 14px !important;
            font-weight: 600 !important;
            border: none !important;
            font-family: "Quicksand", sans-serif !important;
        }

        .introjs-nextbutton {
            background: #368557 !important;
            color: #fff !important;
        }

        .introjs-prevbutton {
            background: #295471 !important;
            color: #fff !important;
        }

        .introjs-donebutton {
            background: #832f42 !important;
            color: #fff !important;
        }
    </style>

    <!-- Splash -->
    <div id="welcomeSplash">
        <div class="content">
            <img src="/imagenes/Imagen1.png" alt="Eduka Logo">
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ✅ Revisamos si ya se mostró el tour antes
            if (!localStorage.getItem("tourCompletado")) {
                const intro = introJs();

                intro.setOptions({
                    steps: [{
                            element: document.querySelector('[href="#matriculas1"]'),
                            intro: "🎓 <b>Matrículas:</b> gestiona la inscripción de tus estudiantes."
                        },
                        {
                            element: document.querySelector('[href="#pagos"]'),
                            intro: "💰 <b>Pagos:</b> administra los pagos fácilmente."
                        },
                        {
                            element: document.querySelector('[href="#asistencia"]'),
                            intro: "📋 <b>Asistencia:</b> controla la asistencia de los estudiantes."
                        },
                        {
                            element: document.querySelector('[href="#notas"]'),
                            intro: "📊 <b>Notas:</b> registra y consulta el rendimiento académico."
                        },
                        {
                            element: document.querySelector('[href="#frecuente"]'),
                            intro: "⚡ <b>Operaciones frecuentes:</b> accesos rápidos para ahorrar tiempo."
                        },
                        {
                            element: document.querySelector('[href="#correo"]'),
                            intro: "✉️ <b>Solicitudes:</b> envía peticiones al Administrador fácilmente."
                        }
                    ],
                    showProgress: true,
                    showBullets: false,
                    disableInteraction: true,
                    nextLabel: 'Siguiente →',
                    prevLabel: '← Atrás',
                    doneLabel: '¡Finalizar!'
                });

                function mostrarSplash() {
                    let splash = document.getElementById('welcomeSplash');
                    splash.classList.add('show');
                    setTimeout(() => {
                        splash.classList.remove('show');
                    }, 4000);
                }

                // ✅ Cuando finalice o salga, guardamos la marca en localStorage
                intro.oncomplete(() => {
                    localStorage.setItem("tourCompletado", "true");
                    mostrarSplash();
                });

                intro.onexit(() => {
                    localStorage.setItem("tourCompletado", "true");
                    mostrarSplash();
                });

                intro.start();
            }
        });
    </script>

    @stack('js-extra')

</body>

</html>
