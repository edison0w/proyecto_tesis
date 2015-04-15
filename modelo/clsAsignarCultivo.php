<?php

require_once __DIR__ . "/clsDatos.php";

class clsAsignarCultivo {

    private $numero; //auto incremental
    private $num_terreno; //numero de terreno
    private $cod_cultivo;  // codigo de cultivo
    private $porcentaje;
    private $area;
    private $fecha_regitro;
    private $edad_al_registro;
    private $edad_actual;
    private $inicio_cosecha;
    private $observacion;
    private $estado;
    private $cod_usuario;
    private $fecha_actualizacion;
    private $tipo_riego;

    public function __construct() {
        $this->numero = 0;
        $this->num_terreno = 0;
        $this->cod_cultivo = 0;
        $this->porcentaje = 0;
        $this->area = 0.0;
        $this->fecha_regitro = date("Y-m-d H:i:s");
        $this->edad_al_registro = 0;
        $this->edad_actual = 0;
        $this->inicio_cosecha = 0;
        $this->observacion = "";
        $this->estado = "";
        $this->cod_usuario = 0;
        $this->fecha_actualizacion = date("H:i:s");
        ;
        $this->tipo_riego = "";
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getNum_terreno() {
        return $this->num_terreno;
    }

    public function getCod_cultivo() {
        return $this->cod_cultivo;
    }

    public function getPorcentaje() {
        return $this->porcentaje;
    }

    public function getArea() {
        return $this->area;
    }

    public function getFecha_regitro() {
        return $this->fecha_regitro;
    }

    public function getEdad_al_registro() {
        return $this->edad_al_registro;
    }

    public function getEdad_actual() {
        return $this->edad_actual;
    }

    public function getInicio_cosecha() {
        return $this->inicio_cosecha;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCod_usuario() {
        return $this->cod_usuario;
    }

    public function getFecha_actualizacion() {
        return $this->fecha_actualizacion;
    }

    public function getTipo_riego() {
        return $this->tipo_riego;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setNum_terreno($num_terreno) {
        $this->num_terreno = $num_terreno;
    }

    public function setCod_cultivo($cod_cultivo) {
        $this->cod_cultivo = $cod_cultivo;
    }

    public function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setFecha_regitro($fecha_regitro) {
        $this->fecha_regitro = $fecha_regitro;
    }

    public function setEdad_al_registro($edad_al_registro) {
        $this->edad_al_registro = $edad_al_registro;
    }

    public function setEdad_actual($edad_actual) {
        $this->edad_actual = $edad_actual;
    }

    public function setInicio_cosecha($inicio_cosecha) {
        $this->inicio_cosecha = $inicio_cosecha;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCod_usuario($cod_usuario) {
        $this->cod_usuario = $cod_usuario;
    }

    public function setFecha_actualizacion($fecha_actualizacion) {
        $this->fecha_actualizacion = $fecha_actualizacion;
    }

    public function setTipo_riego($tipo_riego) {
        $this->tipo_riego = $tipo_riego;
    }
    
    public function registrar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "insert into asignar_cultivo(NUM_TERRENO, COD_CULT, PORCENTAJE, AREA, FECHA_REGISTRO, EDAD_AL_REGISTRO, EDAD_ACTUAL, INICIA_COSECHA, OBSERVACION, ESTADO, COD_USUARIO, FECHA_ACTUALIZACION, TIPO_RIEGO) values("
                . "$this->num_terreno, $this->cod_cultivo, $this->porcentaje, $this->area, now(), $this->edad_al_registro, $this->edad_actual, $this->inicio_cosecha, '$this->observacion', $this->estado, $this->cod_usuario, now(), '$this->tipo_riego')";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }
    
    public function eliminar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "delete from asignar_cultivo where NUMERO = $this->numero";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select ac.NUMERO, ac.NUM_TERRENO, ac.COD_CULT, ac.PORCENTAJE, ac.AREA, ac.FECHA_REGISTRO, ac.EDAD_AL_REGISTRO, "
                . "ac.EDAD_ACTUAL, ac.INICIA_COSECHA, ac.OBSERVACION, ac.ESTADO, ac.COD_USUARIO, ac.FECHA_ACTUALIZACION, "
                . "ac.TIPO_RIEGO, c.NOMBRE from asignar_cultivo ac inner join cultivo c on ac.COD_CULT = c.COD_CULT";
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
    
    public function buscarXTerreno($codigo) {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select ac.NUMERO, ac.NUM_TERRENO, ac.COD_CULT, ac.PORCENTAJE, ac.AREA, ac.FECHA_REGISTRO, ac.EDAD_AL_REGISTRO, "
                . "ac.EDAD_ACTUAL, ac.INICIA_COSECHA, ac.OBSERVACION, ac.ESTADO, ac.COD_USUARIO, ac.FECHA_ACTUALIZACION, "
                . "ac.TIPO_RIEGO, c.NOMBRE from asignar_cultivo ac inner join cultivo c on ac.COD_CULT = c.COD_CULT "
                . "where ac.NUM_TERRENO=$codigo";
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
