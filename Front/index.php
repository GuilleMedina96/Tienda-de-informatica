<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMart - Inicio</title>
    <link rel="stylesheet" href="estilos/navbarra.css">
    <link rel="stylesheet" href="estilos/homes.css">
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <h2>PRODUCTOS DESTACADOS</h2>

    <main>
        <div id="product-scroll">
            <div id="product-container">
                <?php
                require_once '../Controladores/controller-home.php';

                // Verificar si hay productos disponibles
                if ($num_rows === 0) {
                    echo '<p>No se encontraron productos.</p>'; // Mensaje en caso de no haber productos
                } else {
                    foreach ($productos as $producto) {
                        echo '<div class="product">';
                        echo '<img src="' . htmlspecialchars($producto['producto_foto']) . '" alt="' . htmlspecialchars($producto['producto_nombre']) . '">';
                        echo '<p>' . htmlspecialchars($producto['producto_nombre']) . '</p>';
                        echo '<p>Precio: $' . htmlspecialchars($producto['producto_precio']) . '</p>';
                        echo '<p>Stock: ' . htmlspecialchars($producto['producto_stock']) . '</p>';
                        echo '<form action="detalle_producto.php" method="get">'; // Cambia a detalle_producto.php
                        echo '<input type="hidden" name="producto_id" value="' . $producto['producto_id'] . '">'; // Añade el producto_id
                        echo '<button class="button-cat" type="submit">Ver Más</button>'; // Especifica el tipo de botón
                        echo '</form>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>

        <!-- Paginar por Categorías -->
        <h3>MEMORIAS RAM</h3>
        <div id="product-scroll">
            <div id="product-container">
                <?php
                // Definir la categoría que se quiere mostrar (ID 7)
                $_GET['categoria_id'] = 7;
                include '../Controladores/controller-home.php';
                ?>
            </div>
        </div>

        <!-- Aquí se movió el div de paginación -->
        <div class="pagination">
            <div class="pagination-arrow left-arrow">
                <a href="?pagina=<?php echo max(1, $pagina_actual - 1); ?>">&lt;</a>
            </div>
            <div class="pagination-pages">
                <?php
                // Lógica de paginación
                $rango = 1;
                $inicio = max(1, $pagina_actual - $rango);
                $fin = min($total_paginas, $pagina_actual + $rango);

                if ($inicio > 1) {
                    echo '<a href="?pagina=1">1</a>';
                    if ($inicio > 2) {
                        echo '...';
                    }
                }

                for ($i = $inicio; $i <= $fin; $i++) {
                    if ($i == $pagina_actual) {
                        echo '<strong>' . $i . '</strong>';
                    } else {
                        echo '<a href="?pagina=' . $i . '">' . $i . '</a>';
                    }
                }

                if ($fin < $total_paginas) {
                    if ($fin < $total_paginas - 1) {
                        echo '...';
                    }
                    echo '<a href="?pagina=' . $total_paginas . '">' . $total_paginas . '</a>';
                }
                ?>
            </div>
            <div class="pagination-arrow right-arrow">
                <a href="?pagina=<?php echo min($total_paginas, $pagina_actual + 1); ?>">&gt;</a>
            </div>
        </div>

        <!-- Paginar por Categorías -->
        <h3>MICROPROCESADORES</h3>
        <div id="product-scroll">
            <div id="product-container">
                <?php
                // Definir la categoría que se quiere mostrar (ID 6)
                $_GET['categoria_id'] = 6;
                include '../Controladores/controller-home.php';
                ?>
            </div>
        </div>

        <div class="pagination">
            <div class="pagination-arrow left-arrow">
                <a href="?pagina=<?php echo max(1, $pagina_actual - 1); ?>">&lt;</a>
            </div>
            <div class="pagination-pages">
                <?php
                // Lógica de paginación
                $rango = 1;
                $inicio = max(1, $pagina_actual - $rango);
                $fin = min($total_paginas, $pagina_actual + $rango);

                if ($inicio > 1) {
                    echo '<a href="?pagina=1">1</a>';
                    if ($inicio > 2) {
                        echo '...';
                    }
                }

                for ($i = $inicio; $i <= $fin; $i++) {
                    if ($i == $pagina_actual) {
                        echo '<strong>' . $i . '</strong>';
                    } else {
                        echo '<a href="?pagina=' . $i . '">' . $i . '</a>';
                    }
                }

                if ($fin < $total_paginas) {
                    if ($fin < $total_paginas - 1) {
                        echo '...';
                    }
                    echo '<a href="?pagina=' . $total_paginas . '">' . $total_paginas . '</a>';
                }
                ?>
            </div>
            <div class="pagination-arrow right-arrow">
                <a href="?pagina=<?php echo min($total_paginas, $pagina_actual + 1); ?>">&gt;</a>
            </div>
        </div>
    </main>

    <script>
        const productContainer = document.getElementById('product-container');
        const paginationLinks = document.querySelectorAll('.pagination-pages a');
        let index = 0;
        const productCount = productContainer.children.length;
        const productsToShow = 3;
        const productWidth = 480 + 20;
        const totalSlides = Math.ceil(productCount / productsToShow);

        function updatePagination() {
            paginationLinks.forEach((link, idx) => {
                link.classList.remove('active');
                if (idx === index) {
                    link.classList.add('active');
                }
            });
        }

        function moveCarousel() {
            index++;
            if (index >= totalSlides) {
                index = 0;
            }
            const offset = -index * (productWidth * productsToShow);
            productContainer.style.transform = `translateX(${offset}px)`;
            updatePagination();
        }

        setInterval(moveCarousel, 4000);
        updatePagination();
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>