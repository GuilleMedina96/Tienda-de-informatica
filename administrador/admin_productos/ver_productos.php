<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

// Conectar a la base de datos
$conn = conexion();

// Obtener todos los productos
$stmt = $conn->prepare("SELECT * FROM productos"); // Cambié "producto" a "productos" para que coincida con el nombre correcto de la tabla
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Productos</title>
    <link rel="stylesheet" href="../Front/estilos/ver_productos.css">
</head>

<body>
    <div class="container">
        <h2>Lista de Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['producto_id']); ?></td>
                        <td><?php echo htmlspecialchars($producto['producto_codigo']); ?></td>
                        <td><?php echo htmlspecialchars($producto['producto_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['producto_precio']); ?></td>
                        <td><?php echo htmlspecialchars($producto['producto_stock']); ?></td>
                        <td>
                            <img src="../uploads/<?php echo htmlspecialchars($producto['producto_foto']); ?>" alt="Foto" width="100">
                        </td>
                        <td>
                            <a class="btn-modificar" href="modificar_producto.php?producto_id=<?php echo $producto['producto_id']; ?>">Modificar</a>
                            <a class="btn-eliminar" href="eliminar_producto.php?producto_id=<?php echo $producto['producto_id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>