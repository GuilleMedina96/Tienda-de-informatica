<?php
require_once '../Controladores/conexion.php';
require_once 'usuario.php';
require_once 'repositorio.php';
require_once '../Controladores/verificar_datos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = limpiar_cadena($_POST['usuario_nombre']);
    $apellido = limpiar_cadena($_POST['usuario_apellido']);
    $usuario = limpiar_cadena($_POST['usuario_usuario']);
    $email = limpiar_cadena($_POST['usuario_email']);
    $clave1 = limpiar_cadena($_POST['usuario_clave_1']);
    $clave2 = limpiar_cadena($_POST['usuario_clave_2']);


    if($nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2==""){
        echo '
            <div class="mensaje-error">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
        <div class="mensaje-error">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
        echo '
            <div class="mensaje-error">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
        echo '
            <div class="mensaje-error">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando email ==*/
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email=$check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="mensaje-error">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_email=null;
        }else{
            echo '
            <div class="mensaje-error">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no valido
                </div>
            ';
            exit();
        } 
    }

    if ($clave1 !== $clave2) {
        $mensaje_error = "Las contraseñas no coinciden";
    } else {
        $conexion = conexion(); // Obtenemos la conexión desde el archivo conexion.php
        $repositorio = new Repositorio($conexion);

        $registrado = $repositorio->registrarUsuario($nombre, $apellido, $usuario, $clave1, $email);

        if ($registrado) {
            $mensaje_exito = "¡Usuario registrado con éxito!";
        } else {
            $mensaje_error = "Hubo un error al registrar el usuario.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Informática - Registro</title>
    <link rel="stylesheet"  href="../Front/estilos/registro.css">
</head>
<body>


    <main>
        <section class="formulario">
            <h2>Registro de Nuevos Usuarios:</h2>
            <form method="post" action="registro.php">
                
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="usuario_nombre" placeholder="Ingrese su nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" required>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="usuario_apellido" placeholder="Ingrese su apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" required>

                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario_usuario" placeholder="Ingrese un usuario" pattern="[a-zA-Z0-9]{4,20}" required>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="usuario_email" placeholder="Ingrese su email" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="usuario_clave_1" placeholder="Ingrese una contraseña" pattern="[a-zA-Z0-9$@.-]{7,100}" required>

                <label for="confirm_password">Repita su contraseña:</label>
                <input type="password" id="confirm_password" name="usuario_clave_2" placeholder="Repita su contraseña" pattern="[a-zA-Z0-9$@.-]{7,100}" required>

                <button type="submit">Registrarse</button>

                <?php
                     if (isset($mensaje_exito)) {
                      echo '<p style="color: green;">' . $mensaje_exito . '</p>';
                      }
                     if (isset($mensaje_error)) {
                    echo '<p style="color: red;">' . $mensaje_error . '</p>';
                    }
                 ?>
            </form>
            
            <form action="../Front/index.php" method="GET">
            <button type="submit">Volver al inicio</button>
            </form>
        </section>
    </main>
</body>
</html>
