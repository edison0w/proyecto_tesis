<?php
$array_ini = parse_ini_file("/recursos/properties.ini");
$direccion = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema JURECH</title>

        <!-- recursos CSS -->
        <link href="recursos/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <link href="recursos/css/bootstrap-switch.css" rel="stylesheet" type="text/css"/>
        <link href="recursos/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <link href="recursos/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="recursos/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
        <!-- recursos javascript -->
        <script src="recursos/js/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="recursos/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="recursos/js/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
        <script src="recursos/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="recursos/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $('.selectpicker').selectpicker({
                    showSubtext: true
                });
            })
        </script>
    </head>
    <body>
        <select class="selectpicker" data-container="body">
            <option data-subtext="hola">mundo</option>

        </select>
    </body>
</html>
