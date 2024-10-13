<?php
require_once "../Controladores/conexion.php";
require_once "../php/usuario.php";
require_once "../php/repositorio.php";

// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario_id'])) {
    $usuarioID = $_SESSION['usuario_id'];
    $conexion = conexion(); // Establecer la conexión aquí

    // Crear un objeto Repositorio con la conexión
    $repositorio = new Repositorio($conexion);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['editar_clave'])) {
            // Procesa la edición de la contraseña
            header("Location: editar_perfil.php");
            exit();
        } elseif (isset($_POST['eliminar_cuenta'])) {
            // Procesa la eliminación de la cuenta
            if ($repositorio->eliminarUsuario($usuarioID)) {
                // Puedes redirigir a una página de confirmación o cerrar la sesión aquí
                session_destroy(); // Cierra la sesión
                header("Location: confirmacion_eliminacion.php");
                exit();
            } else {
                echo "<div class='mensaje-error'>Error al eliminar la cuenta.</div>";
            }
        }
    }

    $usuario = $repositorio->obtenerUsuarioPorID($usuarioID);

    if ($usuario) {
        // Mostramos la información del usuario en un formulario
        echo '<h2>Información de Usuario</h2>';
        echo '<form class="perfil_form">'; // Cambiar a perfil_form
        echo '<label for="nombre">Nombre:</label>';
        echo '<input type="text" id="nombre" name="nombre" value="' . htmlspecialchars($usuario->getNombre()) . '" disabled><br>';

        echo '<label for="apellido">Apellido:</label>';
        echo '<input type="text" id="apellido" name="apellido" value="' . htmlspecialchars($usuario->getApellido()) . '" disabled><br>';

        echo '<label for="usuario">Usuario:</label>';
        echo '<input type="text" id="usuario" name="usuario" value="' . htmlspecialchars($usuario->getUsuario()) . '" disabled><br>';

        echo '<label for="email">Email:</label>';
        echo '<input type="email" id="email" name="email" value="' . htmlspecialchars($usuario->getEmail()) . '" disabled><br>';

        echo '</form>';
        // Cierra la conexión después de usarla
        $conexion = null;
    } else {
        echo "<div class='mensaje-error'>Sesión no iniciada. Debes iniciar sesión primero.</div>";
    }
}
