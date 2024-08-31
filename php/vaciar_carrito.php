<?php

session_start();

// Vaciar la variable de sesión "carrito"
unset($_SESSION['carrito']);

// Redirigimos a la pagina del carrito
header("Location: ../Front/carrito.php");


exit();
