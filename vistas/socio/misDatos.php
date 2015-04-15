<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
$_SESSION['mSocio'] = "active";
$_SESSION['mTerreno'] = "";
$_SESSION['mCultivo'] = "";
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
        <link href="../../recursos/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../recursos/css/bootstrap-switch.css" rel="stylesheet" type="text/css"/>
        <link href="../../recursos/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../../recursos/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <!-- recursos javascript -->
        <script src="../../recursos/js/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../../recursos/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../recursos/js/bootstrap-switch.js" type="text/javascript"></script>
        <script src="../../recursos/js/highlight.js" type="text/javascript"></script>
        <script src="../../recursos/js/main.js" type="text/javascript"></script>
        <script src="../../recursos/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../../recursos/js/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
        <script>
            function comprobarConyuge() {
                var estadoCivil = document.getElementById('txtEstadoCivil');
                var conyuge = document.getElementById('txtConyuge');
                conyuge.value = "";
                if (estadoCivil.value == "Casado/a" || estadoCivil.value == "Union Libre") {
                    conyuge.disabled = false;
                } else {
                    conyuge.disabled = true;
                }
            }

            function formularioPost() {
                var cedula = document.getElementById('txtCedula');
                var apellido = document.getElementById('txtApellidos');
                var direccion = document.getElementById('txtDireccion');
                var telefono = document.getElementById('txtTelefono');
                var celular = document.getElementById('txtCelular');
                var email = document.getElementById('txtEmail');
                var estadoCivil = document.getElementById('txtEstadoCivil');
                var conyuge = document.getElementById('txtConyuge');
                var genero = "";
                if (document.getElementById('txtGenero1').checked && document.getElementById('txtGenero2').value == "M") {
                    genero = "M";
                } else {
                    genero = "F";
                }
                var tipoPersona = "";
                if (document.getElementById('txtTipoPersona1').checked && document.getElementById('txtTipoPersona2').value == "M") {
                    tipoPersona = "Natural";
                } else {
                    tipoPersona = "Jurídico";
                }
                var observacion = document.getElementById('txtObservacion');

                return "txtCedula=" + encodeURIComponent(cedula.value) +
                        "&txtApellidos=" + encodeURIComponent(apellido.value) +
                        "&txtDireccion=" + encodeURIComponent(direccion.value) +
                        "&txtTelefono=" + encodeURIComponent(telefono.value) +
                        "&txtCelular=" + encodeURIComponent(celular.value) +
                        "&txtEmail=" + encodeURIComponent(email.value) +
                        "&txtEstadoCivil=" + encodeURIComponent(estadoCivil.value) +
                        "&txtConyuge=" + encodeURIComponent(conyuge.value) +
                        "&txtGenero=" + encodeURIComponent(genero) +
                        "&txtTipoPersona=" + encodeURIComponent(tipoPersona) +
                        "&txtObservacion=" + encodeURIComponent(observacion.value) +
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
                        if (xmlhttp.responseText == "No se pudo ingresar al socio") {
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
                xmlhttp.open("POST", "../../controlador/conSocio.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPost());
            }

            function formularioPostBuscar(codSocio) {
                return "txtCodigo=" + encodeURIComponent(codSocio.value) +
                        "&operacion=" + encodeURIComponent('buscar') +
                        "&nocache=" + Math.random();
            }

            function preCarga() {
                var codSocio = document.getElementById('txtCodigo');
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
                            codigo.value = jsonObj.CODIGO;
                            var cedula = document.getElementById("txtCedula");
                            cedula.value = jsonObj.CI;
                            var apellidos = document.getElementById("txtApellidos");
                            apellidos.value = jsonObj.APELLIDO;
                            var direccion = document.getElementById("txtDireccion");
                            direccion.value = jsonObj.DIRECCION;
                            var telefono = document.getElementById("txtTelefono");
                            telefono.value = jsonObj.TELEFONO;
                            var celular = document.getElementById("txtCelular");
                            celular.value = jsonObj.CELULAR;
                            var email = document.getElementById("txtEmail");
                            email.value = jsonObj.EMAIL;
                            var estadoCivil = document.getElementById("txtEstadoCivil");
                            estadoCivil.value = jsonObj.ESTADO_CIVIL;
                            $('#txtEstadoCivil').selectpicker('refresh');
                            var conyuge = document.getElementById("txtConyuge");
                            conyuge.value = jsonObj.NOMBRE_CONYUGE;
                            var genero = document.getElementById("txtGenero");
                            genero.value = jsonObj.GENERO;
                            $('#txtGenero').selectpicker('refresh');
                            var tipoPersona = document.getElementById("txtTipoPersona");
                            tipoPersona.value = jsonObj.TIPO;
                            $('#txtTipoPersona').selectpicker('refresh');
                            var obs = document.getElementById("txtObservacion");
                            obs.value = jsonObj.OBS;
                        }

                    }
                }
                xmlhttp.open("POST", "../../controlador/conSocio.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostBuscar(codSocio));
            }
        </script>
    </head>
    <body onload="preCarga()">
        <?php include __DIR__ . '/../../recursos/inc/menu.php'; ?>

        <!-- texto oculto / codigo terreno sesion -->
        <input type="text" id="txtCodigo" value="<?php echo $_SESSION['usuario']->getId_referencia() ?>">

        <div id="margen-top" class="container">

            <!-- Titulo del Formulario-->
            <div class="row">
                <div class="col-xs-12">
                    <?php echo $array_ini['misDatos'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
            </div>

            <!-- Formulario de Registro -->
            <form >
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="txtCedula" class="hidden-xs">
                                <?php echo $array_ini['cedula'] ?>
                            </label>
                            <input id="txtCedula" name="txtCedula" type="text" class="form-control" placeholder="Cédula"  maxlength="10" disabled>
                        </div>
                        <div class="form-group">
                            <label for="txApellidos" class="hidden-xs">
                                <?php echo $array_ini['nombres'] ?>
                            </label>
                            <input id="txtApellidos" name="txtApellidos" type="text" class="form-control" placeholder="Apellidos y Nombres" disabled>
                        </div>
                        <div class="form-group">
                            <label for="txtDireccion" class="hidden-xs">
                                <?php echo $array_ini['direccion'] ?>
                            </label>
                            <input id="txtDireccion" name="txtDireccion" type="text" class="form-control" placeholder="Dirección" disabled>
                        </div>
                        <div class="form-group">
                            <label for="txtTelefono" class="hidden-xs">
                                <?php echo $array_ini['telefono'] ?>
                            </label>
                            <input id="txtTelefono" name="txtTelefono" type="text" class="form-control" placeholder="Teléfono" disabled>
                        </div>
                        <div class="form-group">
                            <label for="txtCelular" class="hidden-xs">
                                <?php echo $array_ini['celular'] ?>
                            </label>
                            <input id="txtCelular" name="txtCelular" type="text" class="form-control" placeholder="Celular" disabled>
                        </div>
                        <div class="form-group">
                            <label for="txtEmail" class="hidden-xs">
                                <?php echo $array_ini['email'] ?>
                            </label>
                            <input id="txtEmail" name="txtEmail" type="text" class="form-control" placeholder="Email" disabled>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="txtEstadoCivil" class="hidden-xs">
                                <?php echo $array_ini['estadocivil'] ?>
                            </label>
                            <select id="txtEstadoCivil" name="txtEstadoCivil" class="selectpicker form-control" onchange="comprobarConyuge()" disabled>
                                <option>Casado/a</option>
                                <option>Soltero/a</option>
                                <option>Viudo/a</option>
                                <option>Divorsiado/a</option>
                                <option>Union Libre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtConyuge" class="hidden-xs">
                                <?php echo $array_ini['conyuge'] ?>
                            </label>
                            <input id="txtConyuge" name="txtConyuge" type="text" class="form-control" placeholder="Conyuge" disabled>
                        </div>
                        <div class="form-group">
                            <label for="txtGenero" class="hidden-xs">
                                <?php echo $array_ini['genero'] ?>
                            </label>
                            <div class="visible-xs visible-sm"> <!-- switch visible en smartphone -->
                                <input type="checkbox" id="txtGenero1" name="txtGenero1" data-on-text="Masculino" data-off-text="Femenino"
                                       data-label-text="Género" data-on-color="primary" data-off-color="primary" class="form-control visible-xs visible-sm" checked disabled>
                            </div>
                            <select class="form-control hidden-xs hidden-sm selectpicker" id="txtGenero2" name="txtGenero2" disabled> <!-- combobox visible en tablet pc -->
                                <option value='M'>Masculino</option> 
                                <option value='F'>Femenino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtTipoPersona" class="hidden-xs">
                                <?php echo $array_ini['tipopersona'] ?>
                            </label>
                            <div class="visible-xs visible-sm">
                                <input type="checkbox" id="txtTipoPersona1" name="txtTipoPersona1" data-on-text="Natural" data-off-text="Jurídica"
                                       data-label-text="Típo de Persona" data-on-color="primary" data-off-color="primary" class="form-control" checked disabled>
                            </div>
                            <select id="txtTipoPersona2" name="txtTipoPersona2" class="form-control hidden-xs hidden-sm selectpicker" disabled>
                                <option>Natural</option> 
                                <option>Jurídico</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtObservacion" class="hidden-xs">
                                <?php echo $array_ini['observacion'] ?>
                            </label>
                            <textarea id="txtObservacion" name="txtObservacion" class="form-control" rows="4" placeholder="Observación" disabled></textarea>
                        </div>
                    </div> 

                </div> <!-- ./row -->


            </form> <!-- ./form -->

            <?php include __DIR__ . '/../../recursos/inc/pie.php'; ?>

        </div> <!-- ./container -->

    </body>
</html>


