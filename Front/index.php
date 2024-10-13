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

                // Mostrar todos los productos destacados sin paginación
                if ($num_rows === 0) {
                    echo '<div class="product"><img src="ruta/a/imagen1.jpg" alt="Producto 1"><p>Producto 1</p><p>Precio: $100</p></div>';
                    echo '<div class="product"><img src="ruta/a/imagen2.jpg" alt="Producto 2"><p>Producto 2</p><p>Precio: $150</p></div>';
                    echo '<div class="product"><img src="ruta/a/imagen3.jpg" alt="Producto 3"><p>Producto 3</p><p>Precio: $200</p></div>';
                } else {
                    foreach ($productos as $producto) { // Mostrar todos los productos sin paginación
                        echo '<div class="product">';
                        echo '<img src="' . htmlspecialchars($producto['producto_foto']) . '" alt="' . htmlspecialchars($producto['producto_nombre']) . '">';
                        echo '<p>' . htmlspecialchars($producto['producto_nombre']) . '</p>';
                        echo '<p>' . "Precio: $" . htmlspecialchars($producto['producto_precio']) . '</p>';
                        echo '<p>' . "Stock: " . htmlspecialchars($producto['producto_stock']) . '</p>';
                        echo '<form><button class="button-cat" formaction="productos_por_categoria.php?categoria_id=' . $producto['categoria_id'] . '">Ver Más</button></form>';
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
                $rango = 1; // Rango de páginas a mostrar
                $inicio = max(1, $pagina_actual - $rango);
                $fin = min($total_paginas, $pagina_actual + $rango);

                // Muestra los enlaces de paginación
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
                // Definir la categoría que se quiere mostrar (ID 7)
                $_GET['categoria_id'] = 6;
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
                $rango = 1; // Rango de páginas a mostrar
                $inicio = max(1, $pagina_actual - $rango);
                $fin = min($total_paginas, $pagina_actual + $rango);

                // Muestra los enlaces de paginación
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


        </div>
    </main>

    <script>
        const productContainer = document.getElementById('product-container');
        const paginationLinks = document.querySelectorAll('.pagination-pages a'); // Selecciona los enlaces de paginación
        let index = 0;
        const productCount = productContainer.children.length; // Cuenta el número de productos
        const productsToShow = 3; // Número de productos que deseas mostrar
        const productWidth = 480 + 20; // Ancho de cada producto más margen (asegúrate de que coincida con el CSS)
        const totalSlides = Math.ceil(productCount / productsToShow); // Total de grupos de productos

        function updatePagination() {
            paginationLinks.forEach((link, idx) => {
                link.classList.remove('active'); // Elimina la clase activa de todos
                if (idx === index) {
                    link.classList.add('active'); // Agrega la clase activa al índice actual
                }
            });
        }

        function moveCarousel() {
            index++;
            if (index >= totalSlides) {
                index = 0; // Reinicia el índice al llegar al final
            }
            const offset = -index * (productWidth * productsToShow); // Calcula el desplazamiento
            productContainer.style.transform = `translateX(${offset}px)`; // Aplica el desplazamiento
            updatePagination(); // Actualiza la paginación
        }

        // Cambia la imagen cada 4 segundos
        setInterval(moveCarousel, 4000);

        // Establecer la clase activa inicial en el primer elemento de paginación
        updatePagination();
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>