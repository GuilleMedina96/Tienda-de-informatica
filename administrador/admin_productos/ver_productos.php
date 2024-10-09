<?php

require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

// Conectar a la base de datos
$conn = conexion();

// Obtener todos los productos
$stmt = $conn->prepare("SELECT * FROM producto");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Productos</title>
    <link rel="stylesheet" href="./estilos_admin/ver_productos.css">
    <link rel="stylesheet" href="../Front/estilos/carrito.css">
    <link rel="stylesheet" href="../Front/estilos/navbarra.css">
    <script>
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de que deseas eliminar este producto?');
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>Lista de Productos</h2>

        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="mensaje-exito">
                <?php echo $_SESSION['mensaje_exito']; ?>
                <?php unset($_SESSION['mensaje_exito']); // Limpiar el mensaje después de mostrarlo 
                ?>
            </div>
        <?php endif; ?>

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
                            <img src="../Front/<?php echo htmlspecialchars($producto['producto_foto']); ?>" alt="Foto de <?php echo htmlspecialchars($producto['producto_nombre']); ?>" width="100">
                        </td>
                        <td>
                            <a href="admin_productos/modificar_producto.php?producto_id=<?php echo htmlspecialchars($producto['producto_id']); ?>">Modificar</a>
                            <a class="btn-eliminar" href="admin_productos/eliminar_producto.php?producto_id=<?php echo htmlspecialchars($producto['producto_id']); ?>" onclick="return confirmarEliminacion();">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>