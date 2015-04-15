<?php

require_once __DIR__ . "/clsDatos.php";

class clsCultivo {

    private $cod_cult;
    private $nombre;
    private $ciclo;
    private $inicio_de_cosecha;
    private $tipo_cultivo;
    private $detalles;
    private $observacion;
    private $cod_usuario;
    private $fecha_actualizacion;

    public function __construct() {
        $this->cod_cult = 0;
        $this->nombre = "";
        $this->ciclo = 0;
        $this->inicio_de_cosecha = 0;
        $this->tipo_cultivo = 0;
        $this->detalles = "";
        $this->observacion = "";
        $this->cod_usuario = 0;
        $this->fecha_actualizacion = date("Y-m-d H:i:s");
    }

    public function getCod_cult() {
        return $this->cod_cult;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCiclo() {
        return $this->ciclo;
    }

    public function getInicio_de_cosecha() {
        return $this->inicio_de_cosecha;
    }

    public function getTipo_cultivo() {
        return $this->tipo_cultivo;
    }

    public function getDetalles() {
        return $this->detalles;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function getCod_usuario() {
        return $this->cod_usuario;
    }

    public function getFecha_actualizacion() {
        return $this->fecha_actualizacion;
    }

    public function setCod_cult($cod_cult) {
        $this->cod_cult = $cod_cult;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setCiclo($ciclo) {
        $this->ciclo = $ciclo;
    }

    public function setInicio_de_cosecha($inicio_de_cosecha) {
        $this->inicio_de_cosecha = $inicio_de_cosecha;
    }

    public function setTipo_cultivo($tipo_cultivo) {
        $this->tipo_cultivo = $tipo_cultivo;
    }

    public function setDetalles($detalles) {
        $this->detalles = $detalles;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function setCod_usuario($cod_usuario) {
        $this->cod_usuario = $cod_usuario;
    }

    public function setFecha_actualizacion($fecha_actualizacion) {
        $this->fecha_actualizacion = $fecha_actualizacion;
    }

    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from cultivo";
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
