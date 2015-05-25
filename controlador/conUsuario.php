<?php

require __DIR__ . '/../modelo/clsUsuario.php';
require __DIR__ . '/../modelo/clsRol.php';
require __DIR__ . '/../modelo/clsSocio.php';
require __DIR__ . '/../modelo/clsTerreno.php';
require __DIR__ . '/../modelo/clsCultivo.php';
session_start();

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$array_ini = parse_ini_file("../recursos/properties.ini");

$objUsuario = new clsUsuario();
$objRol = new clsRol();

//login
if ($_POST['operacion'] == 'acceder') {
    $usuario = $_POST['txtUsuario'];
    $clave = $_POST['txtClave'];
    if ($objUsuario->autenticar($usuario, $clave)) {
        $objRol->buscarXCodigo($objUsuario->getRol());
        if ($objRol->getRol() != "") {
            $_SESSION['usuario'] = $objUsuario; // Usuario que se logea
            $_SESSION['rol'] = $objRol; // Rol del usuario 
            $_SESSION['socio'] = new clsSocio(); // Socios
            $_SESSION['terreno'] = new clsTerreno(); // Terrenos
            $_SESSION['cultivo'] = new clsCultivo(); // Cultivos
            $_SESSION['usu'] = new clsUsuario();

            // Varibales del menu
            $_SESSION['mSocio'] = "";
            $_SESSION['mTerreno'] = "";
            $_SESSION['mCultivo'] = "";
            echo "principal.php";
        } else {
            echo "No existe un Perfil";
        }
    } else {
        echo "Usuario o contraseña incorrecta";
    }
}

if ($_POST['operacion'] == "registrar") {
    $objUsuario->setUsername($_POST['txtUsuario']);
    $objUsuario->setPassword($_POST['txtClave']);
    $objUsuario->setNombres($_POST['txtNombres']);
    $objUsuario->setEmail($_POST['txtEmail']);
    $objUsuario->setTelefono($_POST['txtTelefono']);
    $objUsuario->setDireccion($_POST['txtDireccion']);
    $objUsuario->setRol($_POST['txtPerfil']);
    $objUsuario->setDescripcion($_POST['txtDescripcion']);
    $objUsuario->setEstado($_POST['txtEstado']);
    if ($objUsuario->registrar()) {
        echo "todos.php";
    } else {
        echo "No se pudo ingresar al usuario";
    }
}

if ($_POST['operacion'] == "buscar") {
    $objUsuario->setId($_POST['txtIdUsuario']);
    $datos = $objUsuario->buscarXCodigoJSON();
    echo json_encode($datos);
}

if ($_POST['operacion'] == "actualizar") {

    $objUsuario->setId($_POST['txtId']);
    $objUsuario->setUsername($_POST['txtUsuario']);
    //if ($_POST['txtClave'] != "") {
      //  $objUsuario->setPassword($_POST['txtClave']);
    //} else {
        //$objUsuario->setPassword("");
    //}
    $objUsuario->setNombres($_POST['txtNombres']);
    $objUsuario->setEmail($_POST['txtEmail']);
    $objUsuario->setTelefono($_POST['txtTelefono']);
    $objUsuario->setDireccion($_POST['txtDireccion']);
    $objUsuario->setRol($_POST['txtPerfil']);
    $objUsuario->setDescripcion($_POST['txtDescripcion']);
    $objUsuario->setEstado($_POST['txtEstado']);

    if ($objUsuario->actualizar()) {
        echo "Usuario actualizado correctamente";
    } else {
        echo "El usuario no se pudo actualizar";
    }
}

if ($_POST['operacion'] == "actualizarDatos") {

    $objUsuario->setId($_POST['txtId']);
    $objUsuario->setUsername($_POST['txtUsuario']);
    if ($_POST['txtClave'] != "") {
        $objUsuario->setPassword($_POST['txtClave']);
    } else {
        $objUsuario->setPassword("");
    }
    $objUsuario->setNombres($_POST['txtNombres']);
    $objUsuario->setEmail($_POST['txtEmail']);
    $objUsuario->setTelefono($_POST['txtTelefono']);
    $objUsuario->setDireccion($_POST['txtDireccion']);
    //$objUsuario->setDescripcion($_POST['txtDescripcion']);

    if ($objUsuario->actualizarDatos()) {
        echo "Usuario actualizado correctamente";
    } else {
        echo "El usuario no se pudo actualizar";
    }
}

if ($_POST['operacion'] == "eliminar") {

    $objUsuario->setId($_POST['txtIdUsuario']);
    if ($objUsuario->eliminar()) {
        echo "Usuario eliminado correctamente";
    } else {
        echo "No se pudo eliminar el Usuario";
    }
}

if ($_POST['operacion'] == "traspaso") {
    $objUsuario->setId($_POST['txtIdUsuario']);
    // Usuario que pueden acceder al sistema
    $_SESSION['usu'] = $objUsuario;
}

