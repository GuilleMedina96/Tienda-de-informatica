<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TechMart</title>
    <link rel="stylesheet" href="../Front/estilos/navbarra.css"> <!-- Estilo del navbar -->
    <link rel="stylesheet" href="../Front/estilos/carrito.css"> <!-- Otros estilos -->
    <link rel="stylesheet" href="./estilos_admin/panel_admin.css"> <!-- Estilos del panel de administración -->
</head>

<body>
    <header>
        <?php
        include "navbar_admin.php"
        ?>
    </header>

    <main>
        <h2>Bienvenido, Administrador</h2>
        <p>Desde aquí puedes gestionar los productos, órdenes y reseñas de la tienda.</p>

        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="mensaje-exito">
                <?php echo $_SESSION['mensaje_exito']; ?>
                <?php unset($_SESSION['mensaje_exito']); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
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