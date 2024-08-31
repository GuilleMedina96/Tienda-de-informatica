<?php
require_once 'conexion.php'; // Asegúrate de que la conexión esté incluida

class Resenia
{
    private $id;
    private $producto_id;
    private $usuario_id;
    private $comentario;
    private $calificacion;
    private $fecha;

    public function __construct($id = null, $producto_id = null, $usuario_id = null, $comentario = null, $calificacion = null, $fecha = null)
    {
        $this->id = $id;
        $this->producto_id = $producto_id;
        $this->usuario_id = $usuario_id;
        $this->comentario = $comentario;
        $this->calificacion = $calificacion;
        $this->fecha = $fecha;
    }

    public function guardar()
    {
        $conexion = conexion();
        $query = "INSERT INTO reseñas (producto_id, usuario_id, comentario, calificacion, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$this->producto_id, $this->usuario_id, $this->comentario, $this->calificacion, $this->fecha]);
        $this->id = $conexion->lastInsertId();
    }

    public function actualizar()
    {
        $conexion = conexion();
        $query = "UPDATE reseñas SET comentario = ?, calificacion = ?, fecha = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$this->comentario, $this->calificacion, $this->fecha, $this->id]);
    }

    public function eliminar()
    {
        $conexion = conexion();
        $query = "DELETE FROM reseñas WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$this->id]);
    }

    public static function obtenerPorProducto($producto_id)
    {
        $conexion = conexion();
        $query = "SELECT * FROM reseñas WHERE producto_id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$producto_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Getters and setters...
}
