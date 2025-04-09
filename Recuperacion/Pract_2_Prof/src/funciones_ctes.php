<?php
    define("SERVIDOR_BD","localhost");
    define("NOMBRE_BD","bd_rec_cv");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    define("TIEMPO_INACTIVIDAD",5);//En minutos

    function error_page($title,$body)
    {
        return '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>'.$title.'</title>
        </head>
        <body>'.$body.'      
        </body>
        </html>';
    }

    function repetido_insert($conexion,$tabla,$columna,$valor)
    {
        try{
            $consulta="select ".$columna." from ".$tabla." where ".$columna."=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$valor]);
            $respuesta=$sentencia->rowCount()>0;
        }
        catch(PDOException $e)
        {
            $respuesta="No se ha podido realizar la consulta: ".$e->getMessage();
        }
        $sentencia=null;
        return $respuesta;
    }
    function LetraNIF($dni) 
    {  
        return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1); 
    } 

    function dni_valido($texto)
    {
        $dni=strtoupper($texto);
        return LetraNIF(substr($dni,0,8))==substr($dni,-1);
    }

    function dni_bien_escrito($texto)
    {
        $dni=strtoupper($texto);
        return strlen($dni)==9 && is_numeric(substr($dni,0,8)) && substr($dni,-1)>="A" && substr($dni,-1)<="Z";
    }

    function tiene_extension($texto)
    {
        $array_nombre=explode(".",$texto);
        if(count($array_nombre)<=1)
            $respuesta=false;
        else
            $respuesta=end($array_nombre);

        return $respuesta;

    }
?>