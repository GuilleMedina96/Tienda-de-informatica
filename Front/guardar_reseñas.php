<?php
require_once 'conexion.php';

$query = "
    SELECT *
    FROM producto
    LIMIT 10"; // Cambia a un límite simple para depuración

$conexion = conexion();
$stmt = $conexion->prepare($query);
$stmt->execute();

$num_rows = $stmt->rowCount();
echo "Número de productos encontrados: " . $num_rows . "<br>"; // Mensaje de depuración

if ($num_rows > 0) {
    echo '<div class="product-container">'; // Contenedor para productos
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="product">';
        echo '<img src="' . htmlspecialchars($fila['producto_foto']) . '" alt="' . htmlspecialchars($fila['producto_nombre']) . '">';
        echo '<p>' . htmlspecialchars($fila['producto_nombre']) . '</p>';
        echo '<p>' . "Precio: $" . htmlspecialchars($fila['producto_precio']) . '</p>';
        echo '<p>' . "Stock: " . htmlspecialchars($fila['producto_stock']) . '</p>';
        echo '<form><button class="button-cat" formaction="categorias.php">Ver Mas</button></form>';

        echo '<form method="POST" action="guardar_reseña.php" class="review-form">';
        echo '<input type="hidden" name="id_producto" value="' . htmlspecialchars($fila['producto_id']) . '">';

        // Calificación con estrellas
        echo '<div class="rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<input type="radio" name="calificacion" value="' . $i . '" id="star' . $i . '" required>';
            echo '<label for="star' . $i . '" class="star">&#9733;</label>'; // Estrella
        }
        echo '</div>';

        // Comentario
        echo '<label for="comentario">Comentario:</label>';
        echo '<textarea name="comentario" required></textarea>';
        echo '<button type="submit">Enviar Reseña</button>';
        echo '</form>';

        echo '</div>'; // Cierra el div de producto
    }
    echo '</div>'; // Cierra el contenedor de productos
} else {
    echo 'No se encontraron productos.';
}
?>

<!-- Estilo CSS -->
<style>
    .product-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .product {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 10px;
        width: 200px;
        text-align: center;
    }

    .rating {
        display: flex;
        direction: row-reverse;
        justify-content: flex-end;
    }

    .rating input {
        display: none;
        /* Ocultamos los radio buttons */
    }

    .rating label {
        font-size: 2em;
        /* Tamaño de las estrellas */
        color: lightgray;
        /* Color de las estrellas no seleccionadas */
        cursor: pointer;
    }

    .rating input:checked~label {
        color: gold;
        /* Color de las estrellas seleccionadas */
    }

    .rating label:hover,
    .rating label:hover~label {
        color: gold;
        /* Color de las estrellas al pasar el mouse */
    }
</style>

<!-- JavaScript -->
<script>
    document.querySelectorAll('.rating input').forEach((input) => {
        input.addEventListener('click', function() {
            // Resaltamos las estrellas al hacer clic
            const value = this.value;
            const labels = this.parentElement.querySelectorAll('label');

            labels.forEach((label, index) => {
                if (index < value) {
                    label.style.color = 'gold'; // Resaltamos estrellas hasta la seleccionada
                } else {
                    label.style.color = 'lightgray'; // Resto en color gris
                }
            });
        });
    });
</script>