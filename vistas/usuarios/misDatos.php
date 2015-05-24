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
            function formularioPostBuscar(idUsuario) {
                return "txtIdUsuario=" + encodeURIComponent(idUsuario.value) +
                        "&operacion=" + encodeURIComponent('buscar') +
                        "&nocache=" + Math.random();
            }
            function cargarSesion() {
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
                            var usuario = document.getElementById("txtUsuario");
                            usuario.value = jsonObj.username;
                            var nombres = document.getElementById("txtNombres");
                            nombres.value = jsonObj.nombres;
                            nombres.disabled = false;
                            var email = document.getElementById("txtEmail");
                            email.value = jsonObj.email;
                            email.disabled = false;
                            var telefono = document.getElementById("txtTelefono");
                            telefono.value = jsonObj.telefono;
                            telefono.disabled = false;
                            var direccion = document.getElementById("txtDireccion");
                            direccion.value = jsonObj.direccion;
                            direccion.disabled = false;
                        }
                    }
                }
                xmlhttp.open("POST", "../../controlador/conUsuario.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostBuscar(codSocio));
            }
            function formularioPostActualizar() {
                var usuario = document.getElementById("txtUsuario");
                var clave = document.getElementById("txtClave");
                var nombres = document.getElementById("txtNombres");
                var email = document.getElementById("txtEmail");
                var telefono = document.getElementById("txtTelefono");
                var direccion = document.getElementById("txtDireccion");
                return "txtId=" + encodeURIComponent(document.getElementById("txtCodigo").value) +
                        "&txtUsuario=" + encodeURIComponent(usuario.value) +
                        "&txtClave=" + encodeURIComponent(clave.value) +
                        "&txtNombres=" + encodeURIComponent(nombres.value) +
                        "&txtEmail=" + encodeURIComponent(email.value) +
                        "&txtTelefono=" + encodeURIComponent(telefono.value) +
                        "&txtDireccion=" + encodeURIComponent(direccion.value) +
                        "&operacion=" + encodeURIComponent('actualizarDatos') +
                        "&nocache=" + Math.random();
            }
            function actualizar() {
                if (validar()) {
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
                    xmlhttp.open("POST", "../../controlador/conUsuario.php", true);
                    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhttp.send(formularioPostActualizar());
                } else {
                    $.bootstrapGrowl("El usuario no pueden ir en blanco", {
                        type: 'danger',
                        align: 'right',
                        stackup_spacing: 30,
                        delay: 1500
                    });
                }

            }
            function validar() {
                var usuario = document.getElementById('txtUsuario');
                if (usuario.value == "") {
                    return false
                } else {
                    return true
                }
            }
        </script>
    </head>
    <body onload="cargarSesion()">
        <?php include __DIR__ . '/../../recursos/inc/menu.php'; ?>

        <!-- texto oculto / codigo terreno sesion -->
        <input type="hidden" id="txtCodigo" value="<?php echo $_SESSION['usuario']->getId() ?>">

        <div id="margen-top" class="container">

            <!-- Titulo del Formulario-->
            <div class="row">
                <div id="text_color_accent" class="col-xs-12">
                    <?php echo $array_ini['misDatos'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
            </div>

            <!-- Formulario de Actualización -->
            <form >
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="txtUsuario" class="hidden-xs">
                                <?php echo $array_ini['usuario'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">*</span>
                                <input id="txtUsuario" name="txtUsuario" type="text" class="form-control" placeholder="Usuario"  onkeyup="funcionClave()">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txClave" class="hidden-xs">
                                <?php echo $array_ini['clave'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">&nbsp;</span>
                                <input id="txtClave" name="txtClave" type="text" class="form-control" placeholder="Nueva clave" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtNombres" class="hidden-xs">
                                <?php echo $array_ini['nombres'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">&nbsp;</span>
                                <input id="txtNombres" name="txtNombres" type="text" class="form-control" placeholder="Nombres Completos">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="txtEmail" class="hidden-xs">
                                <?php echo $array_ini['email'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">&nbsp;</span>
                                <input id="txtEmail" name="txtEmail" type="text" class="form-control" placeholder="Correo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtTelefono" class="hidden-xs">
                                <?php echo $array_ini['telefono'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">&nbsp;</span>
                                <input id="txtTelefono" name="txtTelefono" type="text" class="form-control" placeholder="Teléfono">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtDireccion" class="hidden-xs">
                                <?php echo $array_ini['direccion'] ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1">&nbsp;</span>
                                <input id="txtDireccion" name="txtDireccion" type="text" class="form-control" placeholder="Dirección">
                            </div>
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
                        <button name="operacion" value="registrar" type="button" class="btn btn-info" onclick="actualizar()">
                            <div class="glyphicon glyphicon-ok"></div>
                            <?php echo $array_ini['actualizar'] ?>
                        </button>
                        <button type="button" class="btn btn-default" onclick="cargarSesion()">
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
                            <button type="button" class="btn btn-link" onclick="actualizar()">
                                <img src="../../recursos/img/ic_action_edit.png" />
                            </button>
                        </div>
                        <div class="col-xs-4 text-center">
                            <button type="button" class="btn btn-link" onclick="cargarSesion()">
                                <img src="../../recursos/img/ic_action_undo.png" />
                            </button>
                        </div>
                    </div>
                </div> 

            </form> <!-- ./form -->

            <?php include __DIR__ . '/../../recursos/inc/pie.php'; ?>

        </div> <!-- ./container -->

    </body>
</html>
