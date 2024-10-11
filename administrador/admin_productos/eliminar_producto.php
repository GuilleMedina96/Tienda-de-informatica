<?php

session_start(); // Iniciar sesión
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/Controladores/conexion.php';
require $_SERVER['DOCUMENT_ROOT'] . '/Tienda de informatica/php/repositorio.php';

// Conectar a la base de datos
$conn = conexion();

// Crear instancia del repositorio
$repositorio = new Repositorio($conn);

// Verificar si se ha enviado el ID del producto
if (isset($_GET['producto_id'])) {
    $producto_id = $_GET['producto_id'];

    // Obtener los detalles del producto a eliminar
    $stmt = $conn->prepare("SELECT * FROM producto WHERE producto_id = ?");
    $stmt->execute([$producto_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo "Producto no encontrado.";
        exit();
    }
} else {
    echo "Error: No se ha proporcionado el ID del producto.";
    exit();
}

// Inicializar variables para mensajes
$mensaje = "";
$error = "";

// Verificar si se ha enviado el formulario para eliminar el producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contraseña = $_POST['contraseña'];
    $usuarioID = $_SESSION['usuario_id']; // El ID del usuario autenticado

    // Verificar la contraseña antes de eliminar usando la función del repositorio
    if ($repositorio->verificarClaveActual($usuarioID, $contraseña)) {
        if ($repositorio->eliminarProducto($producto_id)) {
            // Establecer un mensaje de éxito
            $mensaje = "Producto eliminado exitosamente.";
            echo "<script>mostrarMensajeExito();</script>"; // Ejecutar la función para ocultar inputs y mostrar mensaje de éxito
        } else {
            $error = "No se pudo eliminar el producto. Intenta nuevamente.";
        }
    } else {
        $error = "Contraseña incorrecta. No se pudo eliminar el producto.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link rel="stylesheet" href="../estilos_admin/eliminar_producto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <main>
            <h2>Eliminar Producto</h2>

            <p>Estás a punto de eliminar el siguiente producto:</p>
            <table>
                <tr>
                    <th>Código</th>
                    <td><?= htmlspecialchars($producto['producto_codigo']) ?></td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <td><?= htmlspecialchars($producto['producto_nombre']) ?></td>
                </tr>
                <tr>
                    <th>Precio</th>
                    <td><?= htmlspecialchars($producto['producto_precio']) ?></td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td><?= htmlspecialchars($producto['producto_stock']) ?></td>
                </tr>
                <tr>
                    <th>Foto</th>
                    <td>
                        <?php if (!empty($producto['producto_foto'])): ?>
                            <img src="<?= htmlspecialchars($producto['producto_foto']) ?>" alt="Foto de <?= htmlspecialchars($producto['producto_nombre']) ?>">
                        <?php else: ?>
                            No hay imagen disponible.
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <?php if ($mensaje): ?>
                <p class="mensaje-exito"><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>

            <?php if ($error): ?>
                <p class="mensaje-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <div id="formulario-eliminar">
                <form id="form-eliminar" action="" method="POST" onsubmit="return confirmarEliminar()">
                    <div class="input-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" id="contraseña" name="contraseña" required>
                        <span id="toggle-password" class="toggle-password">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </span>
                    </div>
                    <button type="submit">Eliminar Producto</button>
                </form>
            </div>
        </main>
        <div class="boton-volver">
            <a href="../admin_dashboard.php">
                <button>Volver al Panel de Administración</button>
            </a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 TechMart</p>
    </footer>

    <script>
        // Función para confirmar la eliminación del producto
        function confirmarEliminar() {
            return confirm("¿Estás seguro de que deseas eliminar este producto?");
        }

        // Función para ocultar el formulario e inputs y solo mostrar el mensaje de éxito
        function mostrarMensajeExito() {
            // Ocultar el formulario
            document.getElementById('formulario-eliminar').style.display = 'none';
        }

        // Funcionalidad para mostrar/ocultar la contraseña
        const togglePassword = document.querySelector('#toggle-password');
        const passwordField = document.querySelector('#contraseña');
        const eyeIcon = document.querySelector('#eye-icon');

        togglePassword.addEventListener('click', function() {
            // Alternar el tipo de input entre 'password' y 'text'
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Cambiar el icono del ojito
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>

</body>

</html>