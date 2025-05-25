<?php
   $headers[]="Authorization: Bearer ".$_SESSION["token"];
   $url = DIR_SERV . "/logueado";

   $respuesta = consumir_servicios_JWT_REST($url,"GET",$headers);
   $json_respuesta = json_decode($respuesta,true);

   //Verificacion del formato de respuesta
   if(!$json_respuesta){
      session_destroy();
      die(error_page("Gestión de Guardias", "<h1>Gestión de Guardias</h1><p>Error consumiendo el servicio REST: <strong>$url</strong></p>"));
   }

   //Error general del servicio
   if(isset($json_respuesta["error"])){
      session_destroy();
      die(error_page("Gestión de Guardias", "<h1>Gestión de Guardias</h1><p>Error consumiendo el servicio REST: <strong>$url</strong></p>"));
   }

   //No autenticado
   if(isset($json_respuesta["no-auth"])){
      session_unset();
      $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
      header("Location:index.php");
      exit;
   }

   //Usuario eliminado de la BD
   if(isset($json_respuesta["mensaje_baneo"])){
      session_unset();
      $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra en la BD";
      header("Location:index.php");
      exit;
   }

   //datos del usuario obtenidos
   $datos_usu_log = $json_respuesta["usuario"];
   //Guardamos el nuevo token devuelto para renovarlo continuamente
   $_SESSION["token"]=$json_respuesta["token"];
   //Verificacion del tiempo sw inactividad local
   if(time()-$_SESSION["ultm_accion"]>MINUTOS*60){
      session_unset();
      $_SESSION["mensaje_seguridad"]="Su tiempo de sesion ha expirado";
      header("Location:index.php");
      exit;
   }

   //Actualizacion del tiempo de la ultima accion
   $_SESSION["ultm_accion"]=time();
?>