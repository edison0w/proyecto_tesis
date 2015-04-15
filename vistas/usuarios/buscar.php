<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
$array_ini = parse_ini_file("../../recursos/properties.ini");
$direccion = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'];

$objUsuario = new clsUsuario();
$lista = $objUsuario->buscarTodos();
$opciones = tablaDatosBuscarUsuario($lista);

$objRol = new clsRol();
$lista = $objRol->buscarTodos();
$optionsRol = optionsRol($lista);
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
            function buscar() {
                var idUsuario = document.getElementById('txtBuscar');
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

                            var perfil = document.getElementById("txtPerfil");
                            perfil.value = jsonObj.Rol;
                            $('#txtPerfil').selectpicker('refresh');

                            var descripcion = document.getElementById("txtDescripcion");
                            descripcion.value = jsonObj.descripcion;
                            descripcion.disabled = false;

                            var estado = document.getElementById("txtEstado");
                            estado.value = jsonObj.estado;
                            $('#txtEstado').selectpicker('refresh');

                            var id = document.getElementById("txtCodigo");
                            id.value = jsonObj.id;
                        } else {
                            resetear();
                        }

                    }
                }
                xmlhttp.open("POST", "../../controlador/conUsuario.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostBuscar(idUsuario));
            }
            function formularioPostEliminar() {
                var codSocio = document.getElementById('txtCodigo');
                return "txtIdUsuario=" + encodeURIComponent(codSocio.value) +
                        "&operacion=" + encodeURIComponent('eliminar') +
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
                            delay: 1500
                        });
                        if (xmlhttp.responseText == "Socio eliminado correctamente") {
                            resetear();

                            var select = document.getElementById('txtBuscar');
                            var codigo = document.getElementById('txtCodigo');
                            for (i = 0; i < select.options.length; i++) {
                                if (codigo.value == select.options[i].value) {
                                    select.remove(i);
                                    $('#txtBuscar').selectpicker('refresh');
                                    break;
                                }

                            }
                        }
                    }
                }
                xmlhttp.open("POST", "../../controlador/conUsuario.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostEliminar());
            }
            function formularioPostActualizar() {
                var usuario = document.getElementById("txtUsuario");
                var nombres = document.getElementById("txtNombres");
                var email = document.getElementById("txtEmail");
                var telefono = document.getElementById("txtTelefono");
                var direccion = document.getElementById("txtDireccion");
                var perfil = document.getElementById("txtPerfil");
                var descripcion = document.getElementById("txtDescripcion");
                var estado = document.getElementById("txtEstado");
                return "txtId=" + encodeURIComponent(document.getElementById("txtCodigo").value) +
                        "&txtUsuario=" + encodeURIComponent(usuario.value) +
                        "&txtNombres=" + encodeURIComponent(nombres.value) +
                        "&txtEmail=" + encodeURIComponent(email.value) +
                        "&txtTelefono=" + encodeURIComponent(telefono.value) +
                        "&txtDireccion=" + encodeURIComponent(direccion.value) +
                        "&txtPerfil=" + encodeURIComponent(perfil.value) +
                        "&txtDescripcion=" + encodeURIComponent(descripcion.value) +
                        "&txtEstado=" + encodeURIComponent(estado.value) +
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
                xmlhttp.open("POST", "../../controlador/conUsuario.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostActualizar());
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

                            var perfil = document.getElementById("txtPerfil");
                            perfil.value = jsonObj.Rol;
                            $('#txtPerfil').selectpicker('refresh');

                            var descripcion = document.getElementById("txtDescripcion");
                            descripcion.value = jsonObj.descripcion;
                            descripcion.disabled = false;

                            var estado = document.getElementById("txtEstado");
                            estado.value = jsonObj.estado;
                            $('#txtEstado').selectpicker('refresh');
                        }
                    }
                }
                xmlhttp.open("POST", "../../controlador/conUsuario.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostBuscar(codSocio));
            }
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
            function resetear() {
//                var codigo = document.getElementById("txtCodigo");
//                codigo.value = "";
                var cedula = document.getElementById("txtCedula");
                cedula.value = "";
                cedula.disabled = true;
                var apellidos = document.getElementById("txtApellidos");
                apellidos.value = "";
                apellidos.disabled = true;
                var direccion = document.getElementById("txtDireccion");
                direccion.value = "";
                direccion.disabled = true;
                var telefono = document.getElementById("txtTelefono");
                telefono.value = "";
                telefono.disabled = true;
                var celular = document.getElementById("txtCelular");
                celular.value = "";
                celular.disabled = true;
                var email = document.getElementById("txtEmail");
                email.value = "";
                email.disabled = true;
                var estadoCivil = document.getElementById("txtEstadoCivil");
                estadoCivil.value = "";
                estadoCivil.disabled = true;
                $('#txtEstadoCivil').selectpicker('refresh');
                var conyuge = document.getElementById("txtConyuge");
                conyuge.value = "";
                conyuge.disabled = true;
                var genero = document.getElementById("txtGenero");
                genero.value = "";
                genero.disabled = true;
                $('#txtGenero').selectpicker('refresh');
                var tipoPersona = document.getElementById("txtTipoPersona");
                tipoPersona.value = "";
                tipoPersona.disabled = true;
                $('#txtTipoPersona').selectpicker('refresh');
                var obs = document.getElementById("txtObservacion");
                obs.value = "";
                obs.disabled = true;
                var buscar = document.getElementById("txtBuscar");
                buscar.value = "";
                $('#txtBuscar').selectpicker('refresh');

            }
        </script>
    </head>
    <body onload="cargarSesion()">
        <?php include '../../recursos/inc/menu.php'; ?>

        <!-- texto oculto / codigo terreno sesion -->
        <input type="hidden" id="txtCodigo" value="<?php echo $_SESSION['usu']->getId() ?>">

        <div id="margen-top" class="container">

            <div class="row">
                <div class="col-xs-12 text-center">
                    <div class="form-group">
                        <select id="txtBuscar" class="selectpicker" data-live-search="true" data-width="75%" 
                                title="Buscar" onchange="buscar()">
                                    <?php echo $opciones ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php echo $array_ini['socio'] ?>
                </div>
                <div class="col-xs-12"><hr style="margin: 0 0 10px 0"></div>
            </div>

            <form>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="txtUsuario" class="hidden-xs">
                                <?php echo $array_ini['usuario'] ?>
                            </label>
                            <input id="txtUsuario" name="txtUsuario" type="text" class="form-control" placeholder="Usuario"  onkeyup="funcionClave()">
                        </div>
                        <div class="form-group">
                            <label for="txClave" class="hidden-xs">
                                <?php echo $array_ini['clave'] ?>
                            </label>
                            <input id="txtClave" name="txtClave" type="text" class="form-control" placeholder="Clave" disabled="true">
                        </div>
                        <div class="form-group">
                            <label for="txtNombres" class="hidden-xs">
                                <?php echo $array_ini['nombres'] ?>
                            </label>
                            <input id="txtNombres" name="txtNombres" type="text" class="form-control" placeholder="Nombres Completos">
                        </div>
                        <div class="form-group">
                            <label for="txtEmail" class="hidden-xs">
                                <?php echo $array_ini['email'] ?>
                            </label>
                            <input id="txtEmail" name="txtEmail" type="text" class="form-control" placeholder="Correo">
                        </div>
                        <div class="form-group">
                            <label for="txtTelefono" class="hidden-xs">
                                <?php echo $array_ini['telefono'] ?>
                            </label>
                            <input id="txtTelefono" name="txtTelefono" type="text" class="form-control" placeholder="Teléfono">
                        </div>
                        <div class="form-group">
                            <label for="txtDireccion" class="hidden-xs">
                                <?php echo $array_ini['direccion'] ?>
                            </label>
                            <input id="txtDireccion" name="txtDireccion" type="text" class="form-control" placeholder="Dirección">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="txtPerfil" class="hidden-xs">
                                <?php echo $array_ini['perfil'] ?>
                            </label>
                            <select id="txtPerfil" name="txtPerfil" class="selectpicker form-control" >
                                <?php echo $optionsRol ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtDescripcion" class="hidden-xs">
                                <?php echo $array_ini['descripcion'] ?>
                            </label>
                            <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" rows="4" placeholder="Descripción"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="txtEstado" class="hidden-xs">
                                <?php echo $array_ini['estado'] ?>
                            </label>
                            <select class="form-control hidden-xs hidden-sm selectpicker" id="txtEstado" name="txtEstado">
                                <option value='1'>Activo</option> 
                                <option value='0'>Inactivo</option>
                            </select>
                        </div>
                    </div> 

                </div> <!-- ./row -->

                <!-- Barra de Navegacion Izquierda -->
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
                        <button type="button" name="operacion" value="cancelar" class="btn btn-default" onclick="resetear()">
                            <div class="glyphicon glyphicon-repeat"></div>
                            <?php echo $array_ini['cancelar'] ?>
                        </button>
                    </div>
                </div>

                <!-- Barra de Navegacion Inferior -->
                <div class="navbar-inverse navbar-fixed-bottom visible-xs visible-sm">
                    <div class="row">
                        <div class="col-xs-3 text-center">
                            <button type="button" class="btn btn-link" onclick="javascript:history.go(-1)">
                                <div class="row">
                                    <div >
                                        <div class="glyphicon glyphicon-circle-arrow-left" style="font-size: 20px"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php echo $array_ini['atras'] ?>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="col-xs-3 text-center">
                            <button type="button" name="operacion" value="actualizar" class="btn btn-link" onclick="actualizar()">
                                <div class="row ">
                                    <div >
                                        <div class="glyphicon glyphicon-floppy-disk" style="font-size: 20px"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php echo $array_ini['actualizar'] ?>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="col-xs-3 text-center">
                            <button type="button" name="operacion" value="eliminar" class="btn btn-link" onclick="eliminar()">
                                <div class="row ">
                                    <div >
                                        <div class="glyphicon glyphicon-trash" style="font-size: 20px"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php echo $array_ini['eliminar'] ?>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="col-xs-3 text-center">
                            <button type="button" name="operacion" value="reset" class="btn btn-link" onclick="resetear()">
                                <div class="row ">
                                    <div >
                                        <div class="glyphicon glyphicon-repeat" style="font-size: 20px"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php echo $array_ini['cancelar'] ?>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div> 

                <?php include '../../recursos/inc/pie.php'; ?>

            </form> <!-- ./form -->

        </div> <!-- ./container -->

    </body>
</html>


