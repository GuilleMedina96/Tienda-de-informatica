<footer>
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

        .footer-credits {
            display: flex;
            /* Cambiado a flex para alinear mejor */
            align-items: center;
            /* Alinea verticalmente */
            margin-left: 20px;
            /* Espacio a la izquierda de los créditos */
        }

        .footer-credits img.social-icon {
            width: 100px;
            /* Tamaño para la imagen de bang.png */
            height: 50px;
            /* Asegúrate de que la imagen sea cuadrada o mantenga proporción */
            margin-left: 10px;
            /* Espacio a la izquierda de la imagen */
        }

        .footer-credits p {
            margin: 0;
            /* Elimina el margen del párrafo */
            font-size: 14px;
            /* Tamaño de fuente para el texto */
            display: flex;
            /* Cambiado a flex para alinear imagen y texto */
            align-items: center;
            /* Alinea verticalmente el texto y la imagen */
        }

        .footer-credits strong {
            color: #1100ff;
            /* Color del texto de créditos */
        }
    </style>

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