<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Acceso al sistema | Eduka Perú</title>
    <link rel="icon" href="{{ asset('imagenes/imgLogo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('imagenes/imgLogo.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Para el icono de Google -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">

    <style>
        body {

            /*background-image: url("{{ asset('imagenes/imgFondoIntranet.png') }}"); */
            background-color: #f6f4f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: "Poppins", sans-serif;
        }

        /* Cuando el ancho de pantalla sea menor o igual a 576px (Bootstrap sm) */
        @media (max-width: 576px) {
            body {
                background-color: #ffffff;
            }
        }

        .no-copy {
            pointer-events: none;
            user-select: none;
        }

        .login-wrapper {
            background-color: white;
            border-radius: 1.5rem;
            width: 100%;
            max-width: 1100px;
            display: flex;
            flex-direction: row;
            padding: 3rem;
        }

        .left-panel {
            flex: 1;
            padding-right: 2rem;
        }

        .right-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            border-radius: 0.5rem;
            height: 3rem;
        }

        .btn-primary {
            border-radius: 0.7rem;
            padding: 0.56rem 2.4rem;
            background-color: #104E87 !important;
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0E4678;
        }

        .text-muted a {
            text-decoration: none;
            font-size: 0.9rem;
        }

        .text-muted a:hover {
            text-decoration: underline;
        }

        .bottom-links {
            font-size: 0.85rem;
            margin-top: 2rem;
            color: #5f6368;
        }


        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                padding: 2rem;
            }

            .left-panel {
                padding-right: 0;
                margin-bottom: 2rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <!-- Left Panel -->
        <div class="left-panel mt-1">
            <img src="img_eduka.png" alt="Eduka" class="img-fluid no-copy" style="max-height: 54px;"
                draggable="false" oncontextmenu="return false;" ondragstart="return false;" style="user-select: none;">
            <h2 class="mt-3">Inicia sesión</h2>
            <p>Usa tu Cuenta Institucional</p>
        </div>
        <!-- Modal de éxito -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: "info",
                        title: "¡Estimado Usuario!",
                        text: "{{ session('error') }}",
                        footer: '<a href="https://romeros-pe.web.app" target="_blank" rel="noopener noreferrer">eduka.edu.pe</a>',
                        scrollbarPadding: false, // evita cambios por el scrollbar
                        heightAuto: false, // evita que SweetAlert cambie el tamaño/alto del body
                        backdrop: true,
                        allowEscapeKey: true,
                        allowOutsideClick: true,
                        didOpen: () => {
                            // opcional: si quieres quitar el foco automático en inputs
                            const input = document.querySelector('.swal2-input');
                            if (input) input.blur();
                        }
                    });
                });
            </script>
        @endif


        <!-- Right Panel -->
        <div class="right-panel">
            <form method="POST" action="{{ route('identificacion') }}">
                @csrf

                <!--
                <div class="mb-1">
                    <label for="correo" class="form-label">Correo electrónico o usuario</label>

                    <input id="email" type="text" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Correo electrónico o usuario" value="{{ old('email') }}">
                    @error('email')
    <span class="invalid-feedback d-block text-start">{{ $message }}</span>
@enderror
                </div>

                <div class="form-floating mb-1">
                    <input id="email" type="text" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Correo electrónico o usuario" value="{{ old('email') }}">
                    <label for="email">Correo electrónico o usuario</label>
                    @error('email')
    <span class="invalid-feedback d-block text-start">{{ $message }}</span>
@enderror
                </div>
            -->

                <style>
                    /* Contenedor personalizado estilo Google */
                    .google-input {
                        position: relative;
                        margin-bottom: 0.1rem;

                        font-family: "Poppins", sans-serif !important;
                    }

                    /* Input base */
                    .google-input input {
                        width: 100%;
                        padding: 1rem 0.75rem 0.25rem 0.75rem;
                        font-size: 16px;
                        border: 1px solid #ccc;
                        border-radius: .5rem;
                        background: #fff;
                        outline: none;
                        transition: border-color 0.3s ease;
                    }

                    /* Borde cuando está en focus */
                    .google-input input:focus {
                        border-color: #084e90;
                        box-shadow: 0 0 0 1px #084e90;
                    }

                    /* Label flotante */
                    .google-input label {
                        position: absolute;
                        top: 50%;
                        left: 0.75rem;
                        transform: translateY(-50%);
                        color: #777;
                        font-size: 0.9rem;
                        pointer-events: none;
                        transition: all 0.2s ease;

                    }

                    /* Efecto al escribir o enfocar */
                    .google-input input:focus+label,
                    .google-input input:not(:placeholder-shown)+label {
                        top: 0.1rem;
                        font-size: 0.75rem;
                        color: #084e90;
                        background: #fff;
                        padding: 0 0.25rem;
                        font-weight: bold;
                    }
                </style>

                <div class="google-input mt-1">
                    <input id="email" type="text" name="email" class="@error('email') is-invalid @enderror"
                        placeholder=" " value="{{ old('email') }}" autocomplete="off">
                    <label for="email">Correo electrónico o usuario</label>

                    @error('email')
                        <span id="emailError" class="invalid-feedback d-block text-start"
                            style="font-size: small;">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-5 text-muted">
                    <a href="https://romeros-pe.web.app" target="_blank" style="color: #084e90 !important; font-size:small">Si olvidaste tu correo, comunícate con el administrador.</a>
                </div>

                <p class="text-muted" style="font-size: 0.86rem;">
                    ¡Estimado Usuario! Bienvenido al <b>Sistema Intranet</b> de Eduka Perú Oficial.
                    <a href="https://romeros-pe.web.app" target="_blank" style="color: #084e90 !important;">Explora
                        nuestra plataforma y descubre los servicios que tenemos para ti.</a>
                </p>

                <div class="d-flex justify-content-end gap-3 align-items-center">

                    <a id="google-btn" href="{{ route('google.login') }}" class="btn google-btn"
                        style="border-radius: 0.7rem; font-weight:bold; transition: all 0.4s ease; background-color:rgb(216, 195, 177); color:rgb(60, 52, 34); font-family: 'quicksand', sans-serif;">
                        <i class="fab fa-google mx-2"></i> Acceder con Google
                    </a>

                    <button id="btnSiguiente" type="submit" class="btn btn-primary next-btn" hidden>
                        <span>Siguiente</span>
                    </button>
                </div>

                {{-- Script Para que aparezca el boton siguiente solo cuando hay letras --}}
                <script>
                    const emailInput2 = document.getElementById('email');
                    const btnSgt = document.getElementById('btnSiguiente');
                    const emailError1 = document.getElementById('emailError');

                    emailInput2.addEventListener('input', () => {
                        if (emailInput2.value.trim() !== "") {

                            btnSgt.hidden = false;
                            if (emailError1) {
                                emailError1.remove()
                            }


                        } else {
                            btnSgt.hidden = true;
                        }
                    });
                </script>


                {{-- Estilos --}}
                <style>
                    /* Animación Google */
                    .google-btn {
                        opacity: 1;
                        transform: translateY(0);
                        transition: all 0.4s ease-in-out;
                    }

                    .google-btn.hide {
                        opacity: 0;
                        transform: translateY(-15px);
                        pointer-events: none;
                    }


                    .google-btn:hover {
                        background-color: #c1aa9e !important;
                        transform: scale(1.01);

                    }

                    /* Efecto pulso */
                    .google-btn:hover span {
                        animation: pulse 1s infinite;
                    }

                    /* Animación Google */
                    .next-btn {
                        opacity: 1;
                        transform: translateY(0);
                        transition: all 0.4s ease-in-out;
                    }

                    /* Botón Siguiente Pro */
                    .next-btn {
                        border-radius: 0.7rem;
                        font-weight: bold;

                        transition: all 0.3s ease;

                    }

                    .next-btn.hide {
                        opacity: 0;
                        transform: translateY(-15px);
                        pointer-events: none;
                    }

                    .next-btn:hover {
                        background-color: #1a3e65 !important;
                        transform: scale(1.01);

                    }

                    /* Efecto pulso */
                    .next-btn:hover span {
                        animation: pulse 1s infinite;
                    }

                    @keyframes pulse {
                        0% {
                            text-shadow: 0 0 0px #fff;
                        }

                        50% {
                            text-shadow: 0 0 8px #fff;
                        }

                        100% {
                            text-shadow: 0 0 0px #fff;
                        }
                    }
                </style>

                {{-- Script --}}
                <script>
                    const emailInput = document.getElementById('email');
                    const googleBtn = document.getElementById('google-btn');

                    emailInput.addEventListener('input', () => {
                        if (emailInput.value.trim() !== "") {
                            googleBtn.classList.add('hide');
                        } else {
                            googleBtn.classList.remove('hide');
                        }
                    });
                </script>

            </form>

        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para prevenir espacios
            function evitarEspacios(input) {
                input.addEventListener('keydown', function(e) {
                    if (e.key === ' ') {
                        e.preventDefault();
                    }
                });
            }

            // Lista de IDs a los que se les aplicará la validación
            const sinEspacios = [
                'email',
            ];

            // Aplicamos la función a todos los elementos por ID
            sinEspacios.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    evitarEspacios(input);
                }
            });
        });
    </script>

</body>

</html>
