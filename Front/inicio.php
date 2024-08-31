<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: formulario_login.php");
    exit();
}

// Verificar si el usuario es administrador
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    // Mostrar contenido para administradores
    echo "¡Bienvenido, administrador! Contenido protegido para administradores aquí.";
} else {
    // Mostrar contenido para usuarios normales
    echo "¡Bienvenido, usuario! Contenido protegido para usuarios aquí.";
}
