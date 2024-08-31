<?php
require_once 'usuario.php';
require_once 'repositorio.php';
require_once '../Controladores/conexion.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Autenticación del usuario
if (!isset($_SESSION['usuario_id'])) {
    header("Location: perfil.php");
    exit();
}

$usuarioID = $_SESSION['usuario_id'];
$conexion = conexion();
$repositorio = new Repositorio($conexion);

$mensaje_exito = "";
$mensaje_error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirmacion']) && $_POST['confirmacion'] === 'eliminar_cuenta') {
        // Verificar si la contraseña actual es correcta antes de eliminar la cuenta
        $usuario_clave_actual = isset($_POST['usuario_clave']) ? $_POST['usuario_clave'] : null;

        if (!empty($usuario_clave_actual)) {
            $clave_actual_valida = $repositorio->verificarClaveActual($usuarioID, $usuario_clave_actual);

            if ($clave_actual_valida) {
                if ($repositorio->eliminarUsuario($usuarioID)) {
                    $mensaje_exito = "Cuenta eliminada con éxito.";
                    // Redirigimos al usuario a la página de inicio
                    session_destroy(); // Cierra la sesión
                    // Incluimos un enlace para volver al índice
                    header("Location: ../Front/index.php");
                    exit();
                } else {
                    $mensaje_error = "Hubo un error al eliminar la cuenta.";
                }
            } else {
                $mensaje_error = "Error: La contraseña actual es incorrecta.";
            }
        } else {
            $mensaje_error = "Por favor, complete la contraseña actual.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Front/estilos/registro.css">
    <title>Eliminar Cuenta</title>
</head>
<body>
    
    <?php if (!empty($mensaje_exito)): ?>
        <p style="color: green;"><?php echo $mensaje_exito; ?></p>
        <a href="../Front/index.php">Volver al índice</a>
    <?php elseif (!empty($mensaje_error)): ?>
        <p style="color: red;"><?php echo $mensaje_error; ?></p>
    <?php else: ?>
        <form method="POST" onsubmit="return confirmarEliminacion();">
                            <h2>Eliminar Cuenta</h2>
              <p>¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.</p>
              <label for="usuario_clave">Contraseña actual:</label>
               <input type="password" name="usuario_clave" required>
               <input type="hidden" name="confirmacion" value="eliminar_cuenta">
               <input type="submit" class="boton boton-eliminar" value="Eliminar cuenta">
        </form>
    <form action="../Front/mostrar_perfil.php" method="GET">
    <button type="submit" class="boton boton-volver">Volver atrás</button>
    </form>

    <?php endif; ?>

    <script>
        function confirmarEliminacion() {
            if (confirm("¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.")) {
                // Enviar el formulario
                return true;
            } else {
                return false; // No envía el formulario si el usuario cancela
            }
        }
    </script>
</body>
</html>
