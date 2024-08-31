<?php
require_once 'conexion.php'; // Asegúrate de que la conexión esté incluida

class Pago {
    private $id;
    private $usuario_id;
    private $monto;
    private $fecha;
    private $metodo;

    public function __construct($id = null, $usuario_id = null, $monto = null, $fecha = null, $metodo = null) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->monto = $monto;
        $this->fecha = $fecha;
        $this->metodo = $metodo;
    }

    public function registrar() {
        $conexion = conexion();
        $query = "INSERT INTO pagos (usuario_id, monto, fecha, metodo) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$this->usuario_id, $this->monto, $this->fecha, $this->metodo]);
        $this->id = $conexion->lastInsertId();
    }

    public static function obtenerPorUsuario($usuario_id) {
        $conexion = conexion();
        $query = "SELECT * FROM pagos WHERE usuario_id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Getters and setters...
}
?>
