<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Jurech">
        <meta name="keywords" content="Junta, Guano Chambo, Riego">
        <title>Jurech</title>
    </head>
    <body>
        <?php
        $array_ini = parse_ini_file(__DIR__ . "/recursos/properties.ini");
        $page = $array_ini['protocolo'] . $_SERVER['HTTP_HOST'] . $array_ini['proyecto'] . $array_ini['login'];
        header("Location: $page");
        exit;
        ?>
    </body>
</html>
