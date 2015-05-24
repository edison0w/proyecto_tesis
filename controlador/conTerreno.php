<?php

require __DIR__ . "/../modelo/clsTerreno.php";
require __DIR__ . "/../modelo/clsSocio.php";
session_start();

$objTerreno = new clsTerreno();

if ($_POST['operacion'] == "registrar") {

    $objTerreno->setCodigo($_POST['txtCodigo']);
    $objTerreno->setCod_catastral($_POST['txtCodCatastral']);
    $objTerreno->setClav_predial($_POST['txtCodPredial']);
    $objTerreno->setArea($_POST['txtAreaRiego']);
    $objTerreno->setAreas($_POST['txtAreaSusceptible']);
    $objTerreno->setArean($_POST['txtAreaNoSusceptible']);
    $objTerreno->setCond_juridica($_POST['txtCondJuridica']);
    $objTerreno->setCodigo_provicional($_POST['txtCodProvisional']);
    $objTerreno->setCod_junta($_POST['txtJunta']);
    $objTerreno->setCod_valvula($_POST['txtValvula']);
    $objTerreno->setCod_modulo($_POST['txtModulo']);
    $objTerreno->setObs($_POST['txtObservacion']);

    if ($objTerreno->registrar()) {
        echo "todos.php";
    } else {
        echo "No se pudo ingresar el terreno";
    }
}

if ($_POST['operacion'] == "actualizar") {

    $objTerreno->setCodigo($_POST['txtCodigo']);
    $objTerreno->setCod_catastral($_POST['txtCodCatastral']);
    $objTerreno->setClav_predial($_POST['txtCodPredial']);
    $objTerreno->setArea($_POST['txtAreaRiego']);
    $objTerreno->setAreas($_POST['txtAreaSusceptible']);
    $objTerreno->setArean($_POST['txtAreaNoSusceptible']);
    $objTerreno->setCond_juridica($_POST['txtCondJuridica']);
    $objTerreno->setCodigo_provicional($_POST['txtCodProvisional']);
    $objTerreno->setCod_junta($_POST['txtJunta']);
    $objTerreno->setCod_valvula($_POST['txtValvula']);
    $objTerreno->setCod_modulo($_POST['txtModulo']);
    $objTerreno->setObs($_POST['txtObservacion']);

    if ($objTerreno->actualizar()) {
        echo "Terreno actualizado correctamente";
    } else {
        echo "No se pudo actualizar el terreno";
    }
}

if ($_POST['operacion'] == "eliminar") {

    $objTerreno->setNum_terreno($_POST['txtNumTerreno']);

    if ($objTerreno->eliminar()) {
        $_SESSION['terreno'] = new clsTerreno();
        echo "Terreno eliminado correctamente";
    } else {
        $_SESSION['terreno'] = new clsTerreno();
        echo "No se pudo eliminar el terreno";
    }
}

if ($_POST['operacion'] == "buscar") {
    $objTerreno->setNum_terreno($_POST['txtNumTerreno']);
    $datos = $objTerreno->buscarXNumTerrenoJSON();
    $_SESSION['terreno'] = $objTerreno;
    echo json_encode($datos);
}

if ($_POST['operacion'] == "traspaso") {
    $objTerreno->setNum_terreno($_POST['txtNumTerreno']);
    $_SESSION['terreno'] = $objTerreno;
    $objSocio = new clsSocio();
    $objSocio->buscarXNumTerreno($objTerreno->getNum_terreno());
    $_SESSION['socio'] = $objSocio;
}

if ($_POST['operacion'] == "nuevo") {
    $objTerreno->setNum_terreno($_POST['txtNumTerreno']);
    $objTerreno->buscarXNumTerreneo();
    $_SESSION['terreno'] = $objTerreno;
}