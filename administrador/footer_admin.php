<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        /* Estilos generales del body y contenedor */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Permite que el cuerpo ocupe al menos toda la altura de la ventana */
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Estilos del footer */
        footer {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
            width: 100%;
            /* Asegura que el footer se mantenga al fondo */
            margin-top: auto;
            /* Empuja el footer hacia abajo */
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-info p {
            margin: 0;
        }

        .contact-info a {
            color: #ffcc00;
            text-decoration: none;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            /* Centra los íconos en el contenedor */
            gap: 15px;
        }

        .social-icons a {
            display: flex;
            flex-direction: row;
            /* Mantiene texto al lado del ícono */
            align-items: center;
            /* Alinea el texto y el ícono verticalmente */
            color: white;
            /* Cambia el color del texto a blanco */
            text-decoration: none;
            /* Elimina el subrayado del enlace */
        }

        .social-text {
            margin-left: 5px;
            /* Espacio a la izquierda del ícono */
            font-size: 14px;
            /* Ajusta el tamaño de fuente si es necesario */
        }

        .social-icons img.social-icon {
            width: 30px;
            height: 30px;
        }

        .footer-credits p {
            margin: 0;
            font-size: 14px;
        }

        .footer-credits strong {
            color: #1100ff;
            /* Color del texto de créditos */
        }
    </style>
</head>

<body>
    <!-- Contenido de tu panel de administración aquí -->

    <footer>

        <div class="footer-content">
            <div class="contact-info">
                <p>Contacto: <a href="mailto:contacto@techmart.com">contacto@techmart.com</a></p>
            </div>
            <div class="social-icons">
                <a href="https://www.instagram.com" target="_blank">
                    <img src="instagram.png" alt="Instagram" class="social-icon">
                    <span class="social-text">TechMart</span>
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <img src="twitter.png" alt="Twitter" class="social-icon">
                    <span class="social-text">TechMart24</span>
                </a>
            </div>
            <div class="footer-credits">
                <p>Desarrollado por Bang Software
                </p>
            </div>
        </div>
    </footer>
</body>

</html>