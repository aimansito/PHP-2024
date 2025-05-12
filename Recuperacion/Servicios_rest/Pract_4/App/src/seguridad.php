<?php


$url=DIR_API."/logueado";
$datos_env["usuario"]=$_SESSION["usuario"];
$datos_env["clave"]=$_SESSION["clave"];

$respuesta=consumir_servicios_REST($url,"POST",$datos_env);
$json_respuesta=json_decode($respuesta,true);
if(!$json_respuesta)
{
    session_destroy();
    die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
}

if(isset($json_respuesta["error"]))
{
    session_destroy();
    die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
}


if(isset($json_respuesta["mensaje"]))
{
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}


$datos_usu_log=$json_respuesta["usuario"];


//Acabo de pasar el control de Baneo y compruebo la inactividad

if(time()-$_SESSION["ultm_accion"]>TIEMPO_INACTIVIDAD*60)
{
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}

//Acabo de pasar el control de inactividad y renuevo el tiempo
$_SESSION["ultm_accion"]=time();


?>