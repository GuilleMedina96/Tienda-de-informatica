<?php
require_once 'clase_carrito.php';

// Crear una instancia del carrito
$carrito = isset($_SESSION['carrito']) ? unserialize($_SESSION['carrito']) : new Carrito();
$productosEnCarrito = $carrito->obtenerProductos();
$total = $carrito->calcularTotal();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Finalizar Pago</title>
</head>

<body>
    <h1>Finalizar Pago</h1>

    <?php if (empty($productosEnCarrito)): ?>
        <p>El carrito está vacío. No se puede realizar el pago.</p>
    <?php else: ?>
        <h2>Productos en el carrito</h2>
        <ul>
            <?php foreach ($productosEnCarrito as $productoData): ?>
                <li>
                    <?php echo $productoData['producto']->getProductoNombre(); ?>
                    - Cantidad: <?php echo $productoData['cantidad']; ?>
                    - Precio: <?php echo $productoData['producto']->getProductoPrecio(); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <h3>Total: <?php echo $total; ?> </h3>

        <form action="procesar_pago.php" method="POST">
            <label for="metodo_pago">Método de Pago:</label>
            <select name="metodo_pago" id="metodo_pago" required>
                <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                <option value="PayPal">PayPal</option>
                <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                <!-- Agregar más métodos de pago si es necesario -->
            </select>
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <input type="submit" value="Finalizar Compra">
        </form>
    <?php endif; ?>
</body>

</html>