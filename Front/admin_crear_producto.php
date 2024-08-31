<?php
require_once '../Controladores/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $foto = $_POST['foto'];
    $categoria_id = $_POST['categoria_id'];

    $query = "INSERT INTO producto (producto_codigo, producto_nombre, producto_precio, producto_stock, producto_foto, categoria_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $codigo, PDO::PARAM_STR);
    $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
    $stmt->bindParam(3, $precio, PDO::PARAM_STR);
    $stmt->bindParam(4, $stock, PDO::PARAM_INT);
    $stmt->bindParam(5, $foto, PDO::PARAM_STR);
    $stmt->bindParam(6, $categoria_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "Producto agregado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto - TechMart</title>
    <link rel="stylesheet" href="carrito.css">
</head>

<body>
    <header>
        <h1>Agregar Nuevo Producto</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="admin_gestion_producto.php">Gestionar Productos</a></li>
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="admin_crear_producto.php" method="POST">
            <label for="codigo">Código del Producto:</label>
            <input type="text" id="codigo" name="codigo" required>

            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <label for="foto">Foto URL:</label>
            <input type="text" id="foto" name="foto" required>

            <label for="categoria_id">Categoría:</label>
            <select id="categoria_id" name="categoria_id" required>
                <?php
                $result = $conexion->query("SELECT * FROM categoria");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['categoria_id'] . '">' . $row['categoria_nombre'] . '</option>';
                }
                ?>
            </select>

            <input type="submit" value="Agregar Producto">
        </form>
    </main>

    <footer>
        <p>&copy; 2023 TechMart</p>
    </footer>
</body>

</html>