<?php
require_once "usuario.php";
require_once "repositorio.php";
require_once "../Controladores/conexion.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$mensaje = ""; // Variable para almacenar el mensaje
$clase = "";   // Variable para la clase de estilo del mensaje

if (isset($_SESSION['usuario_id'])) {
    $usuarioID = $_SESSION["usuario_id"];
    $conexion = conexion();

    $repositorio = new Repositorio($conexion);
    $usuario = $repositorio->obtenerUsuarioPorID($usuarioID);

    if (!$usuario) {
        $mensaje = "Usuario no encontrado.";
        $clase = "mensaje-error";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_clave_actual = isset($_POST['usuario_clave']) ? $_POST['usuario_clave'] : null;
        $usuario_clave_nueva = isset($_POST['usuario_clave_nueva']) ? $_POST['usuario_clave_nueva'] : null;
        $usuario_clave_confirmacion = isset($_POST['usuario_clave_confirmacion']) ? $_POST['usuario_clave_confirmacion'] : null;

        if (!empty($usuario_clave_actual) && !empty($usuario_clave_nueva) && !empty($usuario_clave_confirmacion)) {
            // Verifica si la contraseña actual es correcta
            if ($repositorio->verificarClaveActual($usuarioID, $usuario_clave_actual)) {
                // Verifica si la nueva contraseña y su confirmación coinciden
                if ($usuario_clave_nueva === $usuario_clave_confirmacion) {
                    // Hashea la nueva contraseña
                    $hash_clave_nueva = password_hash($usuario_clave_nueva, PASSWORD_DEFAULT);
                    
                    // Llama a la función modificarClave para actualizar la contraseña
                    if ($repositorio->modificarClave($usuarioID, null, null, null, null, $hash_clave_nueva, $usuario_clave_actual)) {
                        $mensaje = "Contraseña actualizada con éxito.";
                        $clase = "mensaje-exito";
                    } else {
                        $mensaje = "Error al actualizar la contraseña.";
                        $clase = "mensaje-error";
                    }
                } else {
                    $mensaje = "Error: La nueva contraseña y la confirmación no coinciden.";
                    $clase = "mensaje-error";
                }
            } else {
                $mensaje = "Error: La contraseña actual es incorrecta.";
                $clase = "mensaje-error";
            }
        } else {
            $mensaje = "Por favor, complete todos los campos.";
            $clase = "mensaje-error";
        }
    }
}

// Cerramos la conexión fuera del bucle condicional
$conexion = null;
?>
