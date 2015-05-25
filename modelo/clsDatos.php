<?php

class clsDatos {

    private $conexion;

    public function __construct() {
//        $servidor = "201.218.45.188";
//        $usuario = "evilla";
//        $clave = "Passw0rd";
//        $base = "jurech_tesis";
        $servidor = "localhost";
        $usuario = "root";
        $clave = "";
        $base = "jurechgis";
        $this->conexion = mysqli_connect($servidor, $usuario, $clave, $base);
    }

    public function __destruct() {
        
    }

    // utilizada para devolver datos de la bd
    public function consultar($sql) {
        $result = mysqli_query($this->conexion, $sql);
        return $result;
    }

    // cierra una consulta resultado
    public function cerrarConsulta($datos) {
        mysqli_free_result($datos);
    }

    //devuelve el primer registro y el puntero va al siguiente registro
    // primero ejecutar un mysql_query()
    public function registros($datos) {
        $arreglo = mysqli_fetch_array($datos);
        return $arreglo;
    }

    // utilizada para insertar, actualizar y eliminar
    public function ejecutar($sql) {
        return mysqli_query( $this->conexion, $sql);
    }

    // cierra la conexion
    public function cerrarConexion() {
        mysqli_close($this->conexion);
    }

}
