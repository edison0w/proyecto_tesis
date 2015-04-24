<?php
require __DIR__ . "/modelo/clsUsuario.php";
require __DIR__ . "/modelo/clsRol.php";
session_start();
$_SESSION['mSocio'] = "";
$_SESSION['mTerreno'] = "";
$_SESSION['mCultivo'] = "";
$array_ini = parse_ini_file("/recursos/properties.ini");
$direccion = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $array_ini['sistema'] ?></title>
        <!-- recursos CSS -->
        <link href="recursos/css/misEstilos.css" rel="stylesheet" type="text/css"/>
        <!-- recursos javascript -->
        <script src="recursos/js/miJavaScript.js" type="text/javascript"></script>
    </head>
    <body id="windows_background">
        <?php include __DIR__ . '/recursos/inc/menu.php'; ?>
        <?php include __DIR__ . '/recursos/inc/informacion.php'; ?>
        <?php include __DIR__ . '/recursos/inc/pie.php'; ?>
    </body>
</html>
