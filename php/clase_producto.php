<?php

class Producto {
    private $producto_id;
    private $producto_codigo;
    private $producto_nombre;
    private $producto_precio;
    private $producto_stock;
    private $producto_foto;
    private $categoria;  // 

    public function __construct($producto_id, $producto_codigo, $producto_nombre, $producto_precio, $producto_stock, $producto_foto, Categoria $categoria) {
        $this->producto_id = $producto_id;
        $this->producto_codigo = $producto_codigo;
        $this->producto_nombre = $producto_nombre;
        $this->producto_precio = $producto_precio;
        $this->producto_stock = $producto_stock;
        $this->producto_foto = $producto_foto;
        $this->categoria = $categoria;
    }

    public function getProductoID() {
        return $this->producto_id;
    }

    public function getProductoCodigo() {
        return $this->producto_codigo;
    }


    public function getProductoNombre() {
        return $this->producto_nombre;
    }

    public function getProductoPrecio() {
        return $this->producto_precio;
    }

    public function getProductoStock() {
        return $this->producto_stock;
    }

    public function getProductoFoto() {
        return $this->producto_foto;
    }



}


?>