<?php
require_once 'clase_carrito.php';

// Crear una instancia del carrito
$carrito = isset($_SESSION['carrito']) ? unserialize($_SESSION['carrito']) : new Carrito();

// Finalizar la compra
$carrito->finalizarCompra();
header("Location: vaciar_carrito.php")
?>