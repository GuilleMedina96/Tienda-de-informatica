<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $producto_codigo = $_POST['producto_codigo'];
    $producto_nombre = $_POST['producto_nombre'];
    $producto_precio = $_POST['producto_precio'];
    $producto_stock = $_POST['producto_stock'];
    $producto_foto = $_FILES['producto_foto']['name']; // Manejo del archivo subido
    $categoria_id = $_POST['categoria_id']; // Suponiendo que el formulario incluye un campo para esto

    // Guardar la imagen en el servidor (opcional)
    move_uploaded_file($_FILES['producto_foto']['tmp_name'], '../uploads/' . $producto_foto);

    // Conectar a la base de datos
    $conn = conexion();

    // Insertar producto
    $stmt = $conn->prepare("INSERT INTO productos (producto_codigo, producto_nombre, producto_precio, producto_stock, producto_foto, categoria_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$producto_codigo, $producto_nombre, $producto_precio, $producto_stock, $producto_foto, $categoria_id]);

    echo "Producto creado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>

<body>
    <h2>Agregar Nuevo Producto</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="producto_codigo">Código:</label>
        <input type="text" name="producto_codigo" required>
        <br>
        <label for="producto_nombre">Nombre:</label>
        <input type="text" name="producto_nombre" required>
        <br>
        <label for="producto_precio">Precio:</label>
        <input type="number" name="producto_precio" step="0.01" required>
        <br>
        <label for="producto_stock">Stock:</label>
        <input type="number" name="producto_stock" required>
        <br>
        <label for="producto_foto">Foto:</label>
        <input type="file" name="producto_foto" accept="image/*" required>
        <br>
        <label for="categoria_id">Categoría ID:</label>
        <input type="number" name="categoria_id" required>
        <br>
        <input type="submit" value="Agregar Producto">
    </form>
</body>

</html>