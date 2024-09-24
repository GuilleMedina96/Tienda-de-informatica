<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';

// Conectar a la base de datos
$conn = conexion();

// Verificar si se ha proporcionado un ID de producto
if (isset($_GET['producto_id'])) {
    $producto_id = $_GET['producto_id'];

    // Eliminar el producto
    $stmt = $conn->prepare("DELETE FROM productos WHERE producto_id = ?");
    $stmt->execute([$producto_id]);

    echo "Producto eliminado exitosamente.";
} else {
    die("ID de producto no proporcionado.");
}

// Redirigir a la página de ver productos después de eliminar
header("Location: ver_productos.php");
exit();
