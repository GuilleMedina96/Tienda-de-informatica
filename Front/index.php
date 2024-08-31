

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMart - Inicio</title>
    <link rel="stylesheet"  href="Estilos/navbar.css">
    <link rel="stylesheet"  href="Estilos/home.css">
</head>
<body>

<header>
<?php include 'navbar.php'; ?>
</header>

<h2>
    Productos Destacados
</h2>

<div id="product-container">
       <?php include '../Controladores/controller-home.php'; ?>
</div>

</body>
</html>
