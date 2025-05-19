<?php   
    $url=DIR_API."/logueado";
    $headers[] = 'Authorization: Bearer '.$_SESSION["token"];
    $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_respuesta=json_decode($respuesta,true);
    
    
    if(!$json_respuesta){
        session_destroy();
        die(error_page("Práctica6 - Rec","<h1>Práctica6 - Rec</h1><p>Error consumiendo el Servicio Web: <strong>".$url."</strong></p>"));
    }

    if(isset($json_respuesta["error"])){
        session_destroy();
        die(error_page("Práctica6 - Rec","<h1>Práctica6 - Rec</h1><p>Error consumiendo el Servicio Web: <strong>".$url."</strong></p>"));
    }
    if(isset($json_respuesta["no_auth"])){
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }
    if(isset($json_respuesta["mensaje_baneo"])){
        session_unset();
        $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    
    $datos_usu_log=$json_respuesta["usuario"];
    $_SESSION["token"]=$json_respuesta["token"];

    // Acabo de pasar el control de baneo y compruebo la inactividad

    if(time()-$_SESSION["ultm_accion"]>TIEMPO_INACTIVIDAD*60){
        session_unset();
        $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["ultm_accion"]=time();
?>