<?php
require_once '../Controladores/conexion.php';

// Configuración de paginación
$limite = 10; // Número de órdenes por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $limite) - $limite : 0;

// Crear conexión
$conexion = conexion();

// Filtrar búsqueda por ID de orden o nombre de usuario
$filtro = "";
if (isset($_GET['buscar'])) {
    $busqueda = htmlspecialchars($_GET['buscar']);
    $filtro = "WHERE compras.id_compra LIKE '%$busqueda%' OR usuario.usuario_usuario LIKE '%$busqueda%'";
}

// Obtener el número total de órdenes
$totalOrdenes = $conexion->query("SELECT COUNT(*) as total FROM compras $filtro")->fetch(PDO::FETCH_ASSOC)['total'];


// Obtener las órdenes con paginación y filtro
$sql = "SELECT compras.*, usuario.usuario_usuario 
        FROM compras 
        JOIN usuario ON compras.usuario_id = usuario.usuario_id 
        $filtro
        LIMIT $inicio, $limite";
$ordenes = $conexion->query($sql); // Verifica si se obtienen órdenes

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Órdenes - TechMart</title>
    <link rel="stylesheet" href="../Front/estilos/carrito.css">
    <link rel="stylesheet" href="../Front/estilos/navbarra.css">
    <link rel="stylesheet" href="./estilos_admin/admin_gestionar_ordenes.css">
</head>

<body>
    <header>
        <?php include "navbar_admin.php"; ?>
    </header>

    <div class="container">
        <h2>Gestión de Órdenes</h2>
        <p>Aquí puedes revisar y gestionar las órdenes realizadas en la tienda.</p>

        <!-- Formulario de búsqueda -->
        <form class="search-form" action="admin_gestionar_ordenes.php" method="GET">
            <input type="text" name="buscar" placeholder="Buscar por ID de orden o usuario">
            <input type="submit" value="Buscar">
        </form>

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
                <?php while ($row = $ordenes->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?php echo $row['id_compra']; ?></td>
                        <td><?php echo $row['usuario_usuario']; ?></td>
                        <td><?php echo $row['fecha_hora']; ?></td>
                        <td>$<?php echo number_format($row['total'], 2); ?></td>
                        <td><?php echo ($row['finalizar']) ? 'Sí' : 'No'; ?></td>
                        <td>
                            <a href="admin_view_order.php?id=<?php echo $row['id_compra']; ?>">Ver Detalles</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination">
            <?php
            $totalPaginas = ceil($totalOrdenes / $limite);
            for ($i = 1; $i <= $totalPaginas; $i++) :
                $active = ($pagina == $i) ? 'active' : '';
            ?>
                <a href="?pagina=<?php echo $i; ?>" class="<?php echo $active; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 TechMart</p>
    </footer>
</body>

</html>