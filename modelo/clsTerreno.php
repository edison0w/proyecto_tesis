<?php

require_once __DIR__ . "/clsDatos.php";

class clsTerreno {

    private $num_terreno;
    private $cod_catastral;
    private $codigo;        //socio
    private $cod_junta;
    private $cod_valvula;
    private $cod_modulo;
    private $area;
    private $areas;
    private $arean;
    private $obs;
    private $estado;
    private $clav_predial;
    private $area_total;
    private $plano;
    private $escala;
    private $cond_juridica;
    private $nombre;
    private $codigo_provicional;
    private $hoja_campo;
    private $cod_usuario;       // codigo del usuario que le registro
    private $fecha_actualizacion;

    function __construct() {
        $this->num_terreno = 0;
        $this->cod_catastral = "";
        $this->codigo = 0;
        $this->cod_junta = 0;
        $this->cod_valvula = 0;
        $this->cod_modulo = 0;
        $this->area = 0.0;
        $this->areas = 0.0;
        $this->arean = 0.0;
        $this->obs = "";
        $this->estado = "";
        $this->clav_predial = "";
        $this->area_total = 0.0;
        $this->plano = "";
        $this->escala = "";
        $this->cond_juridica = "";
        $this->nombre = "";
        $this->codigo_provicional = 0;
        $this->hoja_campo = "";
        $this->cod_usuario = 0;
        $this->fecha_actualizacion = date("Y-m-d H:i:s");
    }

    function getNum_terreno() {
        return $this->num_terreno;
    }

    function getCod_catastral() {
        return $this->cod_catastral;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getCod_junta() {
        return $this->cod_junta;
    }

    function getCod_valvula() {
        return $this->cod_valvula;
    }

    function getCod_modulo() {
        return $this->cod_modulo;
    }

    function getArea() {
        return $this->area;
    }

    function getAreas() {
        return $this->areas;
    }

    function getArean() {
        return $this->arean;
    }

    function getObs() {
        return $this->obs;
    }

    function getEstado() {
        return $this->estado;
    }

    function getClav_predial() {
        return $this->clav_predial;
    }

    function getArea_total() {
        return $this->area_total;
    }

    function getPlano() {
        return $this->plano;
    }

    function getEscala() {
        return $this->escala;
    }

    function getCond_juridica() {
        return $this->cond_juridica;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodigo_provicional() {
        return $this->codigo_provicional;
    }

    function getHoja_campo() {
        return $this->hoja_campo;
    }

    function getCod_usuario() {
        return $this->cod_usuario;
    }

    function getFecha_actualizacion() {
        return $this->fecha_actualizacion;
    }

    function setNum_terreno($num_terreno) {
        $this->num_terreno = $num_terreno;
    }

    function setCod_catastral($cod_catastral) {
        $this->cod_catastral = $cod_catastral;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCod_junta($cod_junta) {
        $this->cod_junta = $cod_junta;
    }

    function setCod_valvula($cod_valvula) {
        $this->cod_valvula = $cod_valvula;
    }

    function setCod_modulo($cod_modulo) {
        $this->cod_modulo = $cod_modulo;
    }

    function setArea($area) {
        $this->area = $area;
    }

    function setAreas($areas) {
        $this->areas = $areas;
    }

    function setArean($arean) {
        $this->arean = $arean;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setClav_predial($clav_predial) {
        $this->clav_predial = $clav_predial;
    }

    function setArea_total($area_total) {
        $this->area_total = $area_total;
    }

    function setPlano($plano) {
        $this->plano = $plano;
    }

    function setEscala($escala) {
        $this->escala = $escala;
    }

    function setCond_juridica($cond_juridica) {
        $this->cond_juridica = $cond_juridica;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodigo_provicional($codigo_provicional) {
        $this->codigo_provicional = $codigo_provicional;
    }

    function setHoja_campo($hoja_campo) {
        $this->hoja_campo = $hoja_campo;
    }

    function setCod_usuario($cod_usuario) {
        $this->cod_usuario = $cod_usuario;
    }

    function setFecha_actualizacion($fecha_actualizacion) {
        $this->fecha_actualizacion = $fecha_actualizacion;
    }

    public function registrar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "insert into terreno(CODIGO, COD_CATASTRAL, CLAV_PREDIAL, AREA, AREAS, AREAN, COND_JURIDICA, CODIGO_PROVISIONAL, COD_JUNTA, COD_VALVULA, COD_MODULO, OBS) values("
                . "$this->codigo, '$this->cod_catastral', '$this->clav_predial', $this->area, $this->areas, $this->arean, '$this->cond_juridica', $this->codigo_provicional, $this->cod_junta, $this->cod_valvula, $this->cod_modulo, '$this->obs')";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function actualizar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "update terreno set COD_CATASTRAL = '$this->cod_catastral', CLAV_PREDIAL='$this->clav_predial', AREA=$this->area, "
                . "AREAS=$this->areas, AREAN=$this->arean, COND_JURIDICA='$this->cond_juridica', CODIGO_PROVISIONAL=$this->codigo_provicional, "
                . "COD_JUNTA=$this->cod_junta, COD_VALVULA=$this->cod_valvula, COD_MODULO=$this->cod_modulo , OBS='$this->obs' "
                . "where NUM_TERRENO=$this->codigo";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }

    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from terreno";
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
    
    

    public function eliminar() {
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "delete from terreno where NUM_TERRENO = $this->num_terreno";
        if ($objDatos->ejecutar($sql)) {
            $exito = true;
        }
        $objDatos->cerrarconexion();
        return $exito;
    }
    
    public function buscarXNumTerreneo() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from terreno t where t.NUM_TERRENO=$this->num_terreno";
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

    public function buscarXSocio($codigo) {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from terreno t where t.CODIGO=$codigo";
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

    public function buscarTodosSocioTerrenos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select t.NUM_TERRENO, s.CI, s.APELLIDO from socio s inner join terreno t on s.CODIGO = t.CODIGO";
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

    public function buscarXNumTerrenoJSON() {
        $objDatos = new clsDatos();
        $registros = "";
        $sql = "select t.NUM_TERRENO, t.COD_CATASTRAL, t.CODIGO, t.COD_JUNTA, t.COD_VALVULA, t.COD_MODULO, t.AREA, t.AREAS, t.AREAN, "
                . "t.OBS, t.ESTADO, t.CLAV_PREDIAL, t.AREA_TOTAL, t.PLANO, t.ESCALA, t.COND_JURIDICA, t.NOMBRE, t.CODIGO_PROVISIONAL, "
                . "t.HOJA_CAMPO, t.COD_USUARIO, t.FECHA_ACTUALIZACION, s.CI, s.APELLIDO from terreno t inner join socio s "
                . "on s.CODIGO = t.CODIGO where t.NUM_TERRENO = $this->num_terreno limit 1";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->num_terreno = $registros['NUM_TERRENO'];
            $this->cod_catastral = $registros['COD_CATASTRAL'];
            $this->codigo = $registros['CODIGO'];
            $this->cod_junta = $registros['COD_JUNTA'];
            $this->cod_valvula = $registros['COD_VALVULA'];
            $this->cod_modulo = $registros['COD_MODULO'];
            $this->area = $registros['AREA'];
            $this->areas = $registros['AREAS'];
            $this->arean = $registros['AREAN'];
            $this->obs = $registros['OBS'];
            $this->estado = $registros['ESTADO'];
            $this->clav_predial = $registros['CLAV_PREDIAL'];
            $this->area_total = $registros['AREA_TOTAL'];
            $this->plano = $registros['PLANO'];
            $this->escala = $registros['ESCALA'];
            $this->cond_juridica = $registros['COND_JURIDICA'];
            $this->nombre = $registros['NOMBRE'];
            $this->codigo_provicional = $registros['CODIGO_PROVISIONAL'];
            $this->hoja_campo = $registros['HOJA_CAMPO'];
            $this->cod_usuario = $registros['COD_USUARIO'];
            $this->fecha_actualizacion = $registros['FECHA_ACTUALIZACION'];
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $registros;
    }
    

}
