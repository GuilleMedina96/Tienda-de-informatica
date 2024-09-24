<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto</title>
    <link rel="stylesheet" href="../Estilos/estilos.css"> <!-- Asegúrate de que esta ruta sea correcta -->
</head>

<body>
    <h2>Agregar Nuevo Producto</h2>
    <form action="procesar_crear_producto.php" method="POST">
        <label for="nombre_producto">Nombre:</label>
        <input type="text" name="nombre_producto" required>

        <label for="precio_producto">Precio:</label>
        <input type="number" name="precio_producto" required>

        <label for="categoria_producto">Categoría:</label>
        <input type="text" name="categoria_producto" required>

        <button type="submit">Agregar Producto</button>
    </form>
</body>

</html>