<?php
require_once '../Controladores/conexion.php';

// Conectar a la base de datos
$conexion = conexion();

// Obtener el ID del producto
$producto_id = isset($_GET['producto_id']) ? (int)$_GET['producto_id'] : null;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>

    <link rel="stylesheet" href="../Front/estilos/detalle_productos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <div class="container">
        <main>
            <?php
            if ($producto_id) {
                // Cargar los detalles del producto
                $producto_query = "SELECT * FROM producto WHERE producto_id = :producto_id";
                $producto_stmt = $conexion->prepare($producto_query);
                $producto_stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
                $producto_stmt->execute();
                $producto = $producto_stmt->fetch(PDO::FETCH_ASSOC);

                if ($producto) {
                    // Mostrar los detalles del producto en una tabla
                    echo '<h2>Detalles del Producto</h2>';
                    echo '<table>';
                    echo '<tr>';
                    echo '<th>Código</th>';
                    echo '<td>' . htmlspecialchars($producto['producto_codigo']) . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<th>Nombre</th>';
                    echo '<td>' . htmlspecialchars($producto['producto_nombre']) . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<th>Precio</th>';
                    echo '<td>$' . htmlspecialchars($producto['producto_precio']) . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<th>Stock</th>';
                    echo '<td>' . htmlspecialchars($producto['producto_stock']) . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<th>Descripción</th>';  // Agregado para la descripción
                    echo '<td>' . nl2br(htmlspecialchars($producto['descripcion'])) . '</td>';  // Mostrando la descripción
                    echo '</tr>';
                    echo '<tr>';
                    echo '<th>Foto</th>';
                    echo '<td>';
                    if (!empty($producto['producto_foto'])) {
                        echo '<img src="' . htmlspecialchars($producto['producto_foto']) . '" alt="Foto de ' . htmlspecialchars($producto['producto_nombre']) . '" style="max-width: 200px; border-radius: 5px;">';
                    } else {
                        echo 'No hay imagen disponible.';
                    }
                    echo '</td>';
                    echo '</tr>';
                    echo '</table>';

                    // Formulario para agregar al carrito
                    echo '<form action="carrito.php" method="POST" class="agregar-carrito-form">';  // Clase para el formulario
                    echo '<input type="hidden" name="producto_id" value="' . htmlspecialchars($producto['producto_id']) . '">';
                    echo '<label for="cantidad">Cantidad:</label>';
                    echo '<input type="number" name="cantidad" id="cantidad" class="cantidad-input" min="1" max="' . htmlspecialchars($producto['producto_stock']) . '" value="1" required>'; // Clase para el input de cantidad
                    echo '<button type="submit" name="agregar_carrito" class="btn-agregar-carrito">Agregar al Carrito</button>'; // Clase para el botón
                    echo '</form>';
                } else {
                    echo '<p>Producto no encontrado.</p>';
                }
            } else {
                echo '<p>ID de producto no especificado.</p>';
            }
            ?>
        </main>
        <div class="boton-volver">
            <a href="index.php">
                <button>Volver al Inicio</button>
            </a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>