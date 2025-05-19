<?php
    if(isset($_POST["btnContBorrar"])){
        $url=DIR_API."/borrar_usuario/".$_POST["btnContBorrar"];
        $respuesta=consumir_servicios_JWT_REST($url,"DELETE",$headers);
        $json_respuesta=json_decode($respuesta,true);
    }
?>