<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'Firebase/autoload.php';

define("PASSWORD_API","Una_clave_para_usar_para_encriptar");
define("MINUTOS_API",60);
define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_horarios_exam2");


function validateToken()
{
    
    $headers = apache_request_headers();
    if(!isset($headers["Authorization"]))
        return false;//Sin autorizacion
    else
    {
        $authorization = $headers["Authorization"];
        $authorizationArray=explode(" ",$authorization);
        $token=$authorizationArray[1];
        try{
            $info=JWT::decode($token,new Key(PASSWORD_API,'HS256'));
        }
        catch(\Throwable $th){
            return false;//Expirado
        }

        try{
            $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        }
        catch(PDOException $e){
            
            $respuesta["error"]="Imposible conectar:".$e->getMessage();
            return $respuesta;
        }

        try{
            $consulta="select * from usuarios where id_usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$info->data]);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
            $sentencia=null;
            $conexion=null;
            return $respuesta;
        }
        if($sentencia->rowCount()>0)
        {
            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
         
            $payload['exp']=time()+(MINUTOS_API*60);
            $payload['data']= $respuesta["usuario"]["id_usuario"];
            $jwt = JWT::encode($payload,PASSWORD_API,'HS256');
            $respuesta["token"]=$jwt;
        }
            
        else
            $respuesta["mensaje_baneo"]="El usuario no se encuentra registrado en la BD";

        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
    
}


function login($datos_login)
{
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos_login);

    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="No he podido realizarse la consulta: ".$e->getMessage();
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        $payload['exp']=time()+(MINUTOS_API*60);
        $payload['data']= $respuesta["usuario"]["id_usuario"];
        $jwt = JWT::encode($payload,PASSWORD_API,'HS256');
        $respuesta["token"]=$jwt;

    }
    else
        $respuesta["mensaje"]="El usuario no se encuentra en la BD";
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtener_profesores_guardias($id_usuario){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select horario_lectivo.dia , horario_lectivo.hora, grupos.nombre as grupo, aulas.nombre as aula from horario_lectivo, aulas, grupos where horario_lectivo.aula=aulas.id_aula and horario_lectivo.grupo=grupos.id_grupo and usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    }catch(PDOException $e){
        $conexion=null;
        $sentencia=null;
        $respuesta["error"]="No se ha podido realizar la consulta".$e->getMessage();
    }

    if($sentencia->rowCount()>0){
        $respuesta["profesores"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function obtenerGrupos(){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from upos";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }catch(PDOException $e){
        $conexion=null;
        $sentencia=null;
        $respuesta["error"]="No se ha podido realizar la consulta".$e->getMessage();
    }

    if($sentencia->rowCount()>0){
        $respuesta["grupos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function horarioGrupo($id_grupo){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select horario_lectivo.dia, horario_lectivo.hora, usuarios.usuario as profe , aulas.nombre as aula
                   from horario_lectivo
                   join usuarios on horario_lectivo.usuario = usuarios.id_usuario
                   join aulas on horario_lectivo.aula = aulas.id_aula
                   where horario_lectivogr.grupo=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_grupo]);
    }catch(PDOException $e){
        $conexion=null;
        $sentencia=null;
        $respuesta["error"]="No se ha podido realizar la consulta".$e->getMessage();
    }

    $respuesta["horario"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function profesores($dia,$hora,$id_grupo){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select usuarios.id_usuario, usuarios.usuario as profe, aulas.nombre as aula
                   from horario_lectivo
                   join usuarios on horario_lectivo.usuario = usuarios.id_usuario
                   join aulas on horario_lectivo.aula = aulas.id_aula
                   where horario_lectivo.dia=? and horario_lectivo.hora=? and horario_lectivo.grupo=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$dia,$hora,$id_grupo]);
    }catch(PDOException $e){
        $conexion=null;
        $sentencia=null;
        $respuesta["error"]="No se ha podido realizar la consulta".$e->getMessage();
    }

    $respuesta["profesores"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function obtenerAulas(){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from aulas";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }catch(PDOException $e){
        $conexion=null;
        $sentencia=null;
        $respuesta["error"]="No se ha podido realizar la consulta".$e->getMessage();
    }

    if($sentencia->rowCount()>0){
        $respuesta["aulas"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function profesoresLibres($dia,$hora,$id_grupo){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "SELECT usuarios.id_usuario, usuarios.nombre FROM usuarios WHERE tipo!='admin' AND id_usuario not in (select usuario from horario_lectivo where dia=? and hora=? and grupo=?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia,$hora,$id_grupo]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        $respuesta["error"]="No se ha podido realizar la consulta".$e->getMessage();
        return $respuesta;
    }

    $respuesta["profesores_libres"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function borrarProfesores($dia,$hora,$id_grupo,$id_usuario){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "delete from horario_lectivo where dia=? and hora = ? and grupo=? and usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia,$hora,$id_grupo,$id_usuario]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        $respuesta["error"]="No se ha podido realizar la consulta".$e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"]="Profesor borrado con éxito";

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function insertarProfesores($dia,$hora,$id_grupo,$id_usuario,$id_aula){
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="No he podido conectarse a la base de batos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta = "insert into horario_lectivo(usuario,dia,hora,grupo,aula) values(?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia,$hora,$id_grupo,$id_usuario,$id_aula]);
    }catch(PDOException $e){
        $sentencia = null;
        $conexion = null;
        $respuesta["error"]="No se ha podido realizar la consulta".$e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"]="Profesor insertado con éxito";

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
?>