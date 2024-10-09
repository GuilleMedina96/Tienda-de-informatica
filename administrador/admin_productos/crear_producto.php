<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Asegúrate de que esto sea lo primero
} // Asegúrate de que esto sea la primera línea

// Incluir la función de conexión y el repositorio
require_once '../Controladores/conexion.php';
require_once '../php/Repositorio.php';

// Crear una nueva conexión
$conexion = conexion(); // Llamar a tu función de conexión
$repositorio = new Repositorio($conexion);

// Manejar la solicitud de agregar un nuevo producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario con verificaciones
    $codigo = isset($_POST['producto_codigo']) ? $_POST['producto_codigo'] : null;
    $nombre = isset($_POST['producto_nombre']) ? $_POST['producto_nombre'] : null;
    $precio = isset($_POST['producto_precio']) ? $_POST['producto_precio'] : null;
    $stock = isset($_POST['producto_stock']) ? $_POST['producto_stock'] : null;
    $foto = isset($_FILES['producto_foto']['name']) ? $_FILES['producto_foto']['name'] : null;
    $categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : null;

    // Verificar que se hayan recibido todos los datos necesarios
    if ($codigo && $nombre && $precio && $stock && $foto && $categoria_id) {
        // Definir la carpeta de destino para las fotos
        $target_dir = "uploads/"; // Asegúrate de que esta carpeta exista y tenga permisos de escritura
        $target_file = $target_dir . basename($foto);

        try {
            // Mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($_FILES['producto_foto']['tmp_name'], $target_file)) {
                // Intentar agregar el producto
                $resultado = $repositorio->agregarProducto($codigo, $nombre, $precio, $stock, $target_file, $categoria_id);

                if ($resultado) {
                    $_SESSION['mensaje_exito'] = "Producto agregado exitosamente.";
                } else {
                    $_SESSION['mensaje_error'] = "No se pudo agregar el producto.";
                }
            } else {
                $_SESSION['mensaje_error'] = "Error al subir la imagen.";
            }
        } catch (Exception $e) {
            $_SESSION['mensaje_error'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['mensaje_error'] = "Por favor, completa todos los campos del formulario.";
    }
}
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

        <form action="" method="POST" onsubmit="return confirmarCreacion();" enctype="multipart/form-data">
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