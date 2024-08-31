<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
function conexion()
{
    $host = "localhost";
    $nombre_bd = "inventario";
    $usuario = "root";
    $usuario_clave = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$nombre_bd", $usuario, $usuario_clave);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
