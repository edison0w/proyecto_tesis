<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../modelo/clsTerreno.php";
require __DIR__ . "/../../modelo/clsJunta.php";
require __DIR__ . "/../../modelo/clsValvula.php";
require __DIR__ . "/../../modelo/clsModulo.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
$array_ini = parse_ini_file("../../recursos/properties.ini");
$direccion = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'];

$objTerreno = new clsTerreno();
$listaSocioTerrenos = $objTerreno->buscarTodosSocioTerrenos();
$opciones = tablaDatosBuscarTerreno($listaSocioTerrenos);

$optionsCondJuridica = sectionCondicionJuridica();
$objJunta = new clsJunta();
$datosJunta = $objJunta->buscarTodos();
$optionsJunta = optionsJunta($datosJunta);

$objValvula = new clsValvula();
$datosValvula = $objValvula->buscarTodos();
$optionsValvula = optionsValvula($datosValvula);

$objModulo = new clsModulo();
$datosModulo = $objModulo->buscarTodos();
$optionsModulo = optionsModulo($datosModulo);
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
                $('.selectpicker').selectpicker({
                    showSubtext: true
                });
            })
            function formularioPostBuscar(numTerreno) {
                return "txtNumTerreno=" + encodeURIComponent(numTerreno.value) +
                        "&operacion=" + encodeURIComponent('buscar') +
                        "&nocache=" + Math.random();
            }
            function buscar() {
                var numTerreno = document.getElementById('txtBuscar');
                var xmlhttp;

                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var jsonObj = JSON.parse(xmlhttp.responseText);
                        if (jsonObj) {
                            var codigo = document.getElementById("txtCodigo");
                            codigo.value = jsonObj.NUM_TERRENO;
                            var socio = document.getElementById("txtSocio");
                            socio.value = codigo.value + ", " + jsonObj.CI + ", " + jsonObj.APELLIDO;
                            var codCatastral = document.getElementById("txtCodCatastral");
                            codCatastral.value = jsonObj.COD_CATASTRAL;
                            var codPredial = document.getElementById("txtCodPredial");
                            codPredial.value = jsonObj.CLAV_PREDIAL;
                            var areaRiego = document.getElementById("txtAreaRiego");
                            areaRiego.value = jsonObj.AREA;
                            var areaSusceptible = document.getElementById("txtAreaSusceptible");
                            areaSusceptible.value = jsonObj.AREAS;
                            var areaNoSusceptible = document.getElementById("txtAreaNoSusceptible");
                            areaNoSusceptible.value = jsonObj.AREAN;
                            var condJuridica = document.getElementById("txtCondJuridica");
                            condJuridica.value = jsonObj.COND_JURIDICA;
                            $('#txtCondJuridica').selectpicker('refresh');
                            var codProvisional = document.getElementById("txtCodProvisional");
                            codProvisional.value = jsonObj.CODIGO_PROVISIONAL;
                            var junta = document.getElementById("txtJunta");
                            junta.value = jsonObj.COD_JUNTA;
                            $('#txtJunta').selectpicker('refresh');
                            var valvula = document.getElementById("txtValvula");
                            valvula.value = jsonObj.COD_VALVULA;
                            $('#txtValvula').selectpicker('refresh');
                            var modulo = document.getElementById("txtModulo");
                            modulo.value = jsonObj.COD_MODULO;
                            $('#txtModulo').selectpicker('refresh');
                            var obs = document.getElementById("txtObservacion");
                            obs.value = jsonObj.OBS;
                        } else {
                            resetear();
                        }
                    }
                }
                xmlhttp.open("POST", "../../controlador/conTerreno.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostBuscar(numTerreno));
            }
            function formularioPostActualizar() {
                var codigo = document.getElementById('txtCodigo');
                var codCatastral = document.getElementById('txtCodCatastral');
                var codPredial = document.getElementById('txtCodPredial');
                var areaRiego = document.getElementById('txtAreaRiego');
                var areaSusceptible = document.getElementById('txtAreaSusceptible');
                var areaNoSusceptible = document.getElementById('txtAreaNoSusceptible');
                var condJuridica = document.getElementById('txtCondJuridica');
                var codProvisional = document.getElementById('txtCodProvisional');
                var junta = document.getElementById('txtJunta');
                var valvula = document.getElementById('txtValvula');
                var modulo = document.getElementById('txtModulo');
                var observacion = document.getElementById('txtObservacion');

                return "txtCodigo=" + encodeURIComponent(codigo.value) +
                        "&txtCodCatastral=" + encodeURIComponent(codCatastral.value) +
                        "&txtCodPredial=" + encodeURIComponent(codPredial.value) +
                        "&txtAreaRiego=" + encodeURIComponent(areaRiego.value) +
                        "&txtAreaSusceptible=" + encodeURIComponent(areaSusceptible.value) +
                        "&txtAreaNoSusceptible=" + encodeURIComponent(areaNoSusceptible.value) +
                        "&txtCondJuridica=" + encodeURIComponent(condJuridica.value) +
                        "&txtCodProvisional=" + encodeURIComponent(codProvisional.value) +
                        "&txtJunta=" + encodeURIComponent(junta.value) +
                        "&txtValvula=" + encodeURIComponent(valvula.value) +
                        "&txtModulo=" + encodeURIComponent(modulo.value) +
                        "&txtObservacion=" + encodeURIComponent(observacion.value) +
                        "&operacion=" + encodeURIComponent('actualizar') +
                        "&nocache=" + Math.random();
            }
            function actualizar() {
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
                            delay: 1500
                        });
                    }
                }
                xmlhttp.open("POST", "../../controlador/conTerreno.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostActualizar());
            }
            function resetear() {
                var codigo = document.getElementById("txtCodigo");
                codigo.value = 0;
                var socio = document.getElementById("txtSocio");
                socio.value = "";
                var codCatastral = document.getElementById("txtCodCatastral");
                codCatastral.value = "";
                var codPredial = document.getElementById("txtCodPredial");
                codPredial.value = "";
                var areaRiego = document.getElementById("txtAreaRiego");
                areaRiego.value = 0;
                var areaSusceptible = document.getElementById("txtAreaSusceptible");
                areaSusceptible.value = 0;
                var areaNoSusceptible = document.getElementById("txtAreaNoSusceptible");
                areaNoSusceptible.value = 0;
                var condJuridica = document.getElementById("txtCondJuridica");
                condJuridica.value = "";
                $('#txtCondJuridica').selectpicker('refresh');
                var codProvisional = document.getElementById("txtCodProvisional");
                codProvisional.value = 0;
                var junta = document.getElementById("txtJunta");
                junta.value = "";
                $('#txtJunta').selectpicker('refresh');
                var valvula = document.getElementById("txtValvula");
                valvula.value = "";
                $('#txtValvula').selectpicker('refresh');
                var modulo = document.getElementById("txtModulo");
                modulo.value = "";
                $('#txtModulo').selectpicker('refresh');
                var obs = document.getElementById("txtObservacion");
                obs.value = "";
                var buscar = document.getElementById("txtBuscar");
                buscar.value = "";
                $('#txtBuscar').selectpicker('refresh');
            }
            function cargarSesion() {
                var numTerreno = document.getElementById('txtCodigo');
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var jsonObj = JSON.parse(xmlhttp.responseText);
                        if (jsonObj) {
                            var codigo = document.getElementById("txtCodigo");
                            codigo.value = jsonObj.NUM_TERRENO;
                            var socio = document.getElementById("txtSocio");
                            socio.value = codigo.value + ", " + jsonObj.CI + ", " + jsonObj.APELLIDO;
                            var codCatastral = document.getElementById("txtCodCatastral");
                            codCatastral.value = jsonObj.COD_CATASTRAL;
                            var codPredial = document.getElementById("txtCodPredial");
                            codPredial.value = jsonObj.CLAV_PREDIAL;
                            var areaRiego = document.getElementById("txtAreaRiego");
                            areaRiego.value = jsonObj.AREA;
                            var areaSusceptible = document.getElementById("txtAreaSusceptible");
                            areaSusceptible.value = jsonObj.AREAS;
                            var areaNoSusceptible = document.getElementById("txtAreaNoSusceptible");
                            areaNoSusceptible.value = jsonObj.AREAN;
                            var condJuridica = document.getElementById("txtCondJuridica");
                            condJuridica.value = jsonObj.COND_JURIDICA;
                            $('#txtCondJuridica').selectpicker('refresh');
                            var codProvisional = document.getElementById("txtCodProvisional");
                            codProvisional.value = jsonObj.CODIGO_PROVISIONAL;
                            var junta = document.getElementById("txtJunta");
                            junta.value = jsonObj.COD_JUNTA;
                            $('#txtJunta').selectpicker('refresh');
                            var valvula = document.getElementById("txtValvula");
                            valvula.value = jsonObj.COD_VALVULA;
                            $('#txtValvula').selectpicker('refresh');
                            var modulo = document.getElementById("txtModulo");
                            modulo.value = jsonObj.COD_MODULO;
                            $('#txtModulo').selectpicker('refresh');
                            var obs = document.getElementById("txtObservacion");
                            obs.value = jsonObj.OBS;
                        } else {
                            resetear();
                        }
                    }
                }
                xmlhttp.open("POST", "../../controlador/conTerreno.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostBuscar(numTerreno));
            }
        </script>
    </head>
    <body onload="cargarSesion()">
        <?php include __DIR__ . '/../../recursos/inc/menu.php'; ?>

        <!-- texto oculto / codigo terreno sesion -->
        <input type="hidden" id="txtCodigo" value="<?php echo $_SESSION['terreno']->getNum_terreno() ?>">

        <div id="margen-top" class="container">

            <!-- Buscar Socio terreno-->
            <div class="row">
                <div class="col-xs-6 col-sm-8 col-sm-offset-2 ">
                    <div class="form-group">
                        <select id="txtBuscar" class="selectpicker" data-live-search="true" data-width="100%" 
                                title="Buscar" onchange="buscar()">
                                    <?php echo $opciones ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Titulo del Formulario-->
            <div class="row">
                <div id="text_color_accent" class="col-xs-12">
                    <?php echo $array_ini['buscarTerreno'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
            </div>

            <!-- Informacion del Terreno/socio a actualizar-->
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label for="txSocio" class="hidden-xs">
                            <?php echo $array_ini['socio'] ?>
                        </label>
                        <input id="txtSocio" name="txtSocio" type="text" class="form-control" placeholder="Terreno, Cédula, Nombres" 
                               disabled value="<?php
                               if ($_SESSION['terreno']->getNum_terreno() != 0) {
                                   echo $_SESSION['terreno']->getNum_terreno() . ", " . $_SESSION['socio']->getCi() . ', ' . $_SESSION['socio']->getApellido();
                               }
                               ?>"
                               >
                    </div>
                </div>
            </div>

            <!-- Formulario de Registro -->
            <form method="POST" action="../../controlador/conTerreno.php">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="txCodCatastral" class="hidden-xs">
                                <?php echo $array_ini['catastral'] ?>
                            </label>
                            <input id="txtCodCatastral" name="txtCodCatastral" type="text" class="form-control" placeholder="Código Catastral" >
                        </div>
                        <div class="form-group">
                            <label for="txtCodPredial" class="hidden-xs">
                                <?php echo $array_ini['predial'] ?>
                            </label>
                            <input id="txtCodPredial" name="txtCodPredial" type="text" class="form-control" placeholder="Código Predial">
                        </div>
                        <div class="form-group">
                            <label for="txtAreaRiego" class="hidden-xs">
                                <?php echo $array_ini['areaRiego'] ?>
                            </label>
                            <input id="txtAreaRiego" name="txtAreaRiego" type="text" class="form-control" placeholder="Area con Riego">
                        </div>
                        <div class="form-group">
                            <label for="txtAreaSusceptible" class="hidden-xs">
                                <?php echo $array_ini['areaSuceptibleRiego'] ?>
                            </label>
                            <input id="txtAreaSusceptible" name="txtAreaSusceptible" type="tex" class="form-control" placeholder="Area Susceptible de Riego">
                        </div>
                        <div class="form-group">
                            <label for="txtAreaNoSusceptible" class="hidden-xs">
                                <?php echo $array_ini['areaNoSuceptibleRiego'] ?>
                            </label>
                            <input id="txtAreaNoSusceptible" name="txtAreaNoSusceptible" type="text" class="form-control" placeholder="Area Susceptible de Riego">
                        </div>
                        <div class="form-group">
                            <label for="txtCondJuridica" class="hidden-xs">
                                <?php echo $array_ini['condJuridica'] ?>
                            </label>
                            <select id="txtCondJuridica" name="txtCondJuridica" class="selectpicker form-control">
                                <?php echo $optionsCondJuridica ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">

                        <div class="form-group">
                            <label for="txtCodProvisional" class="hidden-xs">
                                <?php echo $array_ini['codProvisional'] ?>
                            </label>
                            <input id="txtCodProvisional" name="txtCodProvisional" type="text" class="form-control" placeholder="Código Provisional">
                        </div>
                        <div class="form-group">
                            <label for="txtJunta" class="hidden-xs">
                                <?php echo $array_ini['junta'] ?>
                            </label>
                            <select id="txtJunta" name="txtJunta" class="selectpicker form-control">
                                <?php echo $optionsJunta ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtValvula" class="hidden-xs">
                                <?php echo $array_ini['valvula'] ?>
                            </label>
                            <select id="txtValvula" name="txtValvula" class="selectpicker form-control">
                                <?php echo $optionsValvula ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtModulo" class="hidden-xs">
                                <?php echo $array_ini['modulo'] ?>
                            </label>
                            <select id="txtModulo" name="txtModulo" class="selectpicker form-control">
                                <?php echo $optionsModulo ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtObservacion" class="hidden-xs">
                                <?php echo $array_ini['observacion'] ?>
                            </label>
                            <textarea id="txtObservacion" name="txtObservacion" class="form-control" rows="4" placeholder="Observación"></textarea>
                        </div>
                    </div> 

                </div> <!-- ./row -->

                <!-- Barra de Navegacion Izquierda-->
                <div class="row hidden-xs hidden-sm">
                    <div class="container">
                        <button type="button" name="operacion" value="actualizar" class="btn btn-info" onclick="actualizar()">
                            <div class="glyphicon glyphicon-floppy-disk"></div>
                            <?php echo $array_ini['actualizar'] ?>
                        </button>
                        <button type="button" name="operacion" value="eliminar" class="btn btn-danger" onclick="eliminar()">
                            <div class="glyphicon glyphicon-trash"></div>
                            <?php echo $array_ini['eliminar'] ?>
                        </button>
                        <button type="button" name="operacion" value="terrenos" class="btn btn-success" onclick="location.href = '../cultivos/todos.php'">
                            <div class="glyphicon glyphicon-globe"></div>
                            <?php echo $array_ini['cultivos'] ?>
                        </button>
                        <button type="button" name="operacion" value="cancelar" class="btn btn-default" onclick="resetear()">
                            <div class="glyphicon glyphicon-repeat"></div>
                            <?php echo $array_ini['cancelar'] ?>
                        </button>
                    </div>
                </div>

                <!-- Barra de Navegacion inferior -->
                <div class="navbar-inverse navbar-fixed-bottom visible-xs visible-sm">
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <button type="button" class="btn btn-link" onclick="javascript:history.go(-1)">
                                <img src="../../recursos/img/ic_action_back.png" />
                            </button>
                        </div>
                        <div class="col-xs-4 text-center">
                            <button type="button" name="operacion" value="registrar" class="btn btn-link" onclick="registrar()">
                                <img src="../../recursos/img/ic_action_save.png" />
                            </button>
                        </div>
                        <div class="col-xs-4 text-center">
                            <button type="button" class="btn btn-link" onclick="resetear()">
                                <img src="../../recursos/img/ic_action_cancel.png" />
                            </button>
                        </div>
                    </div>
                </div> 

            </form> <!-- ./form -->

            <?php include __DIR__ . '/../../recursos/inc/pie.php'; ?>

        </div> <!-- ./container -->
    </body>
</html>
