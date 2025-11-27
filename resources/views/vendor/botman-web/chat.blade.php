<!doctype html>
<html>
<head>
    <title>Asistente Eduka - Chat</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget/build/assets/css/chat.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #071242 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #botmanWidgetRoot {
            width: 100%;
            max-width: 500px;
            height: 600px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            border-radius: 20px;
            overflow: hidden;
        }

        /* Personalización del widget */
        .desktop-closed-message-avatar {
            background-color: #28AECE !important;
        }

        /* Mejoras visuales */
        @media (max-width: 768px) {
            #botmanWidgetRoot {
                max-width: 100%;
                height: 100vh;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
<div id="botmanWidgetRoot"></div>

<script id="botmanWidget" src='https://cdn.jsdelivr.net/npm/botman-web-widget/build/js/chat.js'></script>
<script>
    // Configuración inicial del chat
    var botmanWidget = {
        frameEndpoint: '/botman',
        chatServer: '/botman',
        title: '🤖 Asistente Eduka',
        introMessage: 'Cargando...',
        placeholderText: 'Escribe tu mensaje aquí...',
        mainColor: '#28AECE',
        bubbleBackground: '#f8f9fa',
        headerTextColor: '#ffffff',
        bubbleAvatarUrl: '',
        displayMessageTime: true,
        desktopHeight: 600,
        desktopWidth: 500,
        mobileHeight: '100%',
        mobileWidth: '100%'
    };

    // Auto-enviar mensaje de inicio después de cargar
    setTimeout(function() {
        try {
            // Intentar diferentes selectores para encontrar el input
            var input = document.querySelector('.botmanChatWindow input[type="text"]') ||
                       document.querySelector('input.botmanChatWindow__input') ||
                       document.querySelector('input');

            var button = document.querySelector('.botmanChatWindow button[type="submit"]') ||
                        document.querySelector('button.botmanChatWindow__submit') ||
                        document.querySelector('button');

            if (input && button) {
                input.value = 'start';
                button.click();
                console.log('✅ Mensaje de inicio enviado automáticamente');
            } else {
                console.warn('⚠️ No se encontraron los elementos del chat');
                // Intentar nuevamente después de un delay adicional
                setTimeout(function() {
                    var retryInput = document.querySelector('input');
                    var retryButton = document.querySelector('button');
                    if (retryInput && retryButton) {
                        retryInput.value = 'start';
                        retryButton.click();
                        console.log('✅ Mensaje de inicio enviado (segundo intento)');
                    }
                }, 1000);
            }
        } catch (error) {
            console.error('Error al enviar mensaje automático:', error);
        }
    }, 2000);

    // Mensaje de bienvenida mejorado cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🤖 Asistente Eduka cargado correctamente');
    });
</script>
</body>
</html>
