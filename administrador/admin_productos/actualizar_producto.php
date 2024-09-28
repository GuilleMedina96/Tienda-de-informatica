<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

// Conectar a la base de datos
$conn = conexion();

// Verificar si se han enviado los datos del producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = $_POST['producto_id'];
    $producto_codigo = $_POST['producto_codigo'];
    $producto_nombre = $_POST['producto_nombre'];
    $producto_precio = $_POST['producto_precio'];
    $producto_stock = $_POST['producto_stock'];
    $producto_foto = $_POST['producto_foto']; // Asegúrate de que esto esté definido

    // Actualizar el producto en la base de datos
    $stmt = $conn->prepare("UPDATE producto SET producto_codigo = ?, producto_nombre = ?, producto_precio = ?, producto_stock = ?, producto_foto = ? WHERE producto_id = ?");
    $stmt->execute([$producto_codigo, $producto_nombre, $producto_precio, $producto_stock, $producto_foto, $producto_id]);

    // Redirigir a la lista de productos después de la actualización
    header("Location: ver_productos.php");
    exit();
} else {
    // Manejo de error si no se enviaron datos
    echo "Error: No se recibieron datos.";
}
