<?php
session_start(); // Iniciar la sesión

// Verificamos si hay mensajes en la sesión y los mostramos
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="./estilos_admin/agregar_producto.css">
    <script>
        function confirmarCreacion() {
            return confirm("¿Estás seguro de que deseas crear este producto?");
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>Agregar Nuevo Producto</h2>

        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <div class="error"><?php echo $_SESSION['mensaje_error'];
                                unset($_SESSION['mensaje_error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="success"><?php echo $_SESSION['mensaje_exito'];
                                    unset($_SESSION['mensaje_exito']); ?></div>
        <?php endif; ?>

        <form action="crear_producto.php" method="POST" onsubmit="return confirmarCreacion();" enctype="multipart/form-data">
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