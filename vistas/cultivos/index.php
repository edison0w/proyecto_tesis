<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsRol.php";
session_start();
$_SESSION['mSocio'] = "";
$_SESSION['mTerreno'] = "";
$_SESSION['mCultivo'] = "active";
$array_ini = parse_ini_file("../../recursos/properties.ini");
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
        <link href="../../recursos/css/misEstilos.css" rel="stylesheet" type="text/css"/>
        <!-- recursos javascript -->
        <script src="../../recursos/js/miJavaScript.js" type="text/javascript"></script>
    </head>
    <body>
        <?php include __DIR__ . "/../../recursos/inc/menu.php"; ?>

        <div id="margen-top" class="container">
            <div class="row">
                <!-- Barra de Navegacion izquierda -->
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked hidden-xs hidden-sm">
                        <li role="presentation">
                            <a href="registrar.php">
                                <div class="glyphicon glyphicon-plus" ></div>
                                <?php echo $array_ini['nuevo'] ?>
                            </a>
                            <hr style="margin: 0">
                        </li>
                        <!--
                        <li role="presentation">
                            <a href="buscar.php">
                                <span class="glyphicon glyphicon-search"></span>
                                <php echo $array_ini['buscar'] ?>
                            </a>
                            <hr style="margin: 0">
                        </li>
                        -->
                        <li role="presentation">
                            <a href="todos.php">
                                <span class="glyphicon glyphicon-credit-card" ></span>
                                <?php echo $array_ini['todos'] ?>
                            </a>
                            <hr style="margin: 0">
                        </li>
                    </ul>
                </div>

                <div class="col-xs-12 col-md-9 text-center">
                    <img src="../../recursos/img/cultivos.jpeg" alt="" class="img-thumbnail" style="width: 50%"/>
                    <h4>Cultivos</h4>
                    <span class="text-muted">
                        Actualmente la Junta General de Riego Chambo Guano cuenta con mas de 13 cultivos en sus terrenos.
                    </span>
                </div>
            </div>

            <!-- Barra de Navegacion inferior -->
            <div class="navbar-inverse navbar-fixed-bottom visible-xs visible-sm">
                <div class="row">
                    <div class="col-xs-6 text-center">
                        <button type="button" class="btn btn-link" onclick="javascript:location.href = 'registrar.php'" >
                             <img src="../../recursos/img/ic_action_new.png" />
                        </button>
                    </div>
                    <!--
                    <div class="col-xs-2 text-center">
                        <button type="button" class="btn btn-link" onclick="javascript:location.href = 'buscar.php'">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="glyphicon glyphicon-search" style="font-size: 20px;"></span>
                                </div>
                                <div class="col-xs-12">
                                    <php echo $array_ini['buscar'] ?>
                                </div>
                            </div>
                        </button>
                    </div>
                    -->
                    <div class="col-xs-6 text-center">
                        <button type="button" class="btn btn-link" onclick="javascript:location.href = 'todos.php'">
                            <img src="../../recursos/img/ic_action_select_all.png" />
                        </button>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/../../recursos/inc/pie.php'; ?>

        </div> <!-- ./container -->
    </body>
</html>
