<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - TechMart</title>
    <link rel="stylesheet" href="estilos/navbarra.css">
    <link rel="stylesheet" href="estilos/homes.css">
    <link rel="stylesheet" href="estilos/buscar.css">
    <style>
        /* Estilo para la cuadrícula de productos */
        #product-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-left: auto;
            margin-right: auto;
            width: 90%;
        }

        .product {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .button-cat {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-cat:hover {
            background-color: #45a049;
        }

        /* Estilo para la paginación */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
        }

        .pagination a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main>
        <?php
        require_once '../Controladores/conexion.php';

        // Conectar a la base de datos
        $conexion = conexion();

        // Obtener la consulta de búsqueda
        $query = isset($_GET['query']) ? $_GET['query'] : '';

        // Paginación
        $productosPorPagina = 9;
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
                $total_stmt->bindParam(':query', $like_query);
                $like_query = "%" . $query . "%";
                $total_stmt->execute();
                $totalProductos = $total_stmt->fetchColumn();

                // Usar una consulta SQL para buscar productos cuyo nombre coincida con la búsqueda
                $productos_query = "SELECT * FROM producto WHERE producto_nombre LIKE :query LIMIT :offset, :productosPorPagina";
                $productos_stmt = $conexion->prepare($productos_query);
                $productos_stmt->bindParam(':query', $like_query, PDO::PARAM_STR);
                $productos_stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $productos_stmt->bindParam(':productosPorPagina', $productosPorPagina, PDO::PARAM_INT);
                $productos_stmt->execute();
                $productos = $productos_stmt->fetchAll(PDO::FETCH_ASSOC);

                // Mostrar resultados
                if (count($productos) > 0) {
                    foreach ($productos as $producto) {
                        echo '<div class="product">';
                        echo '<img src="' . htmlspecialchars($producto['producto_foto']) . '" alt="' . htmlspecialchars($producto['producto_nombre']) . '">';
                        echo '<p>' . htmlspecialchars($producto['producto_nombre']) . '</p>';
                        echo '<p>Precio: $' . htmlspecialchars($producto['producto_precio']) . '</p>';
                        echo '<p>Stock: ' . htmlspecialchars($producto['producto_stock']) . '</p>';
                        echo '<form><button class="button-cat" formaction="productos_por_categoria.php?categoria_id=' . $producto['categoria_id'] . '">Ver Más</button></form>';
                        echo '</div>';
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
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>

</html>