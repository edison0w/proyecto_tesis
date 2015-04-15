<?php

require __DIR__ . "/../modelo/clsSocio.php";
require __DIR__ . "/../modelo/clsUsuario.php";
session_start();

$objSocio = new clsSocio();

if ($_POST['operacion'] == "registrar") {

    $objSocio->setCi($_POST['txtCedula']);
    $objSocio->setApellido($_POST['txtApellidos']);
    $objSocio->setDireccion($_POST['txtDireccion']);
    $objSocio->setTelefono($_POST['txtTelefono']);
    $objSocio->setCelular($_POST['txtCelular']);
    $objSocio->setEmail($_POST['txtEmail']);
    $objSocio->setCod_usuario($_SESSION['usuario']->getId());
    $objSocio->setTipo($_POST['txtTipoPersona']);
    $objSocio->setEstado_civil($_POST['txtEstadoCivil']);
    $objSocio->setNombre_conyuge($_POST['txtConyuge']);
    $objSocio->setGenero($_POST['txtGenero']);
    $objSocio->setObs($_POST['txtObservacion']);

    if ($objSocio->registrar()) {
        $objSocio->actualizarClave();
        echo "todos.php";
    } else {
        echo "No se pudo ingresar al socio";
    }
}

if ($_POST['operacion'] == "actualizar") {

    $objSocio->setCodigo($_POST['txtCodigo']);
    $objSocio->setCi($_POST['txtCedula']);
    $objSocio->setApellido($_POST['txtApellidos']);
    $objSocio->setDireccion($_POST['txtDireccion']);
    $objSocio->setTelefono($_POST['txtTelefono']);
    $objSocio->setCelular($_POST['txtCelular']);
    $objSocio->setEmail($_POST['txtEmail']);
    $objSocio->setTipo($_POST['txtTipoPersona']);
    $objSocio->setEstado_civil($_POST['txtEstadoCivil']);
    $objSocio->setNombre_conyuge($_POST['txtConyuge']);
    $objSocio->setGenero($_POST['txtGenero']);
    $objSocio->setObs($_POST['txtObservacion']);

    if ($objSocio->actualizar()) {
        $_SESSION['socio'] = $objSocio;
        echo "Socio actualizado correctamente";
    } else {
        echo "El socio no se pudo actualizar";
    }
}

if ($_POST['operacion'] == "buscar") {
    $objSocio->setCodigo($_POST['txtCodigo']);
    $datos = $objSocio->buscarXCodigoJSON();
    $_SESSION['socio'] = $objSocio;
    echo json_encode($datos);
}

if ($_POST['operacion'] == "traspaso") {
    $objSocio->setCodigo($_POST['txtCodSocio']);
    $_SESSION['socio'] = $objSocio;
}

if ($_POST['operacion'] == "nuevo") {
    $objSocio->setCodigo($_POST['txtCodSocio']);
    $objSocio->buscarXCodigo();
    $_SESSION['socio'] = $objSocio;
}


if ($_POST['operacion'] == "eliminar") {

    $objSocio->setCodigo($_POST['txtCodSocio']);

    if ($objSocio->eliminar()) {
        $_SESSION['socio'] = new clsSocio();
        echo "Socio eliminado correctamente";
    } else {
        $_SESSION['socio'] = new clsSocio();
        echo "No se pudo eliminar al socio";
    }
}

if ($_POST['operacion'] == "resetear") {
    $objSocio = new clsSocio();
    $_SESSION['socio'] = $objSocio;
}


