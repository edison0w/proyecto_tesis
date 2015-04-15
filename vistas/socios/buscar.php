<?php
require __DIR__ . "/../../modelo/clsUsuario.php";
require __DIR__ . "/../../modelo/clsSocio.php";
require __DIR__ . "/../../modelo/clsRol.php";
require __DIR__ . "/../../recursos/utilitarios.php";
session_start();
$array_ini = parse_ini_file("../../recursos/properties.ini");
$direccion = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'];
$objSocio = new clsSocio();
$listaSocios = $objSocio->buscarTodos();
$opciones = tablaDatosBuscar($listaSocios);
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
        <link href="../../recursos/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../recursos/css/style.css" rel="stylesheet" type="text/css"/>
        <!-- recursos javascript -->
        <script src="../../recursos/js/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../../recursos/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../recursos/js/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
        <script src="../../recursos/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script>
            function activarBotones() {
                var btnActualizar = document.getElementById("btnActualizar");
                btnActualizar.disabled = false;
                var btnEliminar = document.getElementById("btnEliminar");
                btnEliminar.disabled = false;
                var btnTerrenos = document.getElementById("btnTerrenos");
                btnTerrenos.disabled = false;
                var btnCancelar = document.getElementById("btnCancelar");
                btnCancelar.disabled = false;
            }
            function desactivarBotones() {
                var btnActualizar = document.getElementById("btnActualizar");
                btnActualizar.disabled = true;
                var btnEliminar = document.getElementById("btnEliminar");
                btnEliminar.disabled = true;
                var btnTerrenos = document.getElementById("btnTerrenos");
                btnTerrenos.disabled = true;
                var btnCancelar = document.getElementById("btnCancelar");
                btnCancelar.disabled = true;
            }
            function formularioPostBuscar(codSocio) {
                return "txtCodigo=" + encodeURIComponent(codSocio.value) +
                        "&operacion=" + encodeURIComponent('buscar') +
                        "&nocache=" + Math.random();
            }
            function buscar() {
                var codSocio = document.getElementById('txtBuscar');
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                        activarBotones();

                        var jsonObj = JSON.parse(xmlhttp.responseText);
                        if (jsonObj) {
                            var codigo = document.getElementById("txtCodigo");
                            codigo.value = jsonObj.CODIGO;
                            var cedula = document.getElementById("txtCedula");
                            cedula.value = jsonObj.CI;
                            cedula.disabled = false;
                            var apellidos = document.getElementById("txtApellidos");
                            apellidos.value = jsonObj.APELLIDO;
                            apellidos.disabled = false;
                            var direccion = document.getElementById("txtDireccion");
                            direccion.value = jsonObj.DIRECCION;
                            direccion.disabled = false;
                            var telefono = document.getElementById("txtTelefono");
                            telefono.value = jsonObj.TELEFONO;
                            telefono.disabled = false;
                            var celular = document.getElementById("txtCelular");
                            celular.value = jsonObj.CELULAR;
                            celular.disabled = false;
                            var email = document.getElementById("txtEmail");
                            email.value = jsonObj.EMAIL;
                            email.disabled = false;
                            var estadoCivil = document.getElementById("txtEstadoCivil");
                            estadoCivil.value = jsonObj.ESTADO_CIVIL;
                            estadoCivil.disabled = false;
                            $('#txtEstadoCivil').selectpicker('refresh');
                            var conyuge = document.getElementById("txtConyuge");
                            conyuge.value = jsonObj.NOMBRE_CONYUGE;
                            if (estadoCivil.value == "Casado/a" || estadoCivil.value == "Union Libre") {
                                conyuge.disabled = false;
                            } else {
                                conyuge.disabled = true;
                            }
                            var genero = document.getElementById("txtGenero");
                            genero.value = jsonObj.GENERO;
                            genero.disabled = false;
                            $('#txtGenero').selectpicker('refresh');
                            var tipoPersona = document.getElementById("txtTipoPersona");
                            tipoPersona.value = jsonObj.TIPO;
                            tipoPersona.disabled = false;
                            $('#txtTipoPersona').selectpicker('refresh');
                            var obs = document.getElementById("txtObservacion");
                            obs.value = jsonObj.OBS;
                            obs.disabled = false;
                        } else {
                            resetear();
                        }

                    }
                }
                xmlhttp.open("POST", "../../controlador/conSocio.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostBuscar(codSocio));
            }
            function formularioPostEliminar() {
                var codSocio = document.getElementById('txtCodigo');
                return "txtCodSocio=" + encodeURIComponent(codSocio.value) +
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
                        $('#confirmacion').modal('hide');
                        $.bootstrapGrowl(xmlhttp.responseText, {
                            type: 'info',
                            align: 'right',
                            stackup_spacing: 30,
                            delay: 1500
                        });
                        if (xmlhttp.responseText == "Socio eliminado correctamente") {
                            resetear();
                            // eliminar del combobox buscar al socio
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
                xmlhttp.open("POST", "../../controlador/conSocio.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(formularioPostEliminar());
            }
            function formularioPostActualizar() {
                var codigo = document.getElementById('txtCodigo');
                var cedula = document.getElementById('txtCedula');
                var apellido = document.getElementById('txtApellidos');
                var direccion = document.getElementById('txtDireccion');
                var telefono = document.getElementById('txtTelefono');
                var celular = document.getElementById('txtCelular');
                var email = document.getElementById('txtEmail');
                var estadoCivil = document.getElementById('txtEstadoCivil');
                var conyuge = document.getElementById('txtConyuge');
                var genero = document.getElementById('txtGenero');
                var tipoPersona = document.getElementById('txtTipoPersona');
                var observacion = document.getElementById('txtObservacion');

                return "txtCodigo=" + encodeURIComponent(codigo.value) +
                        "&txtCedula=" + encodeURIComponent(cedula.value) +
                        "&txtApellidos=" + encodeURIComponent(apellido.value) +
                        "&txtDireccion=" + encodeURIComponent(direccion.value) +
                        "&txtTelefono=" + encodeURIComponent(telefono.value) +
                        "&txtCelular=" + encodeURIComponent(celular.value) +
                        "&txtEmail=" + encodeURIComponent(email.value) +
                        "&txtEstadoCivil=" + encodeURIComponent(estadoCivil.value) +
                        "&txtConyuge=" + encodeURIComponent(conyuge.value) +
                        "&txtGenero=" + encodeURIComponent(genero.value) +
                        "&txtTipoPersona=" + encodeURIComponent(tipoPersona.value) +
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
                xmlhttp.open("POST", "../../controlador/conSocio.php", true);
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
                            var codigo = document.getElementById("txtCodigo");
                            codigo.value = jsonObj.CODIGO;
                            var cedula = document.getElementById("txtCedula");
                            cedula.value = jsonObj.CI;
                            cedula.disabled = false;
                            var apellidos = document.getElementById("txtApellidos");
                            apellidos.value = jsonObj.APELLIDO;
                            apellidos.disabled = false;
                            var direccion = document.getElementById("txtDireccion");
                            direccion.value = jsonObj.DIRECCION;
                            direccion.disabled = false;
                            var telefono = document.getElementById("txtTelefono");
                            telefono.value = jsonObj.TELEFONO;
                            telefono.disabled = false;
                            var celular = document.getElementById("txtCelular");
                            celular.value = jsonObj.CELULAR;
                            celular.disabled = false;
                            var email = document.getElementById("txtEmail");
                            email.value = jsonObj.EMAIL;
                            email.disabled = false;
                            var estadoCivil = document.getElementById("txtEstadoCivil");
                            estadoCivil.value = jsonObj.ESTADO_CIVIL;
                            estadoCivil.disabled = false;
                            $('#txtEstadoCivil').selectpicker('refresh');
                            var conyuge = document.getElementById("txtConyuge");
                            conyuge.value = jsonObj.NOMBRE_CONYUGE;
                            if (estadoCivil.value == "Casado/a" || estadoCivil.value == "Union Libre") {
                                conyuge.disabled = false;
                            } else {
                                conyuge.disabled = true;
                            }
                            var genero = document.getElementById("txtGenero");
                            genero.value = jsonObj.GENERO;
                            genero.disabled = false;
                            $('#txtGenero').selectpicker('refresh');
                            var tipoPersona = document.getElementById("txtTipoPersona");
                            tipoPersona.value = jsonObj.TIPO;
                            tipoPersona.disabled = false;
                            $('#txtTipoPersona').selectpicker('refresh');
                            var obs = document.getElementById("txtObservacion");
                            obs.value = jsonObj.OBS;
                            obs.disabled = false;
                        }

                    }
                }
                xmlhttp.open("POST", "../../controlador/conSocio.php", true);
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
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var codigo = document.getElementById("txtCodigo");
                        codigo.value = 0;
                        
                        var buscar = document.getElementById("txtBuscar");
                        buscar.value = 0;
                        $('#txtBuscar').selectpicker('refresh');
                        
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
                        desactivarBotones();
                    }
                }
                xmlhttp.open("POST", "../../controlador/conSocio.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send("operacion=resetear"  + "&nocache=" + Math.random());
            }
        </script>
    </head>
    <body onload="cargarSesion()">
        <?php include '../../recursos/inc/menu.php'; ?>

        <!-- texto oculto / codigo socio sesion -->
        <input type="hidden" id="txtCodigo" value="<?php echo $_SESSION['socio']->getCodigo() ?>">

        <div id="margen-top" class="container">

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
                            <label for="txtCedula" class="hidden-xs">
                                <?php echo $array_ini['cedula'] ?>
                            </label>
                            <input id="txtCedula" name="txtCedula" type="text" class="form-control" placeholder="Cédula" disabled>
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
                            <select id="txtEstadoCivil" name="txtEstadoCivil" class="selectpicker form-control" disabled onchange="comprobarConyuge()">
                                <option><?php echo $array_ini['casado'] ?></option>
                                <option><?php echo $array_ini['soltero'] ?></option>
                                <option><?php echo $array_ini['viudo'] ?></option>
                                <option><?php echo $array_ini['divorsiado'] ?></option>
                                <option><?php echo $array_ini['unionlibre'] ?></option>
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
                            <select class="form-control selectpicker" id="txtGenero" name="txtGenero" disabled>
                                <option value='M'><?php echo $array_ini['masculino'] ?></option> 
                                <option value='F'><?php echo $array_ini['femenino'] ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtTipoPersona" class="hidden-xs">
                                <?php echo $array_ini['tipopersona'] ?>
                            </label>
                            <select id="txtTipoPersona" name="txtTipoPersona" class="form-control selectpicker" disabled>
                                <option><?php echo $array_ini['natural'] ?></option> 
                                <option><?php echo $array_ini['juridica'] ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtObservacion" class="hidden-xs">
                                <?php echo $array_ini['observacion'] ?>
                            </label>
                            <textarea id="txtObservacion" name="txtObservacion" class="form-control" rows="4" placeholder="Observación" disabled></textarea>
                        </div>
                    </div> <!-- ./jumbotron -->
                </div>

                <!-- Dialogo de confirmación -->
                <div id="confirmacion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                Confirmación
                            </div>
                            <div class="modal-body">
                                <p>Está seguro que quiere eliminar?</p>
                                <button id="btnNo" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="button" class="btn btn-default" onclick="eliminar();">Si</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barra de Navegacion Izquierda -->
                <div class="row hidden-xs hidden-sm">
                    <div class="container">
                        <button id="btnActualizar" type="button" name="operacion" value="actualizar" class="btn btn-info" onclick="actualizar()" disabled="true">
                            <div class="glyphicon glyphicon-floppy-disk"></div>
                            <?php echo $array_ini['actualizar'] ?>
                        </button>
                        <button id="btnEliminar" type="button" name="operacion" value="eliminar" class="btn btn-danger" data-toggle='modal' 
                                data-target='#confirmacion' disabled="true">
                            <div class="glyphicon glyphicon-trash"></div>
                            <?php echo $array_ini['eliminar'] ?>
                        </button>
                        <button id="btnTerrenos" type="button" name="operacion" value="terrenos" class="btn btn-success" onclick="location.href = '../terrenos/todos.php'" disabled="true">
                            <div class="glyphicon glyphicon-globe"></div>
                            <?php echo $array_ini['terrenos'] ?>
                        </button>
                        <button id="btnCancelar" type="button" name="operacion" value="cancelar" class="btn btn-default" onclick="resetear()" disabled="true">
                            <div class="glyphicon glyphicon-repeat"></div>
                            <?php echo $array_ini['cancelar'] ?>
                        </button>
                    </div>
                </div>


                <!-- Barra de Navegacion Inferior -->
                <div class="navbar-inverse navbar-fixed-bottom visible-xs visible-sm">
                    <div class="row">
                        <div class="col-xs-3 text-center">
                            <button id="btnActualizar" type="button" name="operacion" value="actualizar" class="btn btn-link" onclick="actualizar()">
                                <div class="row ">
                                    <div class="col-xs-12">
                                        <div class="glyphicon glyphicon-floppy-disk" style="font-size: 20px"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php echo $array_ini['actualizar'] ?>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="col-xs-3 text-center">
                            <button id="btnEliminar" type="button" name="operacion" value="eliminar" class="btn btn-link" onclick="eliminar()">
                                <div class="row ">
                                    <div class="col-xs-12">
                                        <div class="glyphicon glyphicon-trash" style="font-size: 20px"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php echo $array_ini['eliminar'] ?>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="col-xs-3 text-center">
                            <button id="btnTerrenos" type="button" name="operacion" value="reset" class="btn btn-link" onclick="location.href = '../terrenos/todos.php'">
                                <div class="row ">
                                    <div class="col-xs-12">
                                        <div class="glyphicon glyphicon-globe" style="font-size: 20px"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php echo $array_ini['terrenos'] ?>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="col-xs-3 text-center">
                            <button id="btnCancelar" type="button" name="operacion" value="reset" class="btn btn-link" onclick="resetear()">
                                <div class="row ">
                                    <div class="col-xs-12">
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

