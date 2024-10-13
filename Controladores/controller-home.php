<?php
require_once 'conexion.php';

// Conectar a la base de datos
$conexion = conexion();

// Obtener el ID de la categoría si existe
$categoria_id = isset($_GET['categoria_id']) ? (int)$_GET['categoria_id'] : null;

// Cargar productos
if ($categoria_id) {
    // Si hay un ID de categoría, filtrar productos por esa categoría
    $productos_query = "SELECT * FROM producto WHERE categoria_id = :categoria_id";
    $productos_stmt = $conexion->prepare($productos_query);
    $productos_stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
} else {
    // Cargar productos de las categorías con id 6 y 7
    $productos_query = "SELECT * FROM producto WHERE categoria_id IN (6, 7)";
    $productos_stmt = $conexion->prepare($productos_query);
}

$productos_stmt->execute();
$productos = $productos_stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener el número total de productos
$num_rows = count($productos);

// Lógica de paginación
$productos_por_pagina = 3;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$total_paginas = ceil($num_rows / $productos_por_pagina);

// Calcular el offset para la paginación
$offset = ($pagina_actual - 1) * $productos_por_pagina;

// Filtrar los productos de la página actual
$productos_pagina = array_slice($productos, $offset, $productos_por_pagina); // Solo los productos de la página actual

if (count($productos_pagina) > 0) {
    foreach ($productos_pagina as $producto) {
        echo '<div class="product">';
        echo '<img src="' . htmlspecialchars($producto['producto_foto']) . '" alt="' . htmlspecialchars($producto['producto_nombre']) . '">';
        echo '<p>' . htmlspecialchars($producto['producto_nombre']) . '</p>';
        echo '<p>Precio: $' . htmlspecialchars($producto['producto_precio']) . '</p>';
        echo '<p>Stock: ' . htmlspecialchars($producto['producto_stock']) . '</p>';
        echo '<form><button class="button-cat" formaction="productos_por_categoria.php?categoria_id=' . $producto['categoria_id'] . '">Ver Más</button></form>';
        echo '</div>'; // Cierra div de producto
    }
} else {
    echo '<p>No se encontraron productos.</p>';
}
