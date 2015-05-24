<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
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
                if (validar()) {
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
                } else {
                    $.bootstrapGrowl("La cédula, nombres y dirección no pueden ir en blanco", {
                        type: 'danger',
                        align: 'right',
                        stackup_spacing: 30,
                        delay: 1500
                    });
                }
            }
            
            function validar() {
                var cedula = document.getElementById('txtCedula');
                var apellido = document.getElementById('txtApellidos');
                var direccion = document.getElementById('txtDireccion');
                if (cedula.value == "") {
                    return false
                } else if (apellido.value == "") {
                    return false
                } else if (direccion.value == "") {
                    return false
                } else {
                    return true
                }
            }
        </script>
    </head>
    <body id="windows_background">
        <?php include __DIR__ . '/../../recursos/inc/menu.php'; ?>

        <div id="margen-top" class="container">

            <!-- Titulo del Formulario-->
            <div class="row">
                <div id="text_color_accent" class="col-xs-12">
                    <?php echo $array_ini['nuevosocio'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
            </div>

            <!-- Formulario de Registro -->
            <form >
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label id="text_color_default" for="txtCedula" class="hidden-xs">
                                <?php echo $array_ini['cedula'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">*</span>
                                <input id="txtCedula" name="txtCedula" type="text" class="form-control" placeholder="Cédula"  maxlength="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txApellidos" class="hidden-xs">
                                <?php echo $array_ini['nombres'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">*</span>
                                <input id="txtApellidos" name="txtApellidos" type="text" class="form-control" placeholder="Apellidos y Nombres" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtDireccion" class="hidden-xs">
                                <?php echo $array_ini['direccion'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">*</span>
                                <input id="txtDireccion" name="txtDireccion" type="text" class="form-control" placeholder="Dirección">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtTelefono" class="hidden-xs">
                                <?php echo $array_ini['telefono'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">&nbsp;</span>
                                <input id="txtTelefono" name="txtTelefono" type="tel" class="form-control" placeholder="Teléfono">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtCelular" class="hidden-xs">
                                <?php echo $array_ini['celular'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">&nbsp;</span>
                                <input id="txtCelular" name="txtCelular" type="tel" class="form-control" placeholder="Celular">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtEmail" class="hidden-xs">
                                <?php echo $array_ini['email'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">&nbsp;</span>
                                <input id="txtEmail" name="txtEmail" type="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="txtEstadoCivil" class="hidden-xs">
                                <?php echo $array_ini['estadocivil'] ?>
                            </label>
                            <select id="txtEstadoCivil" name="txtEstadoCivil" class="selectpicker form-control" onchange="comprobarConyuge()">
                                <option><?php echo $array_ini['casado'] ?></option>
                                <option><?php echo $array_ini['soltero'] ?></option>
                                <option><?php echo $array_ini['viudo'] ?></option>
                                <option><?php echo $array_ini['divorciado'] ?></option>
                                <option><?php echo $array_ini['unionlibre'] ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtConyuge" class="hidden-xs">
                                <?php echo $array_ini['conyuge'] ?>
                            </label>
                            <input id="txtConyuge" name="txtConyuge" type="text" class="form-control" placeholder="Conyuge">
                        </div>
                        <div class="form-group">
                            <label for="txtGenero" class="hidden-xs">
                                <?php echo $array_ini['genero'] ?>
                            </label>
                            <div class="visible-xs visible-sm"> <!-- switch visible en smartphone -->
                                <input type="checkbox" id="txtGenero1" name="txtGenero1" data-on-text="Masculino" data-off-text="Femenino"
                                       data-label-text="Género" data-on-color="primary" data-off-color="primary" class="form-control visible-xs visible-sm" checked>
                            </div>
                            <select class="form-control hidden-xs hidden-sm selectpicker" id="txtGenero2" name="txtGenero2"> <!-- combobox visible en tablet pc -->
                                <option value='M'><?php echo $array_ini['masculino'] ?></option> 
                                <option value='F'><?php echo $array_ini['femenino'] ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtTipoPersona" class="hidden-xs">
                                <?php echo $array_ini['tipopersona'] ?>
                            </label>
                            <div class="visible-xs visible-sm">
                                <input type="checkbox" id="txtTipoPersona1" name="txtTipoPersona1" data-on-text="<?php echo $array_ini['natural'] ?>" data-off-text="<?php echo $array_ini['juridica'] ?>"
                                       data-label-text="<?php echo $array_ini['tipopersona'] ?>" data-on-color="primary" data-off-color="primary" class="form-control" checked>
                            </div>
                            <select id="txtTipoPersona2" name="txtTipoPersona2" class="form-control hidden-xs hidden-sm selectpicker">
                                <option><?php echo $array_ini['natural'] ?></option> 
                                <option><?php echo $array_ini['juridica'] ?></option>
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

                <div class="row">
                    <div class="form-group col-xs-12">
                        <?php echo $array_ini['camposrequeridos'] ?>
                    </div>
                </div>

                <!-- Barra de Navegacion Izquierda-->
                <div class="row hidden-xs hidden-sm">
                    <div class="container">
                        <button name="operacion" value="registrar" type="button" class="btn btn-info" onclick="registrar();"
                                title="Registrar los datos de un Socio">
                            <div class="glyphicon glyphicon-ok"></div>
                            <?php echo $array_ini['registrar'] ?>
                        </button>
                        <button type="reset" class="btn btn-default" title="Resetear todos los campos">
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
                            <button type="button" class="btn btn-link" onclick="registrar()">
                                <img src="../../recursos/img/ic_action_save.png" />
                            </button>
                        </div>
                        <div class="col-xs-4 text-center">
                            <button type="reset" class="btn btn-link">
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
