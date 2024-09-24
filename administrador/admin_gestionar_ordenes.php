<?php
require_once '../Controladores/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Órdenes - TechMart</title>
    <link rel="stylesheet" href="carrito.css">
</head>

<body>
    <header>
        <h1>Gestionar Órdenes</h1>
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
                    <th>ID Orden</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Finalizada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conexion->query("SELECT compras.*, usuario.usuario_usuario FROM compras JOIN usuario ON compras.usuario_id = usuario.usuario_id");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['id_compra'] . '</td>';
                    echo '<td>' . $row['usuario_usuario'] . '</td>';
                    echo '<td>' . $row['fecha_hora'] . '</td>';
                    echo '<td>$' . $row['total'] . '</td>';
                    echo '<td>' . ($row['finalizar'] ? 'Sí' : 'No') . '</td>';
                    echo '<td><a href="admin_view_order.php?id=' . $row['id_compra'] . '">Ver Detalles</a></td>';
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