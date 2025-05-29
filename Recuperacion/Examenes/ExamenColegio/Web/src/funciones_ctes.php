<?php
define("DIR_SERV","http://localhost/PHP-2024/Recuperacion/Examenes/ExamenColegio/API_REST/");
define("MINUTOS",10);

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



function obtener_notas_alumno($cod_usu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas, notas WHERE asignaturas.cod_asig=notas.cod_asig and cod_usu=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

   
    $respuesta["notas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        
   
    $sentencia=null;
    $conexion=null;
    return $respuesta;
    
}


function obtener_alumnos()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT * from usuarios where tipo='alumno'";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

   
    $respuesta["alumnos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        
   
    $sentencia=null;
    $conexion=null;
    return $respuesta;
    
}

function quitar_nota_alumno_asig($cod_usu,$cod_asig)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="DELETE from notas where cod_usu=? and cod_asig=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu,$cod_asig]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

   
    $respuesta["mensaje"]="Asignatura descalificada con éxito";
        
   
    $sentencia=null;
    $conexion=null;
    return $respuesta;
    
}


function cambiar_nota_alumno_asig($cod_usu,$cod_asig,$nota)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="UPDATE notas set nota=? where cod_usu=? and cod_asig=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$nota,$cod_usu,$cod_asig]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

   
    $respuesta["mensaje"]="Asignatura cambiada con éxito";
        
   
    $sentencia=null;
    $conexion=null;
    return $respuesta;
    
}


function obtener_notas_no_eval_alumno($cod_usu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from asignaturas where cod_asig not in (select cod_asig from notas where cod_usu=?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

   
    $respuesta["asignaturas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        
   
    $sentencia=null;
    $conexion=null;
    return $respuesta;
    
}

function poner_nota_asig($cod_usu,$cod_asig)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
       
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="INSERT into notas (cod_usu,cod_asig,nota) values (?,?,0)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod_usu,$cod_asig]);
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

   
    $respuesta["mensaje"]="Asignatura calificada con éxito";
        
   
    $sentencia=null;
    $conexion=null;
    return $respuesta;
    
}


?>