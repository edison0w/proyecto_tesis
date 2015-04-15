<?php

require_once 'clsDatos.php';

class clsModulo {

    private $cod_modulo;
    private $cod_toma;
    private $desc_modulo;

    function __construct() {
        $this->cod_modulo = 0;
        $this->cod_toma = 0;
        $this->desc_modulo = "";
    }

    function getCod_modulo() {
        return $this->cod_modulo;
    }

    function getCod_toma() {
        return $this->cod_toma;
    }

    function getDesc_modulo() {
        return $this->desc_modulo;
    }

    function setCod_modulo($cod_modulo) {
        $this->cod_modulo = $cod_modulo;
    }

    function setCod_toma($cod_toma) {
        $this->cod_toma = $cod_toma;
    }

    function setDesc_modulo($desc_modulo) {
        $this->desc_modulo = $desc_modulo;
    }

    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from modulo";
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
