<?php

require_once 'clsDatos.php';

class clsJunta {

    private $cod_junta;
    private $cod_zona;
    private $desc_junta;
    private $sector_nombre;

    function __construct() {
        $this->cod_junta = 0;
        $this->cod_zona = 0;
        $this->desc_junta = "";
        $this->sector_nombre = "";
    }

    function getCod_junta() {
        return $this->cod_junta;
    }

    function getCod_zona() {
        return $this->cod_zona;
    }

    function getDesc_junta() {
        return $this->desc_junta;
    }

    function getSector_nombre() {
        return $this->sector_nombre;
    }

    function setCod_junta($cod_junta) {
        $this->cod_junta = $cod_junta;
    }

    function setCod_zona($cod_zona) {
        $this->cod_zona = $cod_zona;
    }

    function setDesc_junta($desc_junta) {
        $this->desc_junta = $desc_junta;
    }

    function setSector_nombre($sector_nombre) {
        $this->sector_nombre = $sector_nombre;
    }

    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from junta order by SECTOR_NOMBRE";
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
    
    public function buscarXCodigo($codigo) {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "select * from junta where COD_JUNTA $codigo";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->cod_junta = $registros['COD_JUNTA'];
            $this->cod_zona = $registros['COD_ZONA'];
            $this->desc_junta = $registros['DESC_JUNTA'];
            $this->sector_nombre = $registros['SECTOR_NOMBRE'];
            $exito = true;
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $exito;
    }

}
