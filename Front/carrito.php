<?php
// Incluye el archivo de clases y la conexión
require_once '../Controladores/conexion.php';
require_once '../php/clase_categoria.php';
require_once '../php/clase_producto.php';
require_once '../php/clase_carrito.php';

// Obtiene el carrito desde la sesión si existe, o crea uno nuevo
$carrito = isset($_SESSION['carrito']) ? unserialize($_SESSION['carrito']) : new Carrito();

// Procesar la solicitud para agregar productos al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_carrito'])) {
    $productoID = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Validar la cantidad
    if (filter_var($cantidad, FILTER_VALIDATE_INT) && $cantidad > 0) {
        // Agregar producto al carrito
        $carrito->agregarProductoAlCarrito($productoID, $cantidad);
        // Guardar el carrito actualizado en la sesión
        $_SESSION['carrito'] = serialize($carrito);
        // Redirigir para evitar el reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        // Mensaje de error si la cantidad es inválida
        $_SESSION['mensaje'] = 'Cantidad no válida. Debe ser un número entero mayor que cero.';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto'])) {
    $productoID = $_POST['producto_id'];
    $carrito->eliminarProductoDelCarrito($productoID);  // Usar la nueva función de eliminar
    $_SESSION['carrito'] = serialize($carrito);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Mostrar los productos en el carrito
$productosEnCarrito = $carrito->obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="./estilos/navbarra.css">
    <link rel="stylesheet" href="estilos/carrito.css">
    <link rel="stylesheet" href="estilos/modal.css">

</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <div id="container-carrito">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($productosEnCarrito)) {
                    foreach ($productosEnCarrito as $productoCarrito) {
                        echo '<tr>';
                        echo '<td><img class="foto_carrito" src="' . htmlspecialchars($productoCarrito['producto']->getProductoFoto()) . '" alt=""></td>';
                        echo '<td>$' . number_format($productoCarrito['producto']->getProductoPrecio(), 2) . '</td>';
                        echo '<td>' . htmlspecialchars($productoCarrito['cantidad']) . '</td>';
                        echo '<td>$' . number_format($productoCarrito['producto']->getProductoPrecio() * $productoCarrito['cantidad'], 2) . '</td>';
                        // Cambiar enlace por ícono de basura
                        echo '<td>';
                        echo '<button type="button" class="btn-eliminar" onclick="eliminarDelCarrito(' . htmlspecialchars($productoCarrito['producto']->getProductoID()) . ')">';
                        echo '<img src="icono_basura.png" alt="Eliminar" class="icono-basura">'; // Cambia a la ruta de tu ícono
                        echo '</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">El carrito está vacío.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <div class="total">
            <p>Total: $<?php echo number_format($carrito->calcularTotal(), 2); ?></p>
            <a href="../php/vaciar_carrito.php" class="boton_vaciar_carrito">Vaciar Carrito</a>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <button id="abrirModal" class="boton_pago">Finalizar Compra</button>
            <?php else: ?>
                <a href="../php/registro.php">Regístrate aquí</a>
            <?php endif; ?>

            <?php
            if (isset($_SESSION['mensaje'])) {
                $mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
                $color = strpos($mensaje, "Error") !== false ? 'red' : 'green';
                echo '<p style="color: ' . $color . ';">' . htmlspecialchars($mensaje) . '</p>';
            }
            ?>
        </div>
    </div>
    <main>
        <!-- Modal -->
        <div id="miModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form action="procesar_pago.php" method="POST" id="formPago" class="form_pago">
                    <label for="metodo_pago" class="label_pago">Método de Pago:</label>
                    <select name="metodo_pago" id="metodo_pago" class="select_pago" required>
                        <option value="0">Seleccione el método de pago</option>
                        <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                        <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                        <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                    </select>

                    <div id="credit-card-info" class="credit-card-info" style="display: none;">
                        <h3 class="titulo_pago">Detalles de la Tarjeta</h3>

                        <label for="numero_tarjeta1" class="label_pago">Número de Tarjeta:</label>
                        <div class="input_tarjeta">
                            <input type="number" name="numero_tarjeta1" class="input-tarjeta" placeholder="0000" maxlength="4" required>
                            <input type="number" name="numero_tarjeta2" class="input-tarjeta" placeholder="0000" maxlength="4" required>
                            <input type="number" name="numero_tarjeta3" class="input-tarjeta" placeholder="0000" maxlength="4" required>
                            <input type="number" name="numero_tarjeta4" class="input-tarjeta" placeholder="0000" maxlength="4" required>
                        </div>

                        <label for="nombre_tarjeta" class="label_pago">Nombre en la Tarjeta:</label>
                        <input type="text" name="nombre_tarjeta" class="nombre_tarjeta" required>

                        <label for="fecha_expiracion" class="label_pago">Fecha de Expiración:</label>
                        <div class="contenedor-tarjeta">
                            <input type="number" name="mes_expiracion" class="input-tarjeta" placeholder="Mes" min="1" max="12" required>
                            <input type="number" name="anio_expiracion" class="input-tarjeta" placeholder="Año" min="<?php echo date('Y'); ?>" required>

                            <label for="codigo_seguridad" class="label_pago">Código de Seguridad:</label>
                            <input type="text" name="codigo_seguridad" class="codigo-seguridad" maxlength="3" required>
                        </div>

                        <label for="cuotas" class="label_pago" id="label_cuotas" style="display: none;">Selecciona Cuotas:</label>
                        <select name="cuotas" id="cuotas" style="display: none;">
                            <option value="1">1 cuota</option>
                            <option value="3">3 cuotas</option>
                            <option value="6">6 cuotas</option>
                            <option value="12">12 cuotas</option>
                        </select>
                    </div>
                    <div id="transferencia-info" style="display: none;">
                        <h3 class="titulo_pago">Detalles para Transferencia Bancaria</h3>
                        <p><strong>CBU:</strong> 1234567890123456789012</p>
                        <p><strong>Alias:</strong> techmart.tienda</p>
                        <p><strong>Banco:</strong> Banco Nación</p>
                        <p><strong>Titular:</strong> TechMart SRL</p>
                        <p><strong>Monto a Transferir:</strong> $<?php echo number_format($carrito->calcularTotal(), 2); ?></p>
                        <p><strong>Es importante enviar el comprobante de la transferencia.</strong></p>
                    </div>
                    <button type="submit" class="boton_pago">Confirmar Pago</button>
                </form>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <script>
        // Mostrar/ocultar campos de tarjeta y cuotas según método de pago
        var metodoPagoSelect = document.getElementById('metodo_pago');
        var creditCardInfo = document.getElementById('credit-card-info');
        var transferenciaInfo = document.getElementById('transferencia-info');
        var cuotasLabel = document.getElementById('label_cuotas');
        var cuotasSelect = document.getElementById('cuotas');

        metodoPagoSelect.onchange = function() {
            var valorSeleccionado = this.value;
            creditCardInfo.style.display = valorSeleccionado === "Tarjeta de Crédito" || valorSeleccionado === "Tarjeta de Débito" ? "block" : "none";
            transferenciaInfo.style.display = valorSeleccionado === "Transferencia Bancaria" ? "block" : "none";
            cuotasLabel.style.display = valorSeleccionado === "Tarjeta de Crédito" ? "block" : "none";
            cuotasSelect.style.display = valorSeleccionado === "Tarjeta de Crédito" ? "block" : "none";
        }
        // Función para confirmar la eliminación del producto
        function eliminarDelCarrito(productoID) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto del carrito?')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'; // Asegúrate de que la acción apunte a la página correcta
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'producto_id';
                input.value = productoID;
                form.appendChild(input);
                var input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'eliminar_producto';
                input2.value = true;
                form.appendChild(input2);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Modal de pago
        var modal = document.getElementById("miModal");
        var btn = document.getElementById("abrirModal");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>