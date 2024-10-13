<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TechMart</title>
    <link rel="stylesheet" href="../Front/estilos/navbarra.css"> <!-- Estilo del navbar -->
    <link rel="stylesheet" href="../Front/estilos/carrito.css"> <!-- Otros estilos -->
    <link rel="stylesheet" href="./estilos_admin/panel_administrador.css"> <!-- Estilos del panel de administración -->
</head>

<body>
    <header>
        <?php include "navbar_admin.php"; ?>
    </header>

    <main>
        <h2>Bienvenido, Administrador</h2>
        <p>Desde aquí puedes gestionar los productos, órdenes y reseñas de la tienda.</p>

        <form action="" method="POST">
            <div class="botones-administracion">
                <button type="submit" name="accion" value="crear_producto" class="boton">Nuevo Producto</button>
                <button type="submit" name="accion" value="ver_productos" class="boton">Ver Todos los Productos</button>
            </div>
        </form>

        <?php
        // Procesar las acciones según el botón presionado
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
            switch ($_POST['accion']) {
                case 'crear_producto':
                    header('Location: admin_productos/insertar_producto.php');
                    exit(); // Asegúrate de usar exit después de header
                case 'ver_productos':
                    include('admin_productos/ver_productos.php');
                    exit();
            }
        }
        ?>

    </main>

    <?php include 'footer_admin.php'; ?>


</body>

</html>