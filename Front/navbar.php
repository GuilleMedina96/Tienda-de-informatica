<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMart - Tienda de Informática</title>
    <link rel="stylesheet" href="./estilos/navbarra.css"> <!-- Asegúrate de que esta ruta sea correcta -->
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
        <!-- Enlace con la imagen del logo que te llevará al inicio -->
        <a href="index.php" class="logo">
            <img src="logo2.png" alt="Volver al Inicio">
        </a>

        <h1>TechMart - Tienda de Informática</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="categorias.php">Productos</a></li>
                <li><a href="carrito.php">Carrito de Compras</a></li>
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                if (isset($_SESSION['usuario_id'])) {
                    echo '<li><a href="mostrar_perfil.php">Mi perfil</a></li>';
                    echo '<li><a href="cerrar_sesion.php" onclick="confirmarCierreSesion(event)">Cerrar Sesión</a></li>';
                    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                        echo '<li><a href="../administrador/admin_dashboard.php">Panel de Administración</a></li>';
                    }
                } else {
                    echo '<li><a href="registro.php">Registro</a></li>';
                    echo '<li><a href="formulario_login.php">Iniciar sesión</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <script>
        function confirmarCierreSesion(event) {
            event.preventDefault();
            let confirmar = confirm("¿Desea cerrar sesión?");
            if (confirmar) {
                window.location.href = "cerrar_sesion.php";
            }
        }

        const currentPage = window.location.href;
        const navLinks = document.querySelectorAll('nav a');

        navLinks.forEach(link => {
            if (link.href === currentPage) {
                link.style.pointerEvents = 'none';
                link.style.color = 'gray';
            }
        });
    </script>
</body>

</html>