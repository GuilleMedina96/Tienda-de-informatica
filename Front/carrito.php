<?php
// Inicia la sesión


// Incluye el archivo de clases y la conexión
require_once '../Controladores/conexion.php';
require_once '../php/clase_categoria.php';
require_once '../php/clase_producto.php';
require_once '../php/clase_carrito.php';

// Obtiene el carrito desde la sesión si existe, o crea uno nuevo
$carrito = isset($_SESSION['carrito']) ? unserialize($_SESSION['carrito']) : new Carrito();

// Procesar la solicitud para agregar productos al carrito
if (isset($_POST['agregar_carrito'])) {
    $productoID = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Agregar producto al carrito
    $carrito->agregarProductoAlCarrito($productoID, $cantidad);

    // Guardar el carrito actualizado en la sesión
    $_SESSION['carrito'] = serialize($carrito);
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
   <link rel="stylesheet" href="../Front/estilos/navbar.css">
   <link rel="stylesheet" href="../Front/estilos/carrito.css">
</head>
<body>
<header>
   <?php 
   include 'navbar.php';
   ?>
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
            // Verifica si hay productos en el carrito
            if (!empty($productosEnCarrito)) {
                foreach ($productosEnCarrito as $productoCarrito) {
                    echo '<tr>';
                    echo '<td><img class="foto_carrito" src="' . $productoCarrito['producto']->getProductoFoto() . '" alt=""></td>';
                    echo '<td>$' . $productoCarrito['producto']->getProductoPrecio() . '</td>';
                    echo '<td>' . $productoCarrito['cantidad'] . '</td>';
                    echo '<td>$' . $productoCarrito['producto']->getProductoPrecio() * $productoCarrito['cantidad'] . '</td>';
                    echo '<td><a href="eliminar_producto_carrito.php?id=' . $productoCarrito['producto']->getProductoID() . '">Eliminar</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">El carrito está vacío.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <div class="total">
        
        <p>Total: $<?php echo $carrito->calcularTotal(); ?></p>
        <a href="../php/vaciar_carrito.php" class="boton_vaciar_carrito">Vaciar Carrito</a>
        <?php
        
        if (isset($_SESSION['usuario_id'])) {
            echo '<a href="../php/finalizar-compra.php">Finalizar Compra</a>';
        }else {
            echo '<a href="../php/registro.php">Registrate aqui</a>';
        }
        ?>
        <?php 
                
                if (isset($_SESSION['mensaje'])) {
                    $mensaje = $_SESSION['mensaje'];
                    unset($_SESSION['mensaje']);
                    $error = "Error";
                    
                    if (strpos($mensaje, $error) !== false) {
                        echo '<p style="color: red;">' . $mensaje . '</p>';
                        
                    }else {
                        echo '<p style="color: green;">' . $mensaje . '</p>';
                    }
                }
        
        ?>
        
    
    </div>
</div>

<footer>
    <p>&copy; 2023 Tienda de Informática</p>
</footer>
</body>
</html>



