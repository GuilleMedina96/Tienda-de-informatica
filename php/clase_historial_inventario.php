<?php
require_once 'conexion.php'; // Asegúrate de que la conexión esté incluida

class HistorialInventario {
    private $id;
    private $producto_id;
    private $cantidad;
    private $fecha;

    public function __construct($id = null, $producto_id = null, $cantidad = null, $fecha = null) {
        $this->id = $id;
        $this->producto_id = $producto_id;
        $this->cantidad = $cantidad;
        $this->fecha = $fecha;
    }

    public function registrar() {
        $conexion = conexion();
        $query = "INSERT INTO historial_inventario (producto_id, cantidad, fecha) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$this->producto_id, $this->cantidad, $this->fecha]);
        $this->id = $conexion->lastInsertId();
    }

    public static function obtenerPorProducto($producto_id) {
        $conexion = conexion();
        $query = "SELECT * FROM historial_inventario WHERE producto_id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$producto_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Getters and setters...
}
?>
