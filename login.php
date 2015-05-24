<?php
session_start();
$array_ini = parse_ini_file(realpath("recursos/properties.ini"));
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
        <script>
            $(document).on("ready", function () {
                $('input[type="checkbox"]').checkbox();
            })
            function mostrarUOcultarClave() { // Si quieres le cambias el nombre xD
                checkbox = document.getElementById('cbClave');
                passField = document.getElementById('txtClave');
                if (checkbox.checked == true) // Si la checkbox de mostrar contraseña está activada
                {
                    passField.type = "text";
                }
                else // Si no está activada
                {
                    passField.type = "password"
                }
            }

            function formularioPost() {
                var usuario = document.getElementById('txtUsuario');
                var clave = document.getElementById('txtClave');

                return "txtUsuario=" + encodeURIComponent(usuario.value) +
                        "&txtClave=" + encodeURIComponent(clave.value) +
                        "&operacion=" + 'acceder' +
                        "&nocache=" + Math.random();
            }

            function login() {
                var boton = document.getElementById('operacion');
                boton.disabled = true;

                if (validar()) {
                    var xmlhttp;
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            if (xmlhttp.responseText == "No existe un Perfil" || xmlhttp.responseText == "Usuario o contraseña incorrecta") {
                                $.bootstrapGrowl(xmlhttp.responseText, {
                                    type: 'danger',
                                    align: 'right',
                                    stackup_spacing: 30,
                                    delay: 1500
                                });
                                boton.disabled = false;
                            } else {
                                location.href = xmlhttp.responseText;
                            }
                        }
                    }
                    xmlhttp.open("POST", "controlador/conUsuario.php", true);
                    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhttp.send(formularioPost());
                } else {
                    $.bootstrapGrowl("El usuario y/o la contraseña no pueden ir en blanco", {
                        type: 'danger',
                        align: 'right',
                        stackup_spacing: 30,
                        delay: 1500
                    });
                    boton.disabled = false;
                }
            }

            function onKey(event) {
                if (event.key == "Enter") {
                    login();
                }
            }
            function validar() {
                var usuario = document.getElementById('txtUsuario');
                var clave = document.getElementById('txtClave');
                if (usuario.value == "") {
                    return false;
                } else if (clave.value == "") {
                    return false;
                } else {
                    return true;
                }
            }
        </script>
    </head>
    <body id="windows_background">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <img src="recursos/img/jurechgis.png" width="100px"/>
                </div>
            </div>
            <!-- Titulo -->
            <div class="row">
                <div id="text_color_accent" class="col-xs-12 text-center">
                    <h4><?php echo $array_ini['accesosistema'] ?></h4>
                </div>
            </div>
            <!-- Formulario -->

            <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                <div class="form-group">
                    <label id="text_color_primary" for="txtUsuario" class="control-label hidden-xs">
                        <?php echo $array_ini['usuario'] ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1">*</span>
                        <input id="txtUsuario" name="txtUsuario" type="text" class="form-control" placeholder="Usuario"
                               title="Ingrese su cédula" aria-describedby="txtUsuarioStatus">
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                <div class="form-group">
                    <label id="text_color_primary" for="txtClave" class="hidden-xs">
                        <?php echo $array_ini['clave'] ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1">*</span>
                        <input id="txtClave" name="txtClave" type="password" class="form-control" 
                               placeholder="Clave" onkeypress="onKey(event)" title="Ingrese su clave">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                    <?php echo $array_ini['camposrequeridos'] ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                    <button  id="operacion" onclick="login();" type="button" class="btn btn-success btn-block">
                        <?php echo $array_ini['acceder'] ?>
                    </button>
                </div>
            </div>

            <div id="espacio-pie" class="row text-center">
                <img src="<?php echo $direccion ?>/recursos/img/bg_pie.png" width="80%"/>
            </div>
            <div class="row">
                <div class="text-center">
                    <?php echo $array_ini['copyright'] ?>
                </div>
                <div class="text-center">
                    <?php echo $array_ini['derechos'] ?>
                </div>
            </div> 

        </div> <!-- /container -->

    </body>
</html>
