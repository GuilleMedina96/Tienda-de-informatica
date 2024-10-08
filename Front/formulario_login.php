<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="./estilos/navbarra.css">
    <link rel="stylesheet" href="estilos/loggin.css">
</head>

<body>
    <header>
        <?php
        include "navbar.php";
        ?>
    </header>
    <main>
        <form action="" method="POST"> <!-- action vacío para que se redirija a la misma página y procesemos el login -->
            <h1>Iniciar Sesión</h1>
            <label for="usuario_usuario">Usuario:</label>
            <input type="text" name="usuario_usuario" placeholder="Nombre de usuario" required><br><br>

            <label for="usuario_clave">Contraseña:</label>
            <input type="password" name="usuario_clave" placeholder="Contraseña" required><br><br>
            <button type="submit">Iniciar Sesión</button>

            <?php
            // Incluimos el archivDo que procesa el inicio de sesión
            include '../Controladores/procesar_login.php';

            if (isset($mensaje_error)) {
                echo '<p style="color: red;">' . $mensaje_error . '</p>';
            }
            ?>

            <button type="submit"><a href="registro.php" class="button">Registrarse</a></button>

            <button type="submit"><a href="index.php" class="button">Volver al inicio</a></button
                </form>
    </main>
</body>

</html>