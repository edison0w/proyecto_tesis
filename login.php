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
        <link href="recursos/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="recursos/css/bootstrap-checkbox.css" rel="stylesheet" type="text/css"/>
        <link href="recursos/css/style.css" rel="stylesheet" type="text/css"/>
        
        <!-- recursos javascript -->
        <script src="recursos/js/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="recursos/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="recursos/js/bootstrap-checkbox.js" type="text/javascript"></script>
        <script src="recursos/js/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
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
                        } else {
                            location.href = xmlhttp.responseText;
                        }
                    }
                }
                xmlhttp.open("POST", "controlador/conUsuario.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPost());
            }
            
            function onKey(event){
                if (event.key=="Enter"){
                    login();
                }
            }
        </script>
    </head>
    <body id="windows_background">

        <div class="container">
            <!-- Titulo -->
            <div class="row">
                <div id="text_color_accent" class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                    <h4><?php echo $array_ini['accesosistema'] ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" ><hr id="text_color_accent"></div>
            </div>
            <!-- Formulario -->
            <form>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                        <div class="form-group">
                            <label id="text_color_default" for="txtUsuario" class="hidden-xs">
                                <?php echo $array_ini['usuario'] ?>
                            </label>
                            <input id="txtUsuario" name="txtUsuario" type="text" class="form-control" placeholder="Usuario">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                        <div class="form-group">
                            <label for="txtClave" class="hidden-xs">
                                <?php echo $array_ini['clave'] ?>
                            </label>
                            <input id="txtClave" name="txtClave" type="password" class="form-control" 
                                   placeholder="Clave" onkeypress="onKey(event)">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="text_color_accent" class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                        <input id="cbClave" type="checkbox" data-label="Mostrar clave" onclick="mostrarUOcultarClave();"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
                        <button id="operacion" onclick="login();" type="button" class="btn btn-info btn-block">
                            <?php echo $array_ini['acceder'] ?>
                        </button>
                    </div>
                </div>
            </form>

            <?php include __DIR__ . '/recursos/inc/pie.php'; ?>

        </div> <!-- /container -->

    </body>
</html>
