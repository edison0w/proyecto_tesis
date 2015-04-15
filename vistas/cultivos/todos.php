<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsTerreno.php";
require __DIR__ . "/../../modelo/clsAsignarCultivo.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
$array_ini = parse_ini_file("../../recursos/properties.ini");
$_SESSION['mSocio'] = "";
$_SESSION['mTerreno'] = "";
$_SESSION['mCultivo'] = "active";
// Cultivos son los Tipo
// Asignar Cultivo -> utilizada
$objAsignarCultivo = new clsAsignarCultivo();
if ($_SESSION['terreno']->getNum_terreno() != 0) {
    $lista = $objAsignarCultivo->buscarXTerreno($_SESSION['terreno']->getNum_terreno());
} else {
    $lista = $objAsignarCultivo->buscarTodos();
}
$tablaCultivos = tablaDatosTerrenoAsignarCultivos($lista);
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
                $('#tblCultivos').dataTable({
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
            var codigoCultivo = 0;
            function confirmacion(valor) {
                codigoCultivo = valor;
            }
            function formularioPost(operacion) {
                return "txtNumero=" + encodeURIComponent(codigoCultivo) +
                        "&operacion=" + operacion +
                        "&nocache=" + Math.random();
            }
            function eliminar() {
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                        $.bootstrapGrowl(xmlhttp.responseText, {
                            type: 'info',
                            align: 'right',
                            stackup_spacing: 30,
                            delay: 4000
                        });
                        location.reload();
                    }

                }
                xmlhttp.open("POST", "../../controlador/conAsignarCultivo.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPost('eliminar'));
            }
        </script>
    </head>
    <body>
        <?php include '../../recursos/inc/menu.php'; ?>

        <div id="margen-top" class="container">

            <div class="row">
                <div class="col-xs-12">
                    <?php echo $array_ini['cultivos'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
                <?php
                if ($_SESSION['socio']->getCodigo() != 0) {
                    echo "<div class='col-xs-12'>"
                    . "<div class='form-group'>"
                    . "Socio : " . $_SESSION['socio']->getApellido() . ""
                    . "</div>"
                    . "</div>";
                    echo "<div class='col-xs-12'>"
                    . "<div class='form-group'>"
                    . "Terreno : " . $_SESSION['terreno']->getNum_terreno() . ""
                    . "</div>"
                    . "</div>";
                    
                }
                ?>
            </div>
            <table id="tblCultivos" class="table table-striped table-bordered table-hover table-condensed table-responsive" >
                <thead>
                    <tr>
                        <th><?php echo $array_ini['cultivo'] ?></th>
                        <th><?php echo $array_ini['porcentaje'] ?></th>
                        <th><?php echo $array_ini['area'] ?></th>
                        <th><?php echo $array_ini['tipoRiego'] ?></th>
                        <th><?php echo $array_ini['opciones'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $tablaCultivos; ?>
                </tbody>
            </table>

            <div id="confirmacion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Confirmación
                        </div>
                        <div class="modal-body">
                            <p>Esta seguro que quiere eliminar?</p>
                            <button id="btnNo" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-default" onclick="eliminar();">Si</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barra de Navegacion Izquierda-->
            <div class="row hidden-xs hidden-sm">
                <div class="container">
                    <button name="operacion" value="Nuevo" type="button" class="btn btn-info" onclick="location.href = 'registrar.php'">
                        <div class="glyphicon glyphicon-ok"></div>
                        <?php echo $array_ini['nuevo'] ?>
                    </button>
                </div>
            </div>

            <!-- Barra de Navegacion inferior -->
            <div class="navbar-inverse navbar-fixed-bottom visible-xs visible-sm">
                <div class="row">

                    <div class="col-xs-6 text-center">
                        <button type="button" class="btn btn-link" onclick="javascript:history.go(-1)">
                            <div class="row">
                                <div >
                                    <div class="glyphicon glyphicon-circle-arrow-left" style="font-size: 20px"></div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $array_ini['volver'] ?>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-xs-6 text-center">
                        <button type="button" class="btn btn-link" onclick="location.href = 'registrar.php'">
                            <div class="row ">
                                <div >
                                    <div class="glyphicon glyphicon-plus-sign" style="font-size: 20px"></div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $array_ini['nuevo'] ?>
                                </div>
                            </div>
                        </button>
                    </div>

                </div>
            </div> 

            <?php include '../../recursos/inc/pie.php'; ?>

        </div> <!-- ./container -->
    </body>
</html>
