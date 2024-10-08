<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TechMart</title>
    <link rel="stylesheet" href="../Front/estilos/carrito.css">
    <link rel="stylesheet" href="../Front/estilos/navbarra.css">
    <style>
        /* Estilo para los botones de administración */
        .botones-administracion {
            display: flex;
            flex-direction: column;
            gap: 10px;
            /* Espaciado entre botones */
            margin-top: 20px;
            /* Espaciado superior */
        }

        .boton {
            padding: 10px 20px;
            background-color: #4CAF50;
            /* Color de fondo */
            color: white;
            /* Color del texto */
            text-decoration: none;
            /* Sin subrayado */
            border-radius: 5px;
            /* Bordes redondeados */
            text-align: center;
            /* Centrar texto */
        }

        .boton:hover {
            background-color: #45a049;
            /* Color al pasar el mouse */
        }

        .mensaje-exito {
            background-color: #d4edda;
            /* Color de fondo para el mensaje de éxito */
            color: #155724;
            /* Color del texto */
            border: 1px solid #c3e6cb;
            /* Borde del mensaje */
            padding: 10px;
            /* Espaciado interno */
            margin-bottom: 20px;
            /* Espaciado inferior */
            border-radius: 5px;
            /* Bordes redondeados */
        }
    </style>
</head>

<body>
    <header>
        <h1>Panel de Administración - TechMart</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="admin_orders.php">Órdenes</a></li>
                <li><a href="admin_reviews.php">Reseñas</a></li>
                <li><a href="../Front/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Bienvenido, Administrador</h2>
        <p>Desde aquí puedes gestionar los productos, órdenes y reseñas de la tienda.</p>

        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="mensaje-exito">
                <?php echo $_SESSION['mensaje_exito']; ?>
                <?php unset($_SESSION['mensaje_exito']); // Limpiar el mensaje después de mostrarlo 
                ?>
            </div>
        <?php endif; ?>

        <form action="admin_dashboard.php" method="POST">
            <div class="botones-administracion">
                <button type="submit" name="accion" value="crear_producto" class="boton">Agregar Nuevo Producto</button>
                <button type="submit" name="accion" value="ver_productos" class="boton">Ver Todos los Productos</button>
            </div>
        </form>

        <?php
        // Procesar las acciones según el botón presionado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch ($_POST['accion']) {
                case 'crear_producto':
                    include 'admin_productos/crear_producto.php';
                    break;
                case 'modificar_producto':
                    include 'admin_productos/modificar_producto.php';
                    break;
                case 'eliminar_producto':
                    include 'admin_productos/eliminar_producto.php';
                    break;
                case 'ver_productos':
                    include 'admin_productos/ver_productos.php';
                    break;
                default:
                    break;
            }
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2024 TechMart</p>
    </footer>
</body>

</html>