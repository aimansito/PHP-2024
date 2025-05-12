<?php
define("SERVIDOR_BD","localhost");
define("NOMBRE_BD","bd_rec_cv");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");

function login($usuario, $clave)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No se ha podido conectar a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    else
        $respuesta["mensaje"]="Usuario no se encuentra en la BD";

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function repetido_insert($tabla,$columna,$valor)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No se ha podido conectar a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select ".$columna." from ".$tabla." where ".$columna."=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor]);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        return $respuesta;
    }

    
    $respuesta["repetido"]=$sentencia->rowCount()>0;
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function insertar_usuario($datos)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No se ha podido conectar a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="insert into usuarios (usuario,nombre,clave,dni,sexo,subscripcion) values (?,?,?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        return $respuesta;
    }

    
    $respuesta["ultm_id"]=$conexion->lastInsertId();
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function actualizar_foto($id_usuario,$foto)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No se ha podido conectar a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="update usuarios set foto=? where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$foto,$id_usuario]);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        return $respuesta;
    }

    
    $respuesta["mensaje"]="Imagen cambiada con éxito";
    

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
?>