<?php

require_once __DIR__ . "/clsDatos.php";

class clsSocio {

    private $codigo;
    private $ci;
    private $apellido;
    private $obs;
    private $genero;
    private $cod_barra;
    private $direccion;
    private $telefono;
    private $celular;
    private $email;
    private $estado_civil;
    private $nombre_conyuge;
    private $foto;
    private $cod_usuario;
    private $fecha_actualizacion;
    private $estado;
    private $sector;
    private $tipo;

    public function __construct() {
        $this->codigo = 0;
        $this->ci = "";
        $this->apellido = "";
        $this->obs = "";
        $this->genero = "";
        $this->cod_barra = "";
        $this->direccion = "";
        $this->telefono = "";
        $this->celular = "";
        $this->email = "";
        $this->estado_civil = "";
        $this->nombre_conyuge = "";
        $this->foto = "";
        $this->cod_usuario = 0;
        $this->fecha_actualizacion = date("Y-m-d H:i:s");
        $this->estado = "";
        $this->sector = 0;
        $this->tipo = "";
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getCi() {
        return $this->ci;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getObs() {
        return $this->obs;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getCod_barra() {
        return $this->cod_barra;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getEstado_civil() {
        return $this->estado_civil;
    }

    public function getNombre_conyuge() {
        return $this->nombre_conyuge;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getCod_usuario() {
        return $this->cod_usuario;
    }

    public function getFecha_actualizacion() {
        return $this->fecha_actualizacion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getSector() {
        return $this->sector;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setCi($ci) {
        $this->ci = $ci;
    }

    public function setObs($obs) {
        $this->obs = $obs;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    public function setCod_barra($cod_barra) {
        $this->cod_barra = $cod_barra;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setEstado_civil($estado_civil) {
        $this->estado_civil = $estado_civil;
    }

    public function setNombre_conyuge($nombre_conyuge) {
        $this->nombre_conyuge = $nombre_conyuge;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setCod_usuario($cod_usuario) {
        $this->cod_usuario = $cod_usuario;
    }

    public function setFecha_actualizacion($fecha_actualizacion) {
        $this->fecha_actualizacion = $fecha_actualizacion;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setSector($sector) {
        $this->sector = $sector;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function registrar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "insert into socio(CODIGO, CI, APELLIDO, OBS, GENERO, COD_BARRA, DIRECCION, TELEFONO, CELULAR, EMAIL, ESTADO_CIVIL, NOMBRE_CONYUGE, FOTO, COD_USUARIO, FECHA_ACTUALIZACION, ESTADO, SECTOR, TIPO) values("
                . "$this->codigo, '$this->ci', '$this->apellido', '$this->obs', '$this->genero', '$this->cod_barra', '$this->direccion', '$this->telefono', '$this->celular', '$this->email', '$this->estado_civil', '$this->nombre_conyuge', '$this->foto', $this->cod_usuario, now(), '$this->estado', $this->sector, '$this->tipo');";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function actualizar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "update socio set APELLIDO = '$this->apellido', DIRECCION='$this->direccion', TELEFONO='$this->telefono', CELULAR='$this->celular',"
                . "EMAIL='$this->email', TIPO='$this->tipo', ESTADO_CIVIL='$this->estado_civil', NOMBRE_CONYUGE='$this->nombre_conyuge', "
                . "GENERO='$this->genero', OBS='$this->obs' where CODIGO='$this->codigo'";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function actualizarClave() {
        $objDatos = new clsDatos();
        $sql = "update usuario u set password = MD5('$this->ci) where u.username = '$this->ci'";
        $objDatos->ejecutar($sql);
        $objDatos->cerrarconexion();
    }

    public function eliminar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "delete from socio where CODIGO = $this->codigo";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function buscarXCedula() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "select * from socio s where s.CI = '$this->ci' limit 1";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->ci = $registros['CI'];
            $this->apellido = $registros['APELLIDO'];
            $this->obs = $registros['OBS'];
            $this->genero = $registros['GENERO'];
            $this->cod_barra = $registros['COD_BARRA'];
            $this->direccion = $registros['DIRECCION'];
            $this->telefono = $registros['TELEFONO'];
            $this->celular = $registros['CELULAR'];
            $this->email = $registros['EMAIL'];
            $this->estado_civil = $registros['ESTADO_CIVIL'];
            $this->nombre_conyuge = $registros['NOMBRE_CONYUGE'];
            $this->foto = $registros['FOTO'];
            $this->cod_usuario = $registros['COD_USUARIO'];
            $this->fecha_actualizacion = $registros['FECHA_ACTUALIZACION'];
            $this->estado = $registros['ESTADO'];
            $this->sector = $registros['ESTADO'];
            $this->tipo = $registros['TIPO'];
            $exito = true;
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $exito;
    }

    // devlueve los datos en el objeto
    public function buscarXCodigo() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "select * from socio s where s.CODIGO = $this->codigo limit 1";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->ci = $registros['CI'];
            $this->apellido = $registros['APELLIDO'];
            $this->obs = $registros['OBS'];
            $this->genero = $registros['GENERO'];
            $this->cod_barra = $registros['COD_BARRA'];
            $this->direccion = $registros['DIRECCION'];
            $this->telefono = $registros['TELEFONO'];
            $this->celular = $registros['CELULAR'];
            $this->email = $registros['EMAIL'];
            $this->estado_civil = $registros['ESTADO_CIVIL'];
            $this->nombre_conyuge = $registros['NOMBRE_CONYUGE'];
            $this->foto = $registros['FOTO'];
            $this->cod_usuario = $registros['COD_USUARIO'];
            $this->fecha_actualizacion = $registros['FECHA_ACTUALIZACION'];
            $this->estado = $registros['ESTADO'];
            $this->sector = $registros['ESTADO'];
            $this->tipo = $registros['TIPO'];
            $exito = true;
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $exito;
    }

    public function buscarXCodigoJunta($cod) {
        $lista = array();
        $objDatos = new clsDatos();
        $sql = "select s.`CODIGO`, s.`CI`, s.`APELLIDO`, s.`OBS`, s.`GENERO`, s.`COD_BARRA`, s.`DIRECCION`, s.`TELEFONO`, s.`CELULAR`, s.`EMAIL`, s.`ESTADO_CIVIL`, s.`NOMBRE_CONYUGE`, s.`FOTO`, s.`COD_USUARIO`, s.`FECHA_ACTUALIZACION`, s.`ESTADO`, s.`SECTOR`, s.`TIPO` "
                . "from socio s "
                . "inner join terreno t on s.codigo = t.codigo "
                . "inner join junta j on j.cod_junta = t.cod_junta "
                . "where j.cod_junta ".$cod;
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

    // Devuelve los datos desordenados y en el objecto
    public function buscarXCodigoJSON() {
        $objDatos = new clsDatos();
        $registros = "";
        $sql = "select * from socio s where s.CODIGO = $this->codigo limit 1";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->ci = $registros['CI'];
            $this->apellido = $registros['APELLIDO'];
            $this->obs = $registros['OBS'];
            $this->genero = $registros['GENERO'];
            $this->cod_barra = $registros['COD_BARRA'];
            $this->direccion = $registros['DIRECCION'];
            $this->telefono = $registros['TELEFONO'];
            $this->celular = $registros['CELULAR'];
            $this->email = $registros['EMAIL'];
            $this->estado_civil = $registros['ESTADO_CIVIL'];
            $this->nombre_conyuge = $registros['NOMBRE_CONYUGE'];
            $this->foto = $registros['FOTO'];
            $this->cod_usuario = $registros['COD_USUARIO'];
            $this->fecha_actualizacion = $registros['FECHA_ACTUALIZACION'];
            $this->estado = $registros['ESTADO'];
            $this->sector = $registros['ESTADO'];
            $this->tipo = $registros['TIPO'];
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $registros;
    }

    public function buscarXNombres() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "select * from socio s where s.APELLIDO like '$this->apellido%' limit 1";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->ci = $registros['CI'];
            $this->apellido = $registros['APELLIDO'];
            $this->obs = $registros['OBS'];
            $this->genero = $registros['GENERO'];
            $this->cod_barra = $registros['COD_BARRA'];
            $this->direccion = $registros['DIRECCION'];
            $this->telefono = $registros['TELEFONO'];
            $this->celular = $registros['CELULAR'];
            $this->email = $registros['EMAIL'];
            $this->estado_civil = $registros['ESTADO_CIVIL'];
            $this->nombre_conyuge = $registros['NOMBRE_CONYUGE'];
            $this->foto = $registros['FOTO'];
            $this->cod_usuario = $registros['COD_USUARIO'];
            $this->fecha_actualizacion = $registros['FECHA_ACTUALIZACION'];
            $this->estado = $registros['ESTADO'];
            $this->sector = $registros['ESTADO'];
            $this->tipo = $registros['TIPO'];
            $exito = true;
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $exito;
    }

    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from socio";
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

    public function buscarTodosConTerreno() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from socio";
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

    public function contar() {
        $objDatos = new clsDatos();
        $sql = "select count(*) from socio";
        $dato_desordenado = $objDatos->consultar($sql);
        $num = $objDatos->registros($dato_desordenado);
        return $num[0];
    }

    public function buscarXNumTerreno($numTerreno) {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "select s.CODIGO, s.CI, s.APELLIDO, s.OBS, s.GENERO, s.COD_BARRA, s.DIRECCION, s.TELEFONO, s.CELULAR, s.EMAIL, s.ESTADO_CIVIL,"
                . "s.NOMBRE_CONYUGE, s.FOTO, s.COD_USUARIO, s.FECHA_ACTUALIZACION, s.ESTADO, s.SECTOR, s.TIPO "
                . "from socio s inner join terreno t on s.CODIGO = t.CODIGO where t.NUM_TERRENO = " . $numTerreno;
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->codigo = $registros['CODIGO'];
            $this->ci = $registros['CI'];
            $this->apellido = $registros['APELLIDO'];
            $this->obs = $registros['OBS'];
            $this->genero = $registros['GENERO'];
            $this->cod_barra = $registros['COD_BARRA'];
            $this->direccion = $registros['DIRECCION'];
            $this->telefono = $registros['TELEFONO'];
            $this->celular = $registros['CELULAR'];
            $this->email = $registros['EMAIL'];
            $this->estado_civil = $registros['ESTADO_CIVIL'];
            $this->nombre_conyuge = $registros['NOMBRE_CONYUGE'];
            $this->foto = $registros['FOTO'];
            $this->cod_usuario = $registros['COD_USUARIO'];
            $this->fecha_actualizacion = $registros['FECHA_ACTUALIZACION'];
            $this->estado = $registros['ESTADO'];
            $this->sector = $registros['SECTOR'];
            $this->tipo = $registros['TIPO'];
            $exito = true;
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $exito;
    }

}
