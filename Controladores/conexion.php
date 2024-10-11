<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');

function conexion()
{
    $host = "localhost";
    $nombre_bd = "inventario";
    $usuario = "root";
    $usuario_clave = ""; // Cambia esto si tienes una contraseña

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$nombre_bd", $usuario, $usuario_clave);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Conexión exitosa"; // Para depuración
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
