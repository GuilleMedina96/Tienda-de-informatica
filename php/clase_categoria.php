<?php
class Categoria {
    private $categoria_id;
    private $categoria_nombre;

    public function __construct($categoria_id, $categoria_nombre) {
        $this->categoria_id = $categoria_id;
        $this->categoria_nombre = $categoria_nombre;
    }

    public function getCategoriaID() {
        return $this->categoria_id;
    }

    public function getCategoriaNombre() {
        return $this->categoria_nombre;
    }
}


?>