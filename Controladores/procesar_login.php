<?php
require 'conexion.php';
require '../php/usuario.php';
require '../Controladores/verificar_datos.php';

// Obtiene una instancia de PDO usando la función conexion()
$conexion = conexion();

session_start(); // Inicia la sesión al inicio del script

$mensaje_error = ''; // Variable para almacenar mensajes de error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar envío de datos del formulario
    if (isset($_POST['usuario_usuario']) && isset($_POST['usuario_clave'])) {
        // Obtenemos el usuario y la contraseña del formulario
        $usuario = limpiar_cadena($_POST['usuario_usuario']);
        $hash_clave = limpiar_cadena($_POST['usuario_clave']); // Cambio de nombre a $hash_clave

        // Consulta para verificar los datos del usuario
        $sql = "SELECT usuario_id, usuario_clave, is_admin FROM usuario WHERE usuario_usuario = ?";
        $stmt = $conexion->prepare($sql);
        if ($stmt) {
            $stmt->execute([$usuario]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                // Verificar la contraseña
                if (password_verify($hash_clave, $resultado['usuario_clave'])) {
                    // Inicio de sesión exitoso
                    $_SESSION['usuario_id'] = $resultado['usuario_id'];
                    $_SESSION['is_admin'] = $resultado['is_admin']; // Almacena si el usuario es administrador

                    // Redirigir a la página de inicio después de iniciar sesión
                    header("Location: ../Front/index.php");
                    exit(); // Salir para evitar que se siga ejecutando el código
                } else {
                    // Contraseña incorrecta
                    $mensaje_error = "Contraseña incorrecta.";
                }
            } else {
                // El usuario no existe en la base de datos
                $mensaje_error = "El usuario no existe.";
            }
        } else {
            // Error en la preparación de la consulta SQL
            $mensaje_error = "Error en la consulta SQL.";
        }
    } else {
        // Datos de formulario no proporcionados
        $mensaje_error = "Por favor, complete todos los campos.";
    }
}

// Aquí podrías incluir una lógica para mostrar los mensajes de error en la página de inicio de sesión
