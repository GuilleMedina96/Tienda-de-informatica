<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - TechMart</title>
    <link rel="stylesheet" href="./estilos_admin/navbar_admin.css">
    <link rel="stylesheet" href="../front/estilos/homes.css">
    <link rel="stylesheet" href="./estilos_admin/admin_buscar_productos.css">
</head>

<body>
    <header>
        <?php include './navbar_admin.php'; ?>
    </header>

    <main>
        <?php
        require_once '../Controladores/conexion.php';

        // Conectar a la base de datos
        $conexion = conexion();

        // Obtener la consulta de búsqueda
        $query = isset($_GET['query']) ? $_GET['query'] : '';

        // Paginación
        $productosPorPagina = 6;
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $offset = ($paginaActual - 1) * $productosPorPagina;

        // Mostrar el título de búsqueda
        echo '<h2>Resultados de Búsqueda para "' . htmlspecialchars($query) . '"</h2>';
        ?>

        <div id="product-container">
            <?php
            if (!empty($query)) {
                // Contar total de productos que coinciden con la búsqueda
                $total_query = "SELECT COUNT(*) FROM producto WHERE producto_nombre LIKE :query";
                $total_stmt = $conexion->prepare($total_query);
                $like_query = "%" . $query . "%"; // Se define la variable $like_query
                $total_stmt->bindParam(':query', $like_query);
                $total_stmt->execute();
                $totalProductos = $total_stmt->fetchColumn();

                // Usar una consulta SQL para buscar productos cuyo nombre coincida con la búsqueda
                $productos_query = "SELECT * FROM producto WHERE producto_nombre LIKE :query LIMIT :offset, :productosPorPagina";
                $productos_stmt = $conexion->prepare($productos_query);
                $productos_stmt->bindParam(':query', $like_query, PDO::PARAM_STR);
                // Se establece el valor de offset y productosPorPagina
                $productos_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $productos_stmt->bindValue(':productosPorPagina', $productosPorPagina, PDO::PARAM_INT);
                $productos_stmt->execute();
                $productos = $productos_stmt->fetchAll(PDO::FETCH_ASSOC);

                // Mostrar resultados
                if (count($productos) > 0) {
                    foreach ($productos as $producto) {
                        echo '<div class="product">';

                        if (!empty($producto['producto_foto'])) {
                            // Ruta relativa de la carpeta donde se encuentran las imágenes
                            $ruta_imagen = '../Front/' . htmlspecialchars($producto['producto_foto']);

                            // Mostrar la imagen del producto
                            echo '<img src="' . htmlspecialchars($ruta_imagen) . '" alt="Imagen de ' . htmlspecialchars($producto['producto_nombre']) . '"><br>';
                        } else {
                            echo '<p>Sin imagen disponible.</p>'; // Mensaje si no hay imagen
                        }

                        echo '<p>' . htmlspecialchars($producto['producto_nombre']) . '</p>';
                        echo '<p>Precio: $' . htmlspecialchars($producto['producto_precio']) . '</p>';
                        echo '<p>Stock: ' . htmlspecialchars($producto['producto_stock']) . '</p>';

                        echo '<form style="display:inline;" method="" action="./admin_productos/modificar_producto.php">';
                        echo '<input type="hidden" name="producto_id" value="' . htmlspecialchars($producto['producto_id']) . '">';
                        echo '<button type="submit" class="button-modificar">Modificar</button>';
                        echo '</form>';

                        echo '<form style="display:inline;" method="" action="./admin_productos/eliminar_producto.php" onsubmit="return confirm(\'¿Está seguro de que desea eliminar este producto?\');">';
                        echo '<input type="hidden" name="producto_id" value="' . htmlspecialchars($producto['producto_id']) . '">';
                        echo '<button type="submit" class="button-eliminar">Eliminar</button>';
                        echo '</form>';

                        echo '</div>'; // Cierre de div.product
                    }
                } else {
                    echo '<p>No se encontraron productos que coincidan con la búsqueda.</p>';
                }

                // Paginación
                $totalPaginas = ceil($totalProductos / $productosPorPagina);
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPaginas; $i++) {
                    echo '<a href="?query=' . urlencode($query) . '&pagina=' . $i . '">' . $i . '</a>';
                }
                echo '</div>';
            } else {
                echo '<p>Por favor, ingresa un término de búsqueda.</p>';
            }
            ?>
        </div>
        <div class="boton-volver">
            <a href="./admin_dashboard.php">
                <button>Volver al Panel de Administración</button>
            </a>
        </div>
    </main>

    <footer>
        <?php include './footer_admin.php'; ?>
    </footer>
</body>

</html>