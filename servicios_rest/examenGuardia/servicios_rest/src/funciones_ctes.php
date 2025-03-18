<?php
require "config_bd.php";

function conexion_pdo(){
    try{
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAME 'utfs8'"));
        $respuesta["mensaje"]="Conexion realizada con éxito";
        $conexion = null;
    } catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
        
    }
    return $respuesta;
}
function conexion_mysqli(){
    @$conexion = mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar: ".mysqli_connect_errno()." : ".mysqli_connect_error();
    else {
        mysqli_set_charset($conexion,"utf8");
        $respuesta["mensaje"]="Conexión a la BD realizada con éxito ";
        mysqli_close($conexion);
    }
    return $respuesta;
}

function login($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);

        if($sentencia->execute(($datos))){
            if($sentencia->rowCount()>0){
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);

            }else{
                $respuesta["mensaje"]="Usuario no se encuentra registrado";
            }
        }else{
            $respuesta["error"]="Errror en la consulta, error num: ".$sentencia->errorInfo()[1]." ERROR: ".$sentencia->errorInfo()[2];
        }
        $conexion = null;
        $sentencia = null;
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}
function obtener_grupos(){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta = "select * from grupos";
        $sentencia = $conexion->prepare($consulta);

        if($sentencia->execute()){
            $respuesta["grupos"]= $sentencia->fetchAll(PDO::FETCH_ASSOC);

        }else{
            $respuesta["error"]="Error en la consulta, error num: ".$sentencia->errorInfo()[1]." Error: ".$sentencia->errorInfo()[2];
        }
        $conexion=null;
        $sentencia=null;
    } catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function obtener_horario_grupo($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta = "select horario_lectivo.dia, horario_lectivo.hora, usuarios.usuario, aulas.nombre from horario_lectivo, usuarios, aulas
        where horario_lectivo.usuario = usuarios.id_usuario and horario_lectivo.aula = aulas.id_aula and horario_lectivo.grupo = ?";
        $sentencia = $conexion->prepare($consulta);

        if($sentencia->execute($datos)){
            $respuesta["horario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $respuesta["error"] = "Error en la consulta, Error num: ".$sentencia->errorInfo()[1].$sentencia->errorInfo()[2];
        }
        $conexion = null;
        $sentencia = null;
    }catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }
    return $respuesta;
}
function obtener_profesores_libres($datos){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $consulta = "select usuarios.id_usuario, usuarios.nombre from usuarios where(usuarios.id_usuario, usuarios.nombre) not in
        (select usuarios.id_usuario, usuarios.nombre from usuarios, horario_lectivo where usuarios.id_usuario = horario_lectivo.usuario
        and horario_lectivo.dia = ? and horario_lectivo.hora = ? and horario_lectivo.grupo = ? and usuarios.tipo <> 'admin')";

        $sentencia = $conexion->prepare($consulta);
        if($sentencia->execute($datos)){
            
        }
    }
}
?>