<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="..\Front\estilos\perfil.css">
    <link rel="stylesheet"  href="..\Front\estilos/navbar.css">
    <title>Perfil</title>
</head>
<body>
    <header>
        <?php
        include "navbar.php";
        ?>
    </header>
    <?php
        include_once 'perfil.php';
    ?>

    <h3>Opciones de perfil:</h2>
    <!-- Formulario para editar la contraseña -->
    <form class="form_clave"  method="POST" action="../php/editar_clave.php">
        <input type="submit" name="editar_clave" value="Cambiar contraseña">
    </form>

    <!-- Formulario para eliminar la cuenta (sin función JavaScript de confirmación) -->
    <form class="form_eliminar" method="POST" action="../php/eliminar_perfil.php">
        <input type="submit" name="eliminar_cuenta" value="Eliminar cuenta">
    </form>
</body>
</html>
