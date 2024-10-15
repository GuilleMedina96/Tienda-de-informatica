<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - TechMart</title>
    <link rel="stylesheet" href="./estilos_admin/navbar_admin.css">
    <link rel="stylesheet" href="../front/estilos/homes.css">
    <!-- <link rel="stylesheet" href="../front/estilos/buscar.css"> -->

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
            margin-top: 10px;
            /* Espacio entre botones */
        }

        .button-cat:hover {
            background-color: #45a049;
        }

        /* Estilo para los botones de modificar y eliminar */
        .button-modificar,
        .button-eliminar {
            background-color: #007bff;
            /* Color para el botón de modificar */
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 5px;
            /* Espacio entre botones */
        }

        .button-modificar:hover {
            background-color: #0056b3;
            /* Color al pasar el mouse */
        }

        .button-eliminar {
            background-color: #dc3545;
            /* Color para el botón de eliminar */
        }

        .button-eliminar:hover {
            background-color: #c82333;
            /* Color al pasar el mouse */
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
                        echo '<img src="' . ($producto['producto_foto']) . '" alt="' . htmlspecialchars($producto['producto_nombre']) . '">';
                        echo '<p>' . htmlspecialchars($producto['producto_nombre']) . '</p>';
                        echo '<p>Precio: $' . htmlspecialchars($producto['producto_precio']) . '</p>';
                        echo '<p>Stock: ' . htmlspecialchars($producto['producto_stock']) . '</p>';



                        echo '<form style="display:inline;" method="GET" action="./admin_productos/modificar_producto.php">';
                        echo '<input type="hidden" name="producto_id" value="' . htmlspecialchars($producto['producto_id']) . '">';
                        echo '<button type="submit" class="button-modificar">Modificar</button>';
                        echo '</form>';

                        echo '<form style="display:inline;" method="GET" action="./admin_productos/eliminar_producto.php" onsubmit="return confirm(\'¿Está seguro de que desea eliminar este producto?\');">';
                        echo '<input type="hidden" name="producto_id" value="' . htmlspecialchars($producto['producto_id']) . '">';
                        echo '<button type="submit" class="button-eliminar">Eliminar</button>';
                        echo '</form>';

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