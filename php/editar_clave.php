
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Front/estilos/registro.css">
    <title>Editar Contraseña</title>
</head>
<body>


    <form method="post" action="">
            <h2>Editar Contraseña:</h2>
        <label for="password">Ingrese su contraseña actual:</label>
        <input type="password" name="usuario_clave" placeholder="Ingrese su contraseña actual" required>

        <label for="password">Nueva contraseña:</label>
        <input type="password" name="usuario_clave_nueva" placeholder="Ingrese una nueva contraseña" required>

        <label for="confirm_password">Repita su contraseña:</label>
        <input type="password" name="usuario_clave_confirmacion" placeholder="Repita su nueva contraseña" required>

        <input type="submit" class="boton" value="Guardar Cambios">
    </form>
    <form action="../Front/mostrar_perfil.php" method="GET">
            <button type="submit" class="boton boton-volver">Volver atrás</button>
        </form>
       
    <?php 
     include 'modificar.php';
     ?>
     <div id="mensaje-container" class="<?php echo $clase; ?>">
     <?php echo $mensaje; ?>
 </div>



</div>
</body>
</html>
