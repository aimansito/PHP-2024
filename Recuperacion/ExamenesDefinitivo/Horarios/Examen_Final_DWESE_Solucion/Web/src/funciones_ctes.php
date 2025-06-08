<?php
define("DIR_SERV","http://localhost/PHP-2024/Recuperacion/ExamenesDefinitivo/Horarios/Examen_Final_DWESE_Solucion/API_REST");
define("MINUTOS",10);
define("DIAS", array(
    0 => "Domingo",
    1 => "Lunes",
    2 => "Martes",
    3 => "Miércoles",
    4 => "Jueves",
    5 => "Viernes",
    6 => "Sábado"
));
const HORAS = array(
    1 => "8:15-9:15",
    2 => "9:15-10:15",
    3 => "10:15-11:15",
    4 => "11:15-11:45", // Recreo
    5 => "11:45-12:45",
    6 => "12:45-13:45",
    7 => "13:45-14:45"
);
function consumir_servicios_REST($url,$metodo,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}


function consumir_servicios_JWT_REST($url,$metodo,$headers,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    curl_setopt($llamada,CURLOPT_HTTPHEADER,$headers);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title, $body)
{
   return '<!DOCTYPE html>
   <html lang="es">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>'.$title.'</title>
   </head>
   <body>'.$body.'</body>
   </html>';
}

?>