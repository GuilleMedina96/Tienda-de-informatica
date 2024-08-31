<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Estilos/navbar.css">
  <link rel="stylesheet" href="Estilos/categorias.css">
  <title>TechMart - Tienda de electronica</title>
</head>
<body>
  <header>

    <?php 
      include 'navbar.php'; 
    ?>
  </header>
      
  <div class="filters">
      <select name="orden" id="ordenselect" class="button-select" onchange="actualizarOrden()">
      <option value="" disabled selected hidden>Ordenar por</option>
        <option value="asc">Menor precio</option>
        <option value="desc">Mayor precio</option>  
      </select>
      <a href="?categoria=todos">Mostrar todos</a>
      <a href="?categoria=1">Discos</a>
      <a href="?categoria=2">Fuentes</a>
      <a href="?categoria=3">Gabinetes</a>
      <a href="?categoria=4">Mothers</a>
      <a href="?categoria=5">Placas de video</a>
      <a href="?categoria=6">Procesadores</a>
      <a href="?categoria=7">Ram</a>
      <svg xmlns="http://www.w3.org/2000/svg" 
      fill="none" 
      viewBox="0 0 24 24" 
      stroke-width="1.5" 
      stroke="currentColor" 
      class="icon-cart">
      <path stroke-linecap="round" 
      stroke-linejoin="round" 
      d="M2.25 3h1.386c.51 0 .955.343 
      1.087.835l.383 1.437M7.5 14.25a3 
      3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 
      2.1-4.684 2.924-7.138a60.114 60.114 0 
      00-16.536-1.84M7.5 14.25L5.106 5.272M6 
      20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 
      0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 
      011.5 0z" />
      </svg>
  </div>
  

  <div id="product-container">
    <?php
    // session_start();
    include '../Controladores/controller-categorias.php';
    
    // Procesar la solicitud para agregar productos al carrito
if (isset($_POST['agregar_carrito'])) {
  $productoIDs = $_POST['producto_id'];
  $cantidades = $_POST['cantidad'];

  // Agregar cada producto al carrito con su respectiva cantidad
  for ($i = 0; $i < count($productoIDs); $i++) {
      $productoID = $productoIDs[$i];
      $cantidad = $cantidades[$i];

      // Agregar producto al carrito
      $carrito->agregarProductoAlCarrito($productoID, $cantidad);
  }

}
  
  ?>
  </div>
  <script>
    function actualizarOrden() {
      const select = document.getElementById('ordenselect');
      const orden = select.value;
      const categoria = obtenerCategoriaActual();
      const nuevaURL = `categorias.php?categoria=${categoria}&orden=${orden}`;
      window.location.href = nuevaURL;
    }

    function obtenerCategoriaActual() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('categoria') || 'todos';
    }
  </script>
</body>

</html>
