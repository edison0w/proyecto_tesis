<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../modelo/clsCultivo.php";
require __DIR__ . "/../../modelo/clsTerreno.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
$array_ini = parse_ini_file("../../recursos/properties.ini");
$direccion = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'];

$objCultivo = new clsCultivo();
$datosCultivo = $objCultivo->buscarTodos();
$optionsCultivo = optionsCultivos($datosCultivo);

$objTerreno = new clsTerreno();
$listaSocioTerrenos = $objTerreno->buscarTodosSocioTerrenos();
$opciones = tablaDatosBuscarTerreno($listaSocioTerrenos);
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
            function activarBotones() {
                var btnRegistrar = document.getElementById("btnRegistrar");
                btnRegistrar.disabled = false;
            }
            function desactivarBotones() {
                var btnRegistrar = document.getElementById("btnRegistrar");
                btnRegistrar.disabled = true;
            }
            $(document).ready(function () {
                $("#txtPorcentaje").slider({
                    tooltip: 'show',
                    min: 0,
                    max: 100,
                    value: 100,
                    formatter: function (value) {
                        return value + " %";
                    }
                });
            });

            function formularioPost() {
                var codigoTerreno = document.getElementById('txtCodigo');
                var codCultivo = document.getElementById('txtCultivo');
                var porcentaje = document.getElementById('txtPorcentaje');
                var fechaRegistro = document.getElementById('txtFechaRegistro');
                var edadAlRegistro = document.getElementById('txtEdadAlRegistro');
                var tipoRiego = document.getElementById('txtTipoRiego');
                var obs = document.getElementById('txtObservacion');

                return "txtNumTerreno=" + encodeURIComponent(codigoTerreno.value) +
                        "&txtCodCultivo=" + encodeURIComponent(codCultivo.value) +
                        "&txtPorcentaje=" + encodeURIComponent(porcentaje.value) +
                        "&txtFechaRegistro=" + encodeURIComponent(fechaRegistro.value) +
                        "&txtEdadAlRegistro=" + encodeURIComponent(edadAlRegistro.value) +
                        "&txtTipoRiego=" + encodeURIComponent(tipoRiego.value) +
                        "&txtObs=" + encodeURIComponent(obs.value) +
                        "&operacion=" + encodeURIComponent('registrar') +
                        "&nocache=" + Math.random();
            }
            function registrar() {
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if (xmlhttp.responseText == "No se pudo ingresar el cultivo") {
                            $.bootstrapGrowl(xmlhttp.responseText, {
                                type: 'danger',
                                align: 'right',
                                stackup_spacing: 30,
                                delay: 1500
                            });
                        } else {
                            location.href = xmlhttp.responseText;
                        }
                    }
                }
                xmlhttp.open("POST", "../../controlador/conAsignarCultivo.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPost());
            }
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
                            var codigoTerreno = document.getElementById('txtCodigo');
                            codigoTerreno.value = jsonObj.NUM_TERRENO;
                            var codigo = document.getElementById('txtSocio');
                            codigo.value = jsonObj.NUM_TERRENO + ", " + jsonObj.CI + ", " + jsonObj.APELLIDO;
                            activarBotones();
                        } else {
                            resetear();
                        }
                    }
                }
                xmlhttp.open("POST", "../../controlador/conAsignarCultivo.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostBuscar(numTerreno));
            }
            function resetear() {
                
                desactivarBotones();
            }
            
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
                    <?php echo $array_ini['nuevoCultivo'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
            </div>

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
                            <label for="txCultivo" class="hidden-xs">
                                <?php echo $array_ini['cultivo'] ?>
                            </label>

                            <select id="txtCultivo" name="txtCultivo" class="selectpicker form-control">
                                <?php echo $optionsCultivo ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtPorcentaje" >
                                <?php echo $array_ini['porcentajes'] ?>
                            </label>
                            <input id="txtPorcentaje" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="14"/>
                        </div>
                        <div class="form-group">
                            <label for="txtFechaRegistro" class="hidden-xs">
                                <?php echo $array_ini['fechaRegistro'] ?>
                            </label>
                            <input value="<?php echo date("Y-m-d H:i:s"); ?>" id="txtFechaRegistro" name="txtFechaRegistro" type="text" class="form-control" placeholder="Fecha de Registro" disabled>
                        </div>
                        <div class="form-group">
                            <label for="txtEdadAlRegistro" class="hidden-xs">
                                <?php echo $array_ini['edadAlRegistro'] ?>
                            </label>
                            <input id="txtEdadAlRegistro" name="txtEdadAlRegistro" type="number" class="form-control" placeholder="Edad al Registro (dias)">
                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-6">

                        <div class="form-group">
                            <label for="txtTipoRiego" class="hidden-xs">
                                <?php echo $array_ini['tipoRiego'] ?>
                            </label>

                            <select id="txtTipoRiego" name="txtTipoRiego" class="selectpicker form-control">
                                <option value="">Seleccione el Tipo Riego</option>
                                <option value="A">Aspersión</option>
                                <option value="G">Goteo</option>
                                <option value="Gr">Gravedad</option>
                                <option value="NA">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtObservacion" class="hidden-xs">
                                <?php echo $array_ini['observacion'] ?>
                            </label>
                            <textarea id="txtObservacion" name="txtObservacion" class="form-control" rows="4" placeholder="Observación <Opcional>"></textarea>
                        </div>
                    </div> 

                </div> <!-- ./row -->

                <!-- Barra de Navegacion Izquierda-->
                <div class="row hidden-xs hidden-sm">
                    <div class="container">
                        <button id="btnRegistrar" name="operacion" value="registrar" type="button" class="btn btn-info" 
                                onclick="registrar()" title="Registrar los datos del cultivo" disabled="true">
                            <div class="glyphicon glyphicon-ok"></div>
                            <?php echo $array_ini['registrar'] ?>
                        </button>
                        <button type="button" class="btn btn-default" onclick="resetear()" title="Resetear los campos">
                            <div class="glyphicon glyphicon-remove"></div>
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
