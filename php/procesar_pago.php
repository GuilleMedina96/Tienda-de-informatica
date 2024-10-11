<?php
require_once '../Controladores/conexion.php';
require_once 'clase_carrito.php';

// Crear una instancia del carrito
$carrito = isset($_SESSION['carrito']) ? unserialize($_SESSION['carrito']) : new Carrito();

// Finalizar la compra
$carrito->finalizarCompra();

// Procesar el pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodoPago = $_POST['metodo_pago'];
    $idCompra = /* Aquí debes obtener el ID de la compra realizada */ // Debes modificar la lógica para obtener el ID de compra

        $conexion = conexion();
    if ($conexion) {
        $sql = "INSERT INTO pago (id_compra, metodo_pago, estado_pago) VALUES (:id_compra, :metodo_pago, 'Completado')";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_compra', $idCompra, PDO::PARAM_INT);
        $stmt->bindParam(':metodo_pago', $metodoPago, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Pago registrado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al registrar el pago.";
        }
    }

    // Redirigir a la página de confirmación o vaciar carrito
    header("Location: vaciar_carrito.php");
} else {
    $_SESSION['mensaje'] = "No se ha recibido información de pago.";
    header("Location: formulario_pago.php");
}
