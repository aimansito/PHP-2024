<?php
// Se importan las clases necesarias del paquete Firebase JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Se incluye el autoloader generado por Composer para cargar automáticamente clases
require 'Firebase/autoload.php';

// Definimos constantes de configuración
define("PASSWORD_API","Una_clave_para_usar_para_encriptar"); // Clave secreta para firmar/verificar tokens JWT
define("MINUTOS_API",60);                                     // Duración del token en minutos
define("SERVIDOR_BD","localhost");                            // Servidor de la base de datos
define("USUARIO_BD","jose");                                  // Usuario de la base de datos
define("CLAVE_BD","josefa");                                  // Contraseña de la base de datos
define("NOMBRE_BD","bd_horarios_exam");                       // Nombre de la base de datos

//--------------------------------------------------------------
// FUNCIÓN: validateToken
// Valida un JWT recibido desde el header y renueva el token si es válido
//--------------------------------------------------------------
function validateToken()
{
    $headers = apache_request_headers(); // Obtiene cabeceras HTTP

    if(!isset($headers["Authorization"]))
        return false; // No hay token → acceso denegado

    $authorization = $headers["Authorization"];
    $authorizationArray = explode(" ", $authorization); // Formato: "Bearer <token>"
    $token = $authorizationArray[1];

    try {
        // Se decodifica el token usando la clave secreta y algoritmo HS256
        $info = JWT::decode($token, new Key(PASSWORD_API, 'HS256'));
    } catch (\Throwable $th) {
        return false; // Token inválido o expirado
    }

    // Conexión a la base de datos
    try {
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar: " . $e->getMessage();
        return $respuesta;
    }

    // Consulta para verificar que el usuario del token exista
    try {
        $consulta = "SELECT * FROM usuarios WHERE id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$info->data]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Se genera un nuevo token actualizado
        $payload['exp'] = time() + (MINUTOS_API * 60);
        $payload['data'] = $respuesta["usuario"]["id_usuario"];
        $jwt = JWT::encode($payload, PASSWORD_API, 'HS256');
        $respuesta["token"] = $jwt;
    } else {
        $respuesta["mensaje_baneo"] = "El usuario no se encuentra registrado en la BD";
    }

    return $respuesta;
}

//--------------------------------------------------------------
// FUNCIÓN: login
// Recibe credenciales (usuario y clave), valida y devuelve token si son correctas
//--------------------------------------------------------------
function login($datos_login)
{
    try {
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_login);
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido realizar la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Generar token
        $payload['exp'] = time() + (MINUTOS_API * 60);
        $payload['data'] = $respuesta["usuario"]["id_usuario"];
        $jwt = JWT::encode($payload, PASSWORD_API, 'HS256');
        $respuesta["token"] = $jwt;
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }

    return $respuesta;
}

//--------------------------------------------------------------
// FUNCIÓN: obtener_datos_usuario
// Devuelve todos los datos de un usuario a partir de su ID
//--------------------------------------------------------------
function obtener_datos_usuario($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido conectar a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "SELECT * FROM usuarios WHERE id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }

    return $respuesta;
}

//--------------------------------------------------------------
// FUNCIÓN: obtener_usuarios_guardia
// Devuelve los usuarios que tienen guardia en un día y hora concretos
//--------------------------------------------------------------
function obtener_usuarios_guardia($dia, $hora)
{
    try {
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        // Nota: asegurarse que la tabla sea `horario_guardias` y no `horario_lectivo`
        $consulta = "SELECT usuarios.* FROM usuarios, horario_guardias 
                     WHERE usuarios.id_usuario = horario_guardias.usuario 
                     AND dia=? AND hora=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    return $respuesta;
}

//--------------------------------------------------------------
// FUNCIÓN: obtener_guardias_profesor
// Devuelve las horas y días de guardia que tiene asignado un profesor
//--------------------------------------------------------------
function obtener_guardias_profesor($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "SELECT dia, hora FROM horario_lectivo WHERE usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["de_guardia"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    return $respuesta;
}
?>
