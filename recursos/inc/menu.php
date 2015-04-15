<div class="navbar-wrapper">
    <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="border-radius: 0">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only"><?php $array_ini['botonnavegacion'] ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/principal.php">
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span> 
                    <?php echo $array_ini['jurech'] ?>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="menu">

                <?php if ($_SESSION['rol']->getRol() == "Operador") { ?>

                    <ul class="nav navbar-nav">
                        <li class="<?php echo $_SESSION['mSocio'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/socios/index.php">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                <?php echo $array_ini['socios'] ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mTerreno'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/terrenos/index.php">
                                <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> 
                                <?php echo $array_ini['terrenos'] ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mCultivo'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/cultivos/index.php">
                                <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span> 
                                <?php echo $array_ini['cultivos'] ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mReporte'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/reportes/index.php">
                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span> 
                                <?php echo $array_ini['reportes'] ?>
                            </a>
                        </li>
                    </ul>

                <?php } elseif ($_SESSION['rol']->getRol() == "Administrador") { ?>

                    <ul class="nav navbar-nav">
                        <li class="<?php echo $_SESSION['mSocio'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/usuarios/index.php">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                <?php echo $array_ini['usuarios'] ?>
                            </a>
                        </li>
                    </ul>

                <?php } elseif ($_SESSION['rol']->getRol() == "Socio") { ?>
                    <ul class="nav navbar-nav">
                        <li class="<?php echo $_SESSION['mSocio'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/socio/misDatos.php">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                <?php echo $array_ini['misDatos'] ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mTerreno'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/socio/misTerrenos.php">
                                <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> 
                                <?php echo $array_ini['misTerrenos'] ?>
                            </a>
                        </li>
                        <li class="<?php echo $_SESSION['mCultivo'] ?>">
                            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/socio/misCultivos.php">
                                <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span> 
                                <?php echo $array_ini['misCultivos'] ?>
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
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/vistas/usuarios/misDatos.php">
                                    <?php echo $_SESSION['usuario']->getNombres(); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>/ProyectoTesis/controlador/conSesion.php">
                                    <?php echo $array_ini['cerrarsesion'] ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div><!-- /.navbar-collapse -->

        </nav> <!-- /.navigation -->

    </div> <!-- ./container -->
</div> <!-- ./navbar-wrapper -->
