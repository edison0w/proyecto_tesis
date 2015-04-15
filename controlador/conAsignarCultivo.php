<?php

require __DIR__ . "/../modelo/clsTerreno.php";
require __DIR__ . "/../modelo/clsSocio.php";
require __DIR__ . "/../modelo/clsAsignarCultivo.php";
session_start();

$objAsignarCultivo = new clsAsignarCultivo();

if ($_POST['operacion'] == "registrar") {

    $objAsignarCultivo->setNum_terreno($_POST['txtNumTerreno']);
    $objAsignarCultivo->setCod_cultivo($_POST['txtCodCultivo']);
    $objAsignarCultivo->setPorcentaje($_POST['txtPorcentaje']);
    $objAsignarCultivo->setFecha_regitro($_POST['txtFechaRegistro']);
    $objAsignarCultivo->setEdad_al_registro($_POST['txtEdadAlRegistro']);
    $objAsignarCultivo->setTipo_riego($_POST['txtTipoRiego']);
    $objAsignarCultivo->setObservacion($_POST['txtObs']);
    $objAsignarCultivo->setEstado(true);
    if ($objAsignarCultivo->registrar()) {
        echo "todos.php";
    } else {
        echo "No se pudo ingresar el cultivo";
    }
}

if ($_POST['operacion'] == "eliminar") {
    $objAsignarCultivo->setNumero($_POST['txtNumero']);

    if ($objAsignarCultivo->eliminar()) {
        echo "Cultivo eliminado correctamente";
    } else {
        echo "No se pudo eliminar el cultivo";
    }
}

if ($_POST['operacion'] == "buscar") {
    $objTerreno = new clsTerreno();
    $objTerreno->setNum_terreno($_POST['txtNumTerreno']);
    $datos = $objTerreno->buscarXNumTerrenoJSON();
    $_SESSION['terreno'] = $objTerreno;
    echo json_encode($datos);
}