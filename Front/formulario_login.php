<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="Estilos/login.css">
</head>

<body>

    <form action="" method="POST"> <!-- action vacío para que se redirija a la misma página y procesemos el login -->
        <h1>Iniciar Sesión</h1>
        <label for="usuario_usuario">Usuario:</label>
        <input type="text" name="usuario_usuario" placeholder="Nombre de usuario" required><br><br>

        <label for="usuario_clave">Contraseña:</label>
        <input type="password" name="usuario_clave" placeholder="Contraseña" required><br><br>
        <button type="submit">Iniciar Sesión</button>
        <a href="../php/registro.php">Regístrate aquí</a><br><br>
        <a href="../Front/index.php" class="button">Volver al inicio</a> <!-- Enlace para volver al inicio -->

        <?php
        // Incluimos el archivo que procesa el inicio de sesión
        include '../Controladores/procesar_login.php';

        if (isset($mensaje_error)) {
            echo '<p style="color: red;">' . $mensaje_error . '</p>';
        }
        ?>

    </form>
</body>

</html>