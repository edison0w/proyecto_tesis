<div class="navbar-wrapper">
    <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="border-radius: 0">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" 
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only"><?php $array_ini['botonnavegacion'] ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/principal.php"
                   title="Inicio del Sistema">
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span> 
                    <?php echo "Jurech" ?>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="menu">

                <?php if ($_SESSION['rol']->getRol() == "Operador") { ?>

                    <ul class="nav navbar-nav">
                        <li class="<?php echo $_SESSION['mSocio'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/socios/index.php"
                               title="Gestión de Socios">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                <?php echo "Socios" ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mTerreno'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/terrenos/index.php"
                               title="Gestión de Terrenos">
                                <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> 
                                <?php echo "Terrenos" ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mCultivo'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/cultivos/index.php"
                               title="Gestión de Cultivos">
                                <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span> 
                                <?php echo "Cultivos" ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mReporte'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/reportes/index.php"
                               title="Gestión de Reportes">
                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span> 
                                <?php echo "Reportes" ?>
                            </a>
                        </li>
                    </ul>

                <?php } elseif ($_SESSION['rol']->getRol() == "Administrador") { ?>

                    <ul class="nav navbar-nav">
                        <li class="<?php echo $_SESSION['mSocio'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/usuarios/index.php"
                               title="Gestión de Usuarios">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                <?php echo "Usuarios" ?>
                            </a>
                        </li>
                    </ul>

                <?php } elseif ($_SESSION['rol']->getRol() == "Socio") { ?>
                    <ul class="nav navbar-nav">
                        <li class="<?php echo $_SESSION['mSocio'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/socio/misDatos.php">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                <?php echo "Mis Datos" ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mTerreno'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/socio/misTerrenos.php">
                                <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> 
                                <?php echo "Mis Terrenos" ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mCultivo'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/socio/misCultivos.php">
                                <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span> 
                                <?php echo "Mis Cultivos" ?>
                            </a>
                        </li>
                    </ul>
                <?php } ?>

                <!-- Perfil y Cerrar Sesion-->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['rol']->getRol(); ?>&nbsp;<span class="caret"></span>&nbsp;&nbsp;&nbsp;</a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/jurechgis/vistas/usuarios/misDatos.php">
                                    <?php echo $_SESSION['usuario']->getNombres(); ?>
                                </a>
                            </li>
                            <li>
                                <a 
                                   data-toggle='modal' data-target='#confirmacionSalir'>
                                    <?php echo "Cerrar Sesión" ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div><!-- /.navbar-collapse -->

        </nav> <!-- /.navigation -->

    </div> <!-- ./container -->

    <script>
        $('#confirmacionSalir').on('shown.bs.modal', function () {
            $('#btnNo').focus();
        })
        function salir(){
            location.href='/jurechgis/controlador/conSesion.php';
        }
    </script>
    <!-- Dialogo de confirmación -->
    <div id="confirmacionSalir" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Confirmación
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que quiere salir del sistema?</p>
                    <button id="btnNo" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-default" 
                            onclick="salir();">Si</button>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ./navbar-wrapper -->
