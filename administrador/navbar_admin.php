<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Front/estilos/navbarra.css"> <!-- Asegúrate de apuntar al archivo CSS correcto -->
    <title>Panel de Administración - TechMart</title>
    <style>
        /* CSS para posicionar la imagen en la esquina superior izquierda */
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 180px;
            height: 130px;
            z-index: 1000;
            /* Para asegurarnos de que esté por encima de otros elementos */
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <header>
        <h1>Panel de Administración - TechMart</h1>
        <nav>


            <!-- Enlace con la imagen del logo -->
            <a href="../Front/index.php" class="logo">
                <img src="../Front/logo2.png" alt="Volver al Inicio">
            </a>

            <ul>
                <li><a href="../Front/index.php">Inicio</a></li>
                <li><a href="admin_dashboard.php">Productos</a></li>
                <li><a href="admin_gestionar_ordenes.php">Órdenes</a></li>
                <li><a href="admin_gestionar_reseñas.php">Reseñas</a></li>

                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <li><a href="cerrar_sesion.php" onclick="confirmarCierreSesion(event)">Cerrar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <script>
        function confirmarCierreSesion(event) {
            event.preventDefault(); // Prevenir la acción por defecto del enlace
            let confirmar = confirm("¿Desea cerrar sesión?");
            if (confirmar) {
                // Redirigir a la página de cierre de sesión
                window.location.href = "../Front/cerrar_sesion.php";
            }
        }

        // Obtener la URL actual
        const currentPage = window.location.href;

        // Obtener todos los enlaces de la barra de navegación
        const navLinks = document.querySelectorAll('nav a');

        // Deshabilitar el enlace correspondiente a la página actual
        navLinks.forEach(link => {
            if (link.href === currentPage) {
                link.style.pointerEvents = 'none'; // Deshabilitar el enlace
                link.style.color = 'gray'; // Cambiar color del enlace deshabilitado
            }
        });
    </script>
</body>

</html>