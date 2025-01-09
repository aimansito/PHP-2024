<?php

require __DIR__ . '/Slim/autoload.php';
define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_tienda");

function obtener_productos(){
    try{
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));    }catch(PDOException $e){
        $respuesta["error"]="No he podido conectarse a la base de datos: ".$e->getMessage();
        return $respuesta;
    }
    try{
        $consulta="select * from producto";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido conectarse a la base de datos: ".$e->getMessage();
        return $respuesta;
    }
    $respuesta["productos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function obtener_producto($cod){
    try{
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));    }catch(PDOException $e){
        $respuesta["error"]="No he podido conectarse a la base de datos: ".$e->getMessage();
        return $respuesta;
    }
    try{
        $consulta="select * from producto where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$cod]);
    }catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido conectarse a la base de datos: ".$e->getMessage();
        return $respuesta;
    }
    if($sentencia->rowCount()<=0){
        $respuesta["mensaje"]="El producto con cod: ".$cod."no se encuentra en la BD";
    }else{
        $respuesta["producto"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
$app= new \Slim\App;

    $app->get('/productos',function(){
        echo json_encode(obtener_productos());
    });
    
$app->run();
?>