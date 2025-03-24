<?php
define("SERVIDOR_BD", "localhost");
define("NOMBRE_BD", "bd_rec_cv");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");

function error_page($title, $body)
{
    return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'.$title.'</title>
</head>
<body>
    '.$body.'
</body>
</html>';
}
