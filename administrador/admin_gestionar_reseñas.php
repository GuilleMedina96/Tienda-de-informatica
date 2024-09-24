<?php
require_once '../Controladores/conexion.php';

if (isset($_GET['delete'])) {
    $reseña_id = $_GET['delete'];
    $query = "DELETE FROM reseñas WHERE id_reseña = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $reseña_id, PDO::PARAM_INT);
    $stmt->execute();
    echo "Reseña eliminada exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Reseñas - TechMart</title>
    <link rel="stylesheet" href="carrito.css">
</head>

<body>
    <header>
        <h1>Gestionar Reseñas</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>ID Reseña</th>
                    <th>Producto</th>
                    <th>Usuario</th>
                    <th>Calificación</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conexion->query("SELECT reseñas.*, producto.producto_nombre, usuario.usuario_usuario FROM reseñas JOIN producto ON reseñas.id_producto = producto.producto_id JOIN usuario ON reseñas.id_usuario = usuario.usuario_id");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['id_reseña'] . '</td>';
                    echo '<td>' . $row['producto_nombre'] . '</td>';
                    echo '<td>' . $row['usuario_usuario'] . '</td>';
                    echo '<td>' . $row['calificacion'] . '</td>';
                    echo '<td>' . $row['comentario'] . '</td>';
                    echo '<td>' . $row['fecha_reseña'] . '</td>';
                    echo '<td>
                            <a href="admin_gestionar_reseñas.php?delete=' . $row['id_reseña'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta reseña?\')">Eliminar</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2023 TechMart</p>
    </footer>
</body>

</html>