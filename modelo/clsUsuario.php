<?php

require_once __DIR__ . '/clsDatos.php';

class clsUsuario {

    private $id;
    private $username;
    private $password;
    private $nombres;
    private $email;
    private $telefono;
    private $direccion;
    private $foto;
    private $id_referencia;
    private $rol;
    private $codigo_barra;
    private $descripcion;
    private $estado;

    public function __construct() {
        $this->id = "";
        $this->username = "";
        $this->password = "";
        $this->nombres = "";
        $this->email = "";
        $this->telefono = "";
        $this->direccion = "";
        $this->foto = "";
        $this->id_referencia = 0;
        $this->rol = 0;
        $this->codigo_barra = "";
        $this->descripcion = "";
        $this->estado = 0;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getId_referencia() {
        return $this->id_referencia;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getCodigo_barra() {
        return $this->codigo_barra;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setId_referencia($id_referencia) {
        $this->id_referencia = $id_referencia;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setCodigo_barra($codigo_barra) {
        $this->codigo_barra = $codigo_barra;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function autenticar($usuario, $clave) {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "select * from usuario u where u.username = '$usuario' and u.password = MD5('$clave')";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->id = $registros['id'];
            $this->username = $registros['username'];
            $this->password = $registros['password'];
            $this->nombres = $registros['nombres'];
            $this->email = $registros['email'];
            $this->telefono = $registros['telefono'];
            $this->direccion = $registros['direccion'];
            $this->foto = $registros['foto'];
            $this->id_referencia = $registros['id_referencia'];
            $this->rol = $registros['Rol'];
            $this->codigo_barra = $registros['codigo_barra'];
            $this->descripcion = $registros['descripcion'];
            $this->estado = $registros['estado'];
            $exito = true;
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $exito;
    }

    public function buscarXCodigoJSON() {
        $objDatos = new clsDatos();
        $registros = "";
        $sql = "select * from usuario u where u.id = $this->id limit 1";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->id = $registros['id'];
            $this->username = $registros['username'];
            $this->password = $registros['password'];
            $this->nombres = $registros['nombres'];
            $this->email = $registros['email'];
            $this->telefono = $registros['telefono'];
            $this->direccion = $registros['direccion'];
            $this->foto = $registros['foto'];
            $this->id_referencia = $registros['id_referencia'];
            $this->rol = $registros['Rol'];
            $this->codigo_barra = $registros['codigo_barra'];
            $this->descripcion = $registros['descripcion'];
            $this->estado = $registros['estado'];
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $registros;
    }

    public function registrar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "insert into usuario(username,password,nombres,email,telefono,direccion,Rol,descripcion,estado) values("
                . "'$this->username',MD5('$this->password'),'$this->nombres','$this->email','$this->telefono','$this->direccion',$this->rol,'$this->descripcion',$this->estado)";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function actualizar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "update usuario set username = '$this->username',nombres='$this->nombres',email='$this->email',"
                . "telefono='$this->telefono',direccion='$this->direccion',Rol=$this->rol,descripcion='$this->descripcion',estado=$this->estado"
                . " where id = $this->id";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function actualizarDatos() {
        $exito = false;
        $objDatos = new clsDatos();
        if ($this->password == "") {
            $sql = "update usuario set username = '$this->username',nombres='$this->nombres',email='$this->email',"
                    . "telefono='$this->telefono',direccion='$this->direccion',descripcion='$this->descripcion'"
                    . " where id = $this->id";
        } else {
            $sql = "update usuario set username = '$this->username',password = MD5('$this->password'),nombres='$this->nombres',email='$this->email',"
                    . "telefono='$this->telefono',direccion='$this->direccion',descripcion='$this->descripcion'"
                    . " where id = $this->id";
        }
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function eliminar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "delete from usuario where id = $this->id";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select u.id, u.nombres, u.username, r.Rol, u.estado from usuario u inner join rol r on u.Rol = r.id_rol";
        if ($datos_desordenados = $objDatos->consultar($sql)) {
            $index = 0;
            while ($row = $objDatos->registros($datos_desordenados)) {
                $lista[$index] = $row;
                $index++;
            }
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $lista;
    }

}
