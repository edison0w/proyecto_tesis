<?php

require_once 'clsDatos.php';

class clsValvula {

    private $cod_valvula;
    private $cod_reservorio;
    private $desc_valvula;

    function __construct() {
        $this->cod_valvula = 0;
        $this->cod_reservorio = 0;
        $this->desc_valvula = "";
    }

    function getCod_valvula() {
        return $this->cod_valvula;
    }

    function getCod_reservorio() {
        return $this->cod_reservorio;
    }

    function getDesc_valvula() {
        return $this->desc_valvula;
    }

    function setCod_valvula($cod_valvula) {
        $this->cod_valvula = $cod_valvula;
    }

    function setCod_reservorio($cod_reservorio) {
        $this->cod_reservorio = $cod_reservorio;
    }

    function setDesc_valvula($desc_valvula) {
        $this->desc_valvula = $desc_valvula;
    }

    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from valvula";
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
