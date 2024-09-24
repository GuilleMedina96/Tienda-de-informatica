<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TechMart</title>
    <link rel="stylesheet" href="../Front\estilos\carrito.css">
    <link rel="stylesheet" href="../Front\estilos\navbar.css">
</head>

<body>
    <header>
        <h1>Panel de Administración - TechMart</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="admin_products.php">Productos</a></li>
                <li><a href="admin_orders.php">Órdenes</a></li>
                <li><a href="admin_reviews.php">Reseñas</a></li>
                <li><a href="../Front/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Bienvenido, Administrador</h2>
        <p>Desde aquí puedes gestionar los productos, órdenes y reseñas de la tienda.</p>

        <div class="botones-administracion">
            <a href="admin_productos/crear_producto.php" class="boton">Agregar Nuevo Producto</a>
            <a href="admin_productos/modificar_producto.php" class="boton">Modificar Producto</a>
            <a href="admin_productos/eliminar_producto.php" class="boton">Eliminar Producto</a>
            <a href="admin_productos/ver_productos.php" class="boton">Ver Todos los Productos</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 TechMart</p>
    </footer>
</body>

</html>