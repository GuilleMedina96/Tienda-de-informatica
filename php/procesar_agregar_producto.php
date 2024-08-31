<?php
require 'conexion.php';

// Verificar si se enviaron datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['producto_nombre'], $_POST['producto_categoria'], $_POST['producto_precio'], $_POST['producto_descripcion'])) {
        $nombre = $_POST['producto_nombre'];
        $categoria = $_POST['producto_categoria'];
        $precio = $_POST['producto_precio'];
        $descripcion = $_POST['producto_descripcion'];

        // Manejo de la imagen (esto es solo un ejemplo, ajusta según tu necesidad)
        if (isset($_FILES['producto_imagen']) && $_FILES['producto_imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen_nombre = $_FILES['producto_imagen']['name'];
            $imagen_tmp = $_FILES['producto_imagen']['tmp_name'];
            move_uploaded_file($imagen_tmp, "path/to/uploads/$imagen_nombre");
        } else {
            $imagen_nombre = null;
        }

        // Guardar los datos en la base de datos
        $conexion = conexion();
        $sql = "INSERT INTO producto (nombre, categoria, precio, descripcion, imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            $stmt->execute([$nombre, $categoria, $precio, $descripcion, $imagen_nombre]);
            header("Location: admin_products.php"); // Redirigir después de agregar
            exit();
        } else {
            echo "Error al guardar el producto.";
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
} else {
    echo "Método de solicitud no permitido.";
}
