<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../modelo/clsJunta.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
$array_ini = parse_ini_file("../../recursos/properties.ini");
$direccion = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'];

$objJunta = new clsJunta();
$datosJunta = $objJunta->buscarTodos();
$optionsJunta = optionsJunta($datosJunta);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $array_ini['sistema'] ?></title>
        <!-- recursos CSS -->
        <link href="../../recursos/css/misEstilos.css" rel="stylesheet" type="text/css"/>
        <!-- recursos javascript -->
        <script src="../../recursos/js/miJavaScript.js" type="text/javascript"></script>
        <script>
            function inicializar() {
                var codigo = document.getElementById('txtCodigo');
                if (codigo.value != 0) {
                    activarBotones();
                }
            }
        </script>
    </head>
    <body onload="inicializar()">
        <?php include __DIR__ . '/../../recursos/inc/menu.php'; ?>

        <div id="margen-top" class="container">

            <!-- Titulo del Formulario-->
            <div id="text_color_accent" class="row">
                <div class="col-xs-12">
                    <?php echo $array_ini['generarReporte'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
            </div>

            <!-- Formulario de Registro -->
            <form method="POST" action="../../controlador/conReporte.php">
                <div class="row">

                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="txtPerfil" class="hidden-xs">
                                <?php echo $array_ini['juntalocal'] ?>
                            </label>
                            <select id="txtJunta" name="txtJunta" class="selectpicker form-control" data-width="125%">
                                <?php echo $optionsJunta ?>
                            </select>
                        </div>
                    </div> 

                </div> <!-- ./row -->

                <!-- Barra de Navegacion Izquierda-->
                <div class="row hidden-xs hidden-sm">
                    <div class="container">
                        <button id="btnGenerar" name="operacion" value="pdf" type="submit" class="btn btn-danger"
                                disabled="true">
                            <div class="glyphicon glyphicon-ok"></div>
                            <?php echo $array_ini['generar'] ?>
                        </button>
                    </div>
                </div>

                <!-- Barra de Navegacion inferior -->
                <div class="navbar-inverse navbar-fixed-bottom visible-xs visible-sm">
                    <div class="row">
                        <div class="col-xs-6 text-center">
                            <button type="button" class="btn btn-link" onclick="javascript:history.go(-1)">
                                <img src="../../recursos/img/ic_action_back.png" />
                            </button>
                        </div>
                        <div class="col-xs-6 text-center">
                            <button name="operacion" value="pdf" type="submit" class="btn btn-link" >
                                <img src="../../recursos/img/ic_action_send_now.png" />
                            </button>
                        </div>
                    </div>
                </div> 

            </form> <!-- ./form -->

            <?php include __DIR__ . '/../../recursos/inc/pie.php'; ?>

        </div> <!-- ./container -->

    </body>
</html>

