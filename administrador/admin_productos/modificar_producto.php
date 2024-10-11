<?php
session_start(); // Iniciar sesión

require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

// Conectar a la base de datos
$conn = conexion();

// Verificar si se ha enviado el ID del producto
if (isset($_GET['producto_id'])) {
    $producto_id = $_GET['producto_id'];

    // Obtener los detalles del producto a modificar
    $stmt = $conn->prepare("SELECT * FROM producto WHERE producto_id = ?");
    $stmt->execute([$producto_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo "Producto no encontrado.";
        exit();
    }
} else {
    echo "Error: No se ha proporcionado el ID del producto.";
    exit();
}

// Inicializar variable para mensaje de éxito
$mensaje_exito = "";

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_codigo = $_POST['producto_codigo'];
    $producto_nombre = $_POST['producto_nombre'];
    $producto_precio = $_POST['producto_precio'];
    $producto_stock = $_POST['producto_stock'];
    $producto_foto = $_POST['producto_foto']; // Nuevo campo para foto

    // Actualizar el producto en la base de datos
    $stmt = $conn->prepare("UPDATE producto SET producto_codigo = ?, producto_nombre = ?, producto_precio = ?, producto_stock = ?, producto_foto = ? WHERE producto_id = ?");
    $stmt->execute([$producto_codigo, $producto_nombre, $producto_precio, $producto_stock, $producto_foto, $producto_id]);

    // Establecer un mensaje de éxito
    $mensaje_exito = "Producto actualizado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="../Front/estilos/ver_productos.css"> |
    <link rel="stylesheet" href="..\estilos_admin\modificar_producto.css">
    <!-- Ajusta la ruta si es necesario -->
    <script>
        function confirmarActualizacion() {
            return confirm("¿Estás seguro de que deseas actualizar este producto?");
        }
    </script>

</head>

<body>
    <div class="container">
        <h2>Modificar Producto</h2>
        <?php if ($mensaje_exito): ?>
            <div class="mensaje-exito">
                <?php echo htmlspecialchars($mensaje_exito); ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST" onsubmit="return confirmarActualizacion();">
            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['producto_id']); ?>">
            <div class="form-group">
                <label for="producto_codigo">Código:</label>
                <input type="text" id="producto_codigo" name="producto_codigo" value="<?php echo htmlspecialchars($producto['producto_codigo']); ?>" required>
            </div>

            <div class="form-group">
                <label for="producto_nombre">Nombre:</label>
                <input type="text" id="producto_nombre" name="producto_nombre" value="<?php echo htmlspecialchars($producto['producto_nombre']); ?>" required>
            </div>

            <div class="form-group">
                <label for="producto_precio">Precio:</label>
                <input type="number" id="producto_precio" name="producto_precio" value="<?php echo htmlspecialchars($producto['producto_precio']); ?>" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="producto_stock">Stock:</label>
                <input type="number" id="producto_stock" name="producto_stock" value="<?php echo htmlspecialchars($producto['producto_stock']); ?>" required>
            </div>

            <div class="form-group">
                <label for="producto_foto">Foto:</label>
                <input type="text" id="producto_foto" name="producto_foto" value="<?php echo htmlspecialchars($producto['producto_foto']); ?>" required>
            </div>

            <button type="submit">Actualizar Producto</button>
        </form>
        <div class="boton-volver">
            <a href="../admin_dashboard.php">
                <button>Volver al Panel de Administración</button>
            </a>
        </div>
    </div>
</body>

</html>