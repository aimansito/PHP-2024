<?php

    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }catch(PDOException $e){
        session_destroy();
        die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido conectar a la base de batos: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_SESSION["usuario"],$_SESSION["clave"]]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido conectar a la base de batos: ".$e->getMessage()."</p>"));
    }


    if($sentencia->rowCount()<=0){
        session_unset();
        $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
        $sentencia = null;
        $conexion = null;
        header("Location:index.php");
        exit;
    }

    $datos_usu_log=$sentencia->fetch(PDO::FETCH_ASSOC);
    $sentencia=null;

    if(time()-$_SESSION["ultm_accion"]>TIEMPO_INACTIVIDAD*60);{
        session_unset();
        $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
        header("Location:index.php");
        exit;
    }

    $_SESSION["ultm_accion"]=time();
?>