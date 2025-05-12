<?php 
    define("SERVIDOR_BD","localhost");
    define("NOMBRE_BD","bd_rec_cv");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    
    function login($usuario,$clave){
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch(PDOException $e)
        {
            $respuesta["error"]="No se ha podido realizar la conexion: ".$e->getMessage();
            return $respuesta;
        }
    
        try{
            $consulta ="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$usuario,$clave]);
        }catch(PDOException $e){
            $sentencia=null;
            $conexion=null;
            $respuesta["error"]="No se ha podido realizar la consulta ".$e->getMessage();
            return $respuesta;
        }
    
        if($sentencia->rowCount()>0){
            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        }else{
            $respuesta["mensaje"]="Usuario no se encuentra en la BD";
        }
    
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
?>