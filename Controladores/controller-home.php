<?php
require_once 'conexion.php';

// Ajuste la consulta SQL para cumplir con ONLY_FULL_GROUP_BY
$query = "
    SELECT *
    FROM producto
    WHERE producto_id IN (
        SELECT producto_id
        FROM (
            SELECT producto_id
            FROM producto
            ORDER BY RAND()
        ) AS temp
        GROUP BY categoria_id
    )
";

$conexion = conexion();
// Prepara la consulta
$stmt = $conexion->prepare($query);

// Ejecuta la consulta
$stmt->execute();

// Obtener el número de filas
$num_rows = $stmt->rowCount();

if ($num_rows > 0) {
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Procesa cada fila
        echo '<div class="product">';
        echo '<img src="' . htmlspecialchars($fila['producto_foto']) . '" alt="' . htmlspecialchars($fila['producto_nombre']) . '">';
        echo '<p>' . htmlspecialchars($fila['producto_nombre']) . '</p>';
        echo '<p>' . "Precio: $" . htmlspecialchars($fila['producto_precio']) . '</p>';
        echo '<p>' . "Stock: " . htmlspecialchars($fila['producto_stock']) . '</p>';
        echo '<form><button class="button-cat" formaction="categorias.php">Ver Mas</button></form>';
        echo '</div>';
    }
} else {
    echo 'No se encontraron productos.';
}
