<?php

class Repositorio
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerUsuarioPorID($usuarioID)
    {
        $sql = "SELECT * FROM usuario WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuarioID]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return new Usuario(
                $resultado['usuario_nombre'],
                $resultado['usuario_apellido'],
                $resultado['usuario_usuario'],
                $resultado['usuario_email'],
                $resultado['usuario_clave']
            );
        } else {
            return null; // Retorna null si el usuario no se encuentra
        }
    }

    public function registrarUsuario($nombre, $apellido, $usuario, $clave, $email)
    {
        // Validar los datos aquí antes de ejecutar la consulta
        $hash_clave = password_hash($clave, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (usuario_nombre, usuario_apellido, usuario_usuario, usuario_clave, usuario_email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);

        if ($stmt) {
            $stmt->execute([$nombre, $apellido, $usuario, $hash_clave, $email]);

            // Verificamos si la inserción fue exitosa
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function modificarClave($usuarioID, $nombre, $apellido, $usuario, $email, $clave, $clave_actual)
    {
        // Comprueba si la contraseña actual es correcta
        if (!$this->verificarClaveActual($usuarioID, $clave_actual)) {
            return false; // La contraseña actual es incorrecta
        }

        $sql = "UPDATE usuario SET ";
        $values = [];

        if (!empty($nombre)) {
            $sql .= "usuario_nombre = ?, ";
            $values[] = $nombre;
        }

        if (!empty($apellido)) {
            $sql .= "usuario_apellido = ?, ";
            $values[] = $apellido;
        }

        if (!empty($usuario)) {
            $sql .= "usuario_usuario = ?, ";
            $values[] = $usuario;
        }

        if (!empty($email)) {
            $sql .= "usuario_email = ?, ";
            $values[] = $email;
        }

        if (!empty($clave)) {
            $sql .= "usuario_clave = ?, ";
            $values[] = $clave;
        }

        // Eliminar la coma final
        if (count($values) > 0) {
            $sql = rtrim($sql, ', ');
        } else {
            return false;
        }

        $sql .= " WHERE usuario_id = ?"; // WHERE para identificar al usuario
        $values[] = $usuarioID;

        $stmt = $this->conexion->prepare($sql);   // Preparar la consulta SQL

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . implode(', ', $this->conexion->errorInfo()));
        }

        // Ejecutar la consulta
        if ($stmt->execute($values)) {
            return true; // Actualización exitosa
        } else {
            throw new Exception("Error al ejecutar la consulta: " . implode(', ', $stmt->errorInfo())); //
        }
    }

    // Comprueba si la contraseña actual es correcta
    public function verificarClaveActual($usuarioID, $clave_actual)
    {
        $sql = "SELECT usuario_clave FROM usuario WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuarioID]);
        $resultado = $stmt->fetch();

        if ($resultado) {
            return password_verify($clave_actual, $resultado['usuario_clave']);
        } else {
            return false; // Usuario no encontrado
        }
    }



    public function eliminarUsuario($usuarioID)
    {
        $sql = "DELETE FROM usuario WHERE usuario_id=?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$usuarioID]);
    }

    public function agregarProducto($codigo, $nombre, $precio, $stock, $foto, $categoria_id)
    {
        // Validar los datos de entrada
        if (empty($codigo) || empty($nombre) || empty($precio) || empty($stock) || empty($categoria_id)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Validar que el precio y stock sean números
        if (!is_numeric($precio) || !is_numeric($stock)) {
            throw new Exception("El precio y el stock deben ser numéricos.");
        }

        // Preparar la consulta SQL para insertar el nuevo producto
        $sql = "INSERT INTO producto (producto_codigo, producto_nombre, producto_precio, producto_stock, producto_foto, categoria_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);

        try {
            // Ejecutar la consulta
            $stmt->execute([$codigo, $nombre, $precio, $stock, $foto, $categoria_id]);

            // Verificar si la inserción fue exitosa
            if ($stmt->rowCount() > 0) {
                return true; // Producto agregado con éxito
            } else {
                return false; // No se pudo agregar el producto
            }
        } catch (PDOException $e) {
            throw new Exception("Error al agregar el producto: " . $e->getMessage());
        }
    }
}
