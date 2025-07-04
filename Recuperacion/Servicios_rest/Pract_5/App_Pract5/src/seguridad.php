<?php

 
$url=DIR_SERV."/logueado";
$headers[] = 'Authorization: Bearer '.$_SESSION["token"];
$respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
$json_login=json_decode($respuesta,true);
if(!$json_login)
{
    session_destroy();
    die(error_page("Práctica5 - Rec","<h1>Práctica5 - Rec</h1><p>Error consumiendo el Servicio Web: <strong>".$url."</strong></p>"));
}

if(isset($json_login["no_auth"]))
{
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
    header("Location:".$salto);
    exit;
}

if(isset($json_login["error"]))
{
    session_destroy();
    die(error_page("Práctica5 - Rec","<h1>Práctica5 - Rec</h1><p>".$json_login["error"]."</p>"));
}


if(isset($json_login["mensaje_baneo"]))
{
    session_unset();//Me deslogueo
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:".$salto);
    exit;
}


// He pasado el control de baneo
// Dejo la conexión abierta y aprovecho para coger datos del usuario logueado

$datos_usu_log=$json_login["usuario"];
$_SESSION["token"]=$json_login["token"];



// Ahora controlo el tiempo de inactividad

if(time()-$_SESSION["ultm_accion"]>TIEMPO_INACTIVIDAD*60)
{
    session_unset();//Me deslogueo
    $_SESSION["mensaje_seguridad"]="Su tiempo de sesión ha expirado. Por favor, vuelva a loguearse";
    header("Location:".$salto);
    exit;
}

$_SESSION["ultm_accion"]=time();


?>