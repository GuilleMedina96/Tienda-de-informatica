<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

// Conectar a la base de datos
$conn = conexion();

// Verificar si se ha proporcionado un ID de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['producto_id'])) {
        $producto_id = $_POST['producto_id'];

        // Eliminar el producto
        $stmt = $conn->prepare("DELETE FROM productos WHERE producto_id = ?");
        $stmt->execute([$producto_id]);

        $mensaje = "Producto eliminado exitosamente.";
    } else {
        $mensaje = "ID de producto no proporcionado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Eliminar Producto</title>
    <link rel="stylesheet" href="../Front/estilos/carrito.css">
    <link rel="stylesheet" href="../Front/estilos/navbar.css">
</head>

<body>
    <main>
        <h2>Eliminar Producto</h2>

        <?php if (isset($mensaje)): ?>
            <p class="mensaje-exito"><?= $mensaje ?></p>
        <?php endif; ?>

        <form action="" method="POST" onsubmit="return confirmarEliminar()">
            <!-- Selección del Producto para Eliminar -->
            <label for="producto_id">Seleccionar Producto para Eliminar:</label>
            <select id="producto_id" name="producto_id" required>
                <?php
                // Obtener lista de productos para seleccionar
                $productos = $conn->query("SELECT producto_id, producto_nombre FROM productos")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($productos as $producto) {
                    echo "<option value='{$producto['producto_id']}'>{$producto['producto_nombre']}</option>";
                }
                ?>
            </select>

            <button type="submit">Eliminar Producto</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2023 TechMart</p>
    </footer>

    <script>
        function confirmarEliminar() {
            return confirm("¿Estás seguro de que deseas eliminar este producto?");
        }
    </script>

</body>

</html>