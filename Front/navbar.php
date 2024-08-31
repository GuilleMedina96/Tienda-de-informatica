<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMart - Tienda de Informática</title>
    <link rel="stylesheet" href="path/to/estilos.css"> <!-- Asegúrate de que esta ruta sea correcta -->
</head>

<body>
    <header>
        <h1>TechMart - Tienda de Informática</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="categorias.php">Productos</a></li>
                <li><a href="carrito.php">Carrito de Compras</a></li>
                <?php
                // Iniciar sesión si no está ya iniciada
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                // Verificar si el usuario está autenticado
                if (isset($_SESSION['usuario_id'])) {
                    // Mostrar enlaces para usuarios autenticados
                    echo '<li><a href="mostrar_perfil.php">Mi perfil</a></li>';
                    echo '<li><a href="cerrar_sesion.php" onclick="confirmarCierreSesion(event)">Cerrar Sesión</a></li>';

                    // Verificar si el usuario es administrador y mostrar enlaces de administración
                    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                        echo '<li><a href="admin_dashboard.php">Panel de Administración</a></li>';
                    }
                } else {
                    // Mostrar enlaces para usuarios no autenticados
                    echo '<li><a href="registro.php">Registro</a></li>';
                    echo '<li><a href="formulario_login.php">Iniciar sesión</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <script>
        function confirmarCierreSesion(event) {
            event.preventDefault(); // Prevenir la acción por defecto del enlace
            let confirmar = confirm("¿Desea cerrar sesión?");
            if (confirmar) {
                window.location.href = "cerrar_sesion.php";
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