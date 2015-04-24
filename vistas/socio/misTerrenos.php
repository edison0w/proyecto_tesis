<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsTerreno.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
$_SESSION['mSocio'] = "";
$_SESSION['mTerreno'] = "active";
$_SESSION['mCultivo'] = "";
$array_ini = parse_ini_file("../../recursos/properties.ini");
$direccion = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'];
$objTerreno = new clsTerreno();
if ($_SESSION['socio']->getCodigo() != 0) {
    $lista = $objTerreno->buscarXSocio($_SESSION['socio']->getCodigo());
} else {
    $lista = $objTerreno->buscarTodos();
}
$tabla = tablaDatosTerrenosSocio($lista);
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
            $(document).ready(function () {
                $('#tblTerrenos').dataTable({
                    "language": {
                        "emptyTable": "No hay datos disponibles",
                        "info": "Mostrando _START_ - _END_ de _TOTAL_ registros",
                        "infoEmpty": "Mostrando 0 - 0 de 0 registros",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ registros",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "No existen registros",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                    }

                });
                $('#confirmacion').on('shown.bs.modal', function () {
                    $('#btnNo').focus()
                })
            });
            
            function cultivos(valor) {
                var xmlhttp;
                numTerreno = valor;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        location.href = '../cultivos/todos.php';
                    }
                }
                xmlhttp.open("POST", "../../controlador/conTerreno.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPost('nuevo'));
            }
        </script>
    </head>
    <body>
        <?php include '../../recursos/inc/menu.php'; ?>

        <div id="margen-top" class="container">

            <div class="row">
                <div id="text_color_accent" class="col-xs-12">
                    <?php echo $array_ini['terrenos'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
                <?php
                if ($_SESSION['socio']->getCodigo() != 0) {
                    echo "<div class='col-xs-12'>"
                    . "<div class='form-group'>"
                    . "Socio : " . $_SESSION['socio']->getApellido() . ""
                    . "</div>"
                    . "</div>";
                }
                ?>
            </div>
            <table id="tblTerrenos" class="table table-striped table-bordered table-hover table-condensed table-responsive" >
                <thead>
                    <tr>
                        <th><?php echo $array_ini['numTerreno'] ?></th>
                        <th><?php echo $array_ini['areaRiego'] ?></th>
                        <th><?php echo $array_ini['areaSuceptibleRiego'] ?></th>
                        <th><?php echo $array_ini['areaNoSuceptibleRiego'] ?></th>
                        <th><?php echo $array_ini['op'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $tabla; ?>
                </tbody>
            </table>

            <!-- Barra de Navegacion inferior -->
            <div class="navbar-inverse navbar-fixed-bottom visible-xs visible-sm">
                <div class="row">

                    <div class="col-xs-12 text-center">
                        <button type="button" class="btn btn-link" onclick="javascript:history.go(-1)">
                            <img src="../../recursos/img/ic_action_back.png" />
                        </button>
                    </div>

                </div>
            </div> 

            <?php include '../../recursos/inc/pie.php'; ?>

        </div> <!-- ./container -->
    </body>
</html>
