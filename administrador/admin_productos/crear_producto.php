<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

// Verifica si se está enviando el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inicializar variables y validar entrada
    $producto_codigo = isset($_POST['producto_codigo']) ? $_POST['producto_codigo'] : null;
    $producto_nombre = isset($_POST['producto_nombre']) ? $_POST['producto_nombre'] : null;
    $producto_precio = isset($_POST['producto_precio']) ? $_POST['producto_precio'] : null;
    $producto_stock = isset($_POST['producto_stock']) ? $_POST['producto_stock'] : null;
    $producto_foto = isset($_FILES['producto_foto']['name']) ? $_FILES['producto_foto']['name'] : null;
    $categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : null;

    // Verifica que todos los campos necesarios estén presentes
    if ($producto_codigo && $producto_nombre && $producto_precio && $producto_stock && $producto_foto && $categoria_id) {
        // Mover la foto a la carpeta deseada
        $ruta_foto = '../uploads/' . basename($producto_foto);

        if (move_uploaded_file($_FILES['producto_foto']['tmp_name'], $ruta_foto)) {
            try {
                $conn = conexion();
                $stmt = $conn->prepare("INSERT INTO productos (producto_codigo, producto_nombre, producto_precio, producto_stock, producto_foto, categoria_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$producto_codigo, $producto_nombre, $producto_precio, $producto_stock, $producto_foto, $categoria_id]);

                echo "<p class='mensaje-exito'>Producto creado exitosamente.</p>";
            } catch (PDOException $e) {
                echo "<p class='mensaje-error'>Error al crear el producto: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            echo "<p class='mensaje-error'>Error al subir la foto. Asegúrate de que el archivo sea un formato válido y no exceda el tamaño permitido.</p>";
        }
    } else {
        echo "<p class='mensaje-error'>Por favor, completa todos los campos requeridos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="..\Front\estilos\agregar_producto.css">
</head>

<body>
    <div class="container">
        <h2>Agregar Nuevo Producto</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="producto_codigo">Código del Producto</label>
            <input type="text" id="producto_codigo" name="producto_codigo" required>

            <label for="producto_nombre">Nombre del Producto</label>
            <input type="text" id="producto_nombre" name="producto_nombre" required>

            <label for="producto_precio">Precio del Producto</label>
            <input type="number" id="producto_precio" name="producto_precio" step="0.01" required>

            <label for="producto_stock">Stock del Producto</label>
            <input type="number" id="producto_stock" name="producto_stock" required>

            <label for="producto_foto">Foto del Producto</label>
            <input type="file" id="producto_foto" name="producto_foto" required>

            <label for="categoria_id">Categoría del Producto</label>
            <select id="categoria_id" name="categoria_id" required>
                <option value="1">Discos</option>
                <option value="2">Fuentes</option>
                <option value="3">Gabinetes</option>
                <option value="4">Mothers</option>
                <option value="5">Placas de video</option>
                <option value="6">Procesadores</option>
                <option value="7">Ram</option>
            </select>

            <button type="submit">Agregar Producto</button>
        </form>
    </div>
</body>

</html>