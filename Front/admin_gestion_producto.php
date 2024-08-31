<?php
require_once '../Controladores/conexion.php';

if (isset($_GET['delete'])) {
    $producto_id = $_GET['delete'];
    $query = "DELETE FROM producto WHERE producto_id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $producto_id, PDO::PARAM_INT);
    $stmt->execute();
    echo "Producto eliminado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos - TechMart</title>
    <link rel="stylesheet" href="carrito.css">
</head>

<body>
    <header>
        <h1>Gestionar Productos</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="admin_crear_producto.php">Agregar Nuevo Producto</a></li>
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conexion->query("SELECT producto.*, categoria.categoria_nombre FROM producto JOIN categoria ON producto.categoria_id = categoria.categoria_id");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['producto_id'] . '</td>';
                    echo '<td>' . $row['producto_codigo'] . '</td>';
                    echo '<td>' . $row['producto_nombre'] . '</td>';
                    echo '<td>$' . $row['producto_precio'] . '</td>';
                    echo '<td>' . $row['producto_stock'] . '</td>';
                    echo '<td>' . $row['categoria_nombre'] . '</td>';
                    echo '<td>
                            <a href="admin_edit_product.php?id=' . $row['producto_id'] . '">Editar</a>
                            <a href="admin_gestion_producto.php?delete=' . $row['producto_id'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este producto?\')">Eliminar</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2023 TechMart</p>
    </footer>
</body>

</html>