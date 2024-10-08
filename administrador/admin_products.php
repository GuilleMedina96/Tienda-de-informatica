<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos - TechMart</title>
    <link rel="stylesheet" href="../Front\estilos\carrito.css">
    <link rel="stylesheet" href="../Front\estilos\navbarra.css">
</head>

<body>
    <header>
        <?php
        include "navbar_admin.php"
        ?>
    </header>

    <main>
        <h2>Gestión de Productos</h2>
        <p>Aquí puedes agregar, editar o eliminar productos.</p>
        <a href="admin_create_product.php" class="boton">Agregar Nuevo Producto</a>
        <a href="admin_manage_products.php" class="boton">Gestionar Productos</a>
    </main>

    <footer>
        <p>&copy; 2023 TechMart</p>
    </footer>
</body>

</html>