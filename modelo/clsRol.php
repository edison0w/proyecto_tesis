<?php

require_once 'clsDatos.php';

class clsRol {

    private $id_rol;
    private $rol;

    public function __construct() {
        $this->id_rol = "";
        $this->rol = "";
    }
    public function getId_rol() {
        return $this->id_rol;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setId_rol($id_rol) {
        $this->id_rol = $id_rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function buscarXCodigo($id){
        $exito = false;
        $objDatos = new clsDatos();
        $sql = "select * from rol r where r.id_rol = $id limit 1";
        $datos_desordenados = $objDatos->consultar($sql);
        if ($registros = $objDatos->registros($datos_desordenados)) {
            $this->id_rol = $registros['id_rol'];
            $this->rol = $registros['Rol'];
            $exito = true;
        }
        $objDatos->cerrarConsulta($datos_desordenados);
        $objDatos->cerrarConexion();
        return $exito;
    }
    
    public function buscarTodos() {
        $objDatos = new clsDatos();
        $lista = array();
        $sql = "select * from rol";
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
