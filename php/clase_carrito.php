<?php
require_once '../Controladores/conexion.php';
require_once "clase_producto.php";
require_once "clase_categoria.php";

session_start();

class Carrito
{
    private $productos; // Array para almacenar los productos en el carrito.
    public function __construct()
    {
        $this->productos = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
    }

    // Agregar un producto al carrito.
    public function agregarProducto(Producto $producto, $cantidad = 1)
    {
        $productoID = $producto->getProductoID();

        // Verifica si el producto ya está en el carrito.
        if (array_key_exists($productoID, $this->productos)) {
            $this->productos[$productoID]['cantidad'] += $cantidad;
        } else {
            // Si no está en el carrito, agrégalo.
            $this->productos[$productoID] = array(
                'producto' => $producto,
                'cantidad' => $cantidad
            );
        }
    }

    // Obtener todos los productos en el carrito.
    public function obtenerProductos()
    {
        return $this->productos;
    }

    // Calcular el precio total del carrito.
    public function calcularTotal()
    {
        $total = 0;
        foreach ($this->productos as $productoData) {
            $producto = $productoData['producto'];
            $cantidad = $productoData['cantidad'];
            $total += $producto->getProductoPrecio() * $cantidad;
        }
        return $total;
    }


    public function agregarProductoAlCarrito($productoID, $cantidad)
    {
        // Si el producto ya está en la sesión, simplemente actualiza la cantidad
        if (isset($this->productos[$productoID])) {
            $this->productos[$productoID]['cantidad'] += $cantidad;
        } else {
            // Si no está en la sesión, busca en la base de datos y agrégalo
            $producto = $this->obtenerDetallesProductoDesdeBD($productoID);
            if ($producto) {
                $this->agregarProducto($producto, $cantidad);
            } else {
                echo "Producto no encontrado.";
            }
        }

        // Guarda el carrito actualizado en la sesión
        $_SESSION['carrito'] = $this->productos;
    }

    private function obtenerDetallesProductoDesdeBD($productoID)
    {
        $conexion = conexion();

        if ($conexion) {
            $sql = "SELECT producto_id, producto_nombre, producto_precio, producto_foto FROM producto WHERE producto_id = :productoID";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':productoID', $productoID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $producto = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($producto) {
                    return new Producto($producto['producto_id'], '', $producto['producto_nombre'], $producto['producto_precio'], 0, $producto['producto_foto'], new Categoria(0, ''));
                }
            } else {
                echo "Error al ejecutar la consulta.";
            }

            // Cerrar la conexión a la base de datos
            $conexion = null;
        } else {
            echo "Error de conexión a la base de datos.";
        }

        return null;
    }


    // Remover un producto del carrito.
    public function removerProducto($productoID)
    {
        if (array_key_exists($productoID, $this->productos)) {
            unset($this->productos[$productoID]);
        }
    }

    public function obtenerStockProductoDesdeBD($conexion, $productoID)
    {
        $sql = "SELECT producto_stock FROM producto WHERE producto_id = :productoID";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':productoID', $productoID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado['producto_stock'];
            }
        }

        return 0;  // Valor predeterminado si no se encuentra el producto o hay un error en la consulta
    }

    public function finalizarCompra()
    {
        try {
            $conexion = conexion();
            if (empty($this->productos)) {
                $_SESSION['mensaje'] = "El carrito está vacío. No se puede realizar la compra.";
                return;
            }
            if ($conexion) {
                $idUsuario = $_SESSION['usuario_id'];
                $fechaCompra = date('Y-m-d H:i:s');

                // Aca se traen los productos del carrito
                $productosEnCarrito = $this->obtenerProductos();

                $suficienteStock = true;
                $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
                // Iniciar una transacción para asegurar la integridad de los datos
                $conexion->beginTransaction();

                foreach ($productosEnCarrito as $productoData) {
                    $producto = $productoData['producto'];
                    $cantidad = $productoData['cantidad'];
                    $productoID = $producto->getProductoID();

                    // Verificar si hay suficiente stock
                    $stockDisponible = $this->obtenerStockProductoDesdeBD($conexion, $productoID);

                    if ($stockDisponible >= $cantidad) {
                        //Aca se resta la cantidad comprada
                        $nuevoStock = $stockDisponible - $cantidad;
                        // Actualiza el producto_stock en la base de datos
                        $this->actualizarStockProductoEnBD($conexion, $productoID, $nuevoStock);
                    } else {
                        // No hay suficiente stock para el producto
                        $suficienteStock = false;
                        break;  // Abandona el bucle por que ya no necesita verificar
                    }
                }

                if ($suficienteStock) {

                    $sqlCompra = "INSERT INTO compras (usuario_id, fecha_hora, finalizar) VALUES (:usuario_id, :fecha_hora, 0)";
                    $stmtCompra = $conexion->prepare($sqlCompra);
                    $stmtCompra->bindParam(':usuario_id', $idUsuario, PDO::PARAM_INT);
                    $stmtCompra->bindParam(':fecha_hora', $fechaCompra);

                    if ($stmtCompra->execute()) {
                        $idCompra = $conexion->lastInsertId();

                        foreach ($productosEnCarrito as $productoData) {
                            $producto = $productoData['producto'];
                            $cantidad = $productoData['cantidad'];
                            $productoID = $producto->getProductoID();

                            $sqlProductoCompra = "INSERT INTO orden_producto (id_compra, producto_id, cantidad_compra) 
                                                VALUES (:id_compra, :producto_id, :cantidad)";
                            $stmtProductoCompra = $conexion->prepare($sqlProductoCompra);
                            $stmtProductoCompra->bindParam(':id_compra', $idCompra, PDO::PARAM_INT);
                            $stmtProductoCompra->bindParam(':producto_id', $productoID, PDO::PARAM_INT);
                            $stmtProductoCompra->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);

                            if ($stmtProductoCompra->execute() !== TRUE) {
                                $_SESSION['mensaje'] = "Error al insertar producto en nuestro registro";
                            }
                        }
                        $conexion->commit();
                        $_SESSION['mensaje'] = "Compra registrada correctamente.";
                    } else {
                        $_SESSION['mensaje'] = "Error al registrar la compra";
                    }
                } else {
                    // Revierte si no hay suficiente stock
                    $conexion->rollBack();
                    $_SESSION['mensaje'] = "Error: No hay suficiente stock para uno o más productos.";
                }
            } else {
                $_SESSION['mensaje'] = "Error: No se pudo conectar a la tienda";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            // Cerrar la conexión
            $conexion = null;
        }
    }

    public function actualizarStockProductoEnBD($conexion, $productoID, $nuevoStock)
    {
        $sql = "UPDATE producto SET producto_stock = :nuevoStock WHERE producto_id = :productoID";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nuevoStock', $nuevoStock, PDO::PARAM_INT);
        $stmt->bindParam(':productoID', $productoID, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
