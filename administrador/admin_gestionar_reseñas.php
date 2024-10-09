<?php
require_once '../Controladores/conexion.php'; // Asegúrate de que la ruta es correcta

// Crear conexión
$conexion = conexion();
// Manejo de eliminación de reseñas
if (isset($_GET['delete'])) {
    $reseña_id = $_GET['delete'];
    $query = "DELETE FROM reseñas WHERE id_reseña = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $reseña_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Reseña eliminada exitosamente.";
    } else {
        echo "Error al eliminar la reseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Reseñas - TechMart</title>
    <link rel="stylesheet" href="../Front/estilos/carrito.css">
    <link rel="stylesheet" href="../Front/estilos/navbarra.css">
    <link rel="stylesheet" href="./estilos_admin/admin_gestionar_reseñas.css">
</head>

<body>
    <header>
        <?php include "navbar_admin.php"; ?>
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
                // Consulta para obtener reseñas
                $result = $conexion->query("SELECT reseñas.*, producto.producto_nombre, usuario.usuario_usuario 
                                             FROM reseñas 
                                             JOIN producto ON reseñas.id_producto = producto.producto_id 
                                             JOIN usuario ON reseñas.id_usuario = usuario.usuario_id");

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id_reseña']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['producto_nombre']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['usuario_usuario']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['calificacion']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['comentario']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['fecha_reseña']) . '</td>';
                    echo '<td>
                            <a href="?delete=' . htmlspecialchars($row['id_reseña']) . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta reseña?\')">Eliminar</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 TechMart</p>
    </footer>
</body>

</html>