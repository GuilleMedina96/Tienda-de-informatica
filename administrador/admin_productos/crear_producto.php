<?php
// Conectar a la base de datos
include '../Controladores/conexion.php'; // Asegúrate de que este archivo maneje la conexión correctamente

// Llama a la función de conexión y almacena el resultado
$conexion = conexion();
$mensaje = ""; // Variable para mensajes

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $producto_codigo = trim($_POST['producto_codigo']);
    $producto_nombre = strtoupper(trim($_POST['producto_nombre'])); // Convertir el nombre a mayúsculas
    $producto_precio = $_POST['producto_precio'];
    $producto_stock = $_POST['producto_stock'];
    $categoria_id = $_POST['categoria_id'];

    // Validar los datos
    if (empty($producto_codigo) || !is_numeric($producto_precio) || $producto_precio < 0) {
        $mensaje = "Datos inválidos. Asegúrate de que el código no esté vacío y el precio sea un número positivo.";
    } else {
        // Manejo de la imagen subida
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            $producto_foto = $_FILES['foto']['name'];
            $ruta_foto = 'C:/xamp/htdocs/Tienda de informatica/Front/img/' . $producto_foto; // Ruta completa

            // Mover la imagen a la carpeta deseada
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_foto)) {
                // Preparar la consulta SQL para insertar
                $sql = "INSERT INTO producto (producto_codigo, producto_nombre, producto_precio, producto_stock, producto_foto, categoria_id) VALUES (?, ?, ?, ?, ?, ?)";

                // Preparar y ejecutar la declaración
                $stmt = $conexion->prepare($sql);
                if ($stmt) {
                    $stmt->bindParam(1, $producto_codigo);
                    $stmt->bindParam(2, $producto_nombre);
                    $stmt->bindParam(3, $producto_precio);
                    $stmt->bindParam(4, $producto_stock);
                    $stmt->bindParam(5, $producto_foto);
                    $stmt->bindParam(6, $categoria_id);

                    if ($stmt->execute()) {
                        $mensaje = "Producto insertado correctamente.";
                    } else {
                        $mensaje = "Error al insertar el producto: " . implode(", ", $stmt->errorInfo());
                    }
                } else {
                    $mensaje = "Error en la preparación de la consulta.";
                }
            } else {
                $mensaje = "Error al subir la imagen. Asegúrate de que la carpeta 'img' exista y tenga los permisos adecuados.";
            }
        } else {
            $mensaje = "Error al subir la imagen.";
        }
    }

    // Cerrar la conexión (no es necesario con PDO, pero puedes hacerlo si lo deseas)
    $conexion = null; // Cierra la conexión
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Producto</title>
    <link rel="stylesheet" href="./administrador/estilos_admin/agregar_producto.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            /* Color de fondo oscuro */
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 20px auto;
            background-color: #fff;
            /* Fondo blanco para el contenedor */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 50px;
            /* Tamaño de fuente más grande */
            text-align: center;
            background-color: #fd611a;
            /* Fondo naranja */
            color: white;
            /* Texto blanco */
            margin: 0;
            padding: 10px;
            /* Espaciado para mejorar la apariencia */
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #fd611a;
            /* Color naranja para las etiquetas */
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #fd611a;
            /* Color de fondo naranja */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
        }

        button:hover {
            background-color: #e05c17;
            /* Color más oscuro al pasar el ratón */
        }

        .mensaje-exito {
            color: green;
            font-weight: bold;
            text-align: center;
        }

        .mensaje-error {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        /* Estilos CSS para la carga de imagen */
        .prevPhoto {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 160px;
            height: 150px;
            border: 1px solid #CCC;
            position: relative;
            cursor: pointer;
            background: url(../images/uploads/user.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            margin: auto;
            overflow: hidden;
            margin-bottom: 10px;
            /* Espacio debajo del cuadrado de imagen */
        }

        .prevPhoto img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .upimg {
            text-align: center;
            /* Centrar el botón "Seleccionar Imagen" */
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#foto").on("change", function() {
                var uploadFoto = document.getElementById("foto").value;
                var foto = document.getElementById("foto").files;
                var nav = window.URL || window.webkitURL;
                var contactAlert = document.getElementById('form_alert');

                if (uploadFoto != '') {
                    var type = foto[0].type;
                    if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
                        contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                        $("#img").remove();
                        $(".delPhoto").addClass('notBlock');
                        $('#foto').val('');
                        return false;
                    } else {
                        contactAlert.innerHTML = '';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src=" + objeto_url + ">");
                        $(".upimg label").remove();
                    }
                } else {
                    alert("No seleccionó foto");
                    $("#img").remove();
                }
            });

            $('.delPhoto').click(function() {
                $('#foto').val('');
                $(".delPhoto").addClass('notBlock');
                $("#img").remove();
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <h2>Agregar Nuevo Producto</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="<?php echo strpos($mensaje, 'correctamente') !== false ? 'mensaje-exito' : 'mensaje-error'; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="categoria_id">Categoría del Producto</label>
            <select id="categoria_id" name="categoria_id" required>
                <option value="">Selecciona una categoría</option>
                <option value="1">Discos</option>
                <option value="2">Fuentes</option>
                <option value="3">Gabinetes</option>
                <option value="4">Motherboards</option>
                <option value="5">Placas de Video</option>
                <option value="6">Procesadores</option>
                <option value="7">Memorias RAM</option>
            </select>

            <label for="producto_codigo">Código del Producto</label>
            <input type="text" id="producto_codigo" name="producto_codigo" required>

            <label for="producto_nombre">Nombre del Producto</label>
            <input type="text" id="producto_nombre" name="producto_nombre" required>

            <label for="producto_precio">Precio del Producto</label>
            <input type="number" id="producto_precio" name="producto_precio" step="0.01" required>

            <label for="producto_stock">Stock del Producto</label>
            <input type="number" id="producto_stock" name="producto_stock" required>

            <div class="prevPhoto">
                <span class="delPhoto notBlock">X</span>
                <!-- Aquí se mostrará la imagen de vista previa -->
            </div>
            <div class="upimg">
                <label for="foto">Seleccionar Imagen</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>
            <div id="form_alert"></div>

            <button type="submit">Agregar Producto</button>
        </form>
    </div>
</body>

</html>