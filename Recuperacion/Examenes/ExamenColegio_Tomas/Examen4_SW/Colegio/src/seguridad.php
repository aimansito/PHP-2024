<?php

$headers[]="Authorization: Bearer ".$_SESSION["token"];
$url=DIR_SERV."/logueado";
$respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
$obj=json_decode($respuesta,true);
if(!$obj){
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
}
if(isset($obj["error"])){
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj["error"]."</p>"));
}

if(isset($obj["no_auth"])){
    session_unset();
    $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if(isset($obj["mensaje"])){
    session_unset();
    $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

$datos_usu_log=$obj["usuario"];
$_SESSION["token"]=$obj["token"];

if(time()-$_SESSION["ult_accion"]>MINUTOS*60){
    session_unset();
    $_SESSION["mensaje_seguridad"]="Su tiempo de sesión ha expiradoaaaa";
    header("Location:index.php");
    exit;
}

$_SESSION["ult_accion"]=time();

?>