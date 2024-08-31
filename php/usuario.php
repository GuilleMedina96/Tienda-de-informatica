<?php

class Usuario
{
    protected $usuarioID;
    private $usuario_nombre;
    private $usuario_apellido;
    private $usuario_usuario;
    private $usuario_email;
    private $usuario_clave;
    private $is_admin; // Nueva propiedad para indicar si el usuario es administrador

    // Constructor modificado para aceptar is_admin
    public function __construct($usuario_nombre, $usuario_apellido, $usuario_usuario, $usuario_email, $usuario_clave, $is_admin = false)
    {
        $this->usuario_nombre = $usuario_nombre;
        $this->usuario_apellido = $usuario_apellido;
        $this->usuario_usuario = $usuario_usuario;
        $this->usuario_email = $usuario_email;
        $this->usuario_clave = password_hash($usuario_clave, PASSWORD_DEFAULT);
        $this->is_admin = $is_admin;
    }

    // Getters para acceder a los datos del usuario

    public function getNombre()
    {
        return $this->usuario_nombre;
    }

    public function getApellido()
    {
        return $this->usuario_apellido;
    }

    public function getUsuario()
    {
        return $this->usuario_usuario;
    }

    public function getEmail()
    {
        return $this->usuario_email;
    }

    public function getClave()
    {
        return $this->usuario_clave;
    }

    public function setClave($nueva_clave)
    {
        $this->usuario_clave = $nueva_clave;
    }

    // Método para verificar la contraseña
    public function verificarPassword($usuario_clave)
    {
        return password_verify($usuario_clave, $this->usuario_clave);
    }

    // Métodos para manejar la propiedad is_admin
    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }
}
