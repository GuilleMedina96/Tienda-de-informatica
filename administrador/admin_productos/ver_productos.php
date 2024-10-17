<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

// Conectar a la base de datos
$conn = conexion();

// Verificar si la conexión es exitosa
if (!$conn) {
    die("Error al conectar a la base de datos");
}

// Verificar si hay un término de búsqueda
$searchTerm = '';
$query = "SELECT * FROM producto";
$params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
    // Usar parámetros seguros para la búsqueda
    $query .= " WHERE producto_nombre LIKE :search OR producto_codigo LIKE :search";
    $params[':search'] = '%' . $searchTerm . '%';
}

$stmt = $conn->prepare($query);

// Ejecutar la consulta con parámetros
$stmt->execute($params);
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
    <link rel="stylesheet" href="./estilos_admin/admin_buscar_productos.css">
    <script>
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de que deseas eliminar este producto?');
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>Lista de Productos</h2>

        <!-- Barra de búsqueda -->
        <form id="search-form" class="search-form" method="GET" action="./admin_buscar_productos.php">
            <input type="text" id="search-input" name="query" placeholder="Buscar productos..." required>
            <button type="submit">Buscar</button>
        </form>


        <!-- Mostrar mensaje de éxito si existe -->
        <?php if (!empty($_SESSION['mensaje_exito'])): ?>
            <div class="mensaje-exito">
                <?php echo htmlspecialchars($_SESSION['mensaje_exito']); ?>
                <?php unset($_SESSION['mensaje_exito']); ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de productos -->
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
                <?php if (count($productos) > 0): ?>
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
                                <a class="btn-modificar" href="admin_productos/modificar_producto.php?producto_id=<?php echo htmlspecialchars($producto['producto_id']); ?>">Modificar</a><br><br>
                                <a class="btn-eliminar" href="admin_productos/eliminar_producto.php?producto_id=<?php echo htmlspecialchars($producto['producto_id']); ?>" onclick="return confirmarEliminacion();">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No se encontraron productos que coincidan con la búsqueda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>