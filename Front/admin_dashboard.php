<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TechMart</title>
    <link rel="stylesheet" href=".\estilos\carrito.css">
    <link rel="stylesheet" href=".\estilos\navbar.css">
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
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Bienvenido, Administrador</h2>
        <p>Desde aquí puedes gestionar los productos, órdenes y reseñas de la tienda.</p>
        <a href="admin_crear_producto.php" class="boton">Agregar Nuevo Producto</a>
        <a href="admin_gestion_producto.php" class="boton">Gestionar Productos</a>
        <a href="admin_gestionar_ordenes.php" class="boton">Gestionar Órdenes</a>
        <a href="admin_gestionar_reseñas.php" class="boton">Gestionar Reseñas</a>
    </main>

    <footer>
        <p>&copy; 2023 TechMart</p>
    </footer>
</body>

</html>