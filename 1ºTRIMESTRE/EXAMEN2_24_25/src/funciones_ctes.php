<?php
    // Constantes para la conexión a la base de datos
    const SERVIDOR_BD="localhost"; // Dirección del servidor de la base de datos
    const USUARIO_BD="jose";       // Usuario para acceder a la base de datos
    const CLAVE_BD="josefa";       // Contraseña para el usuario de la base de datos
    const NOMBRE_BD="bd_libreria_exam"; // Nombre de la base de datos

    // Constante para el tiempo máximo de inactividad (en minutos)
    const INACTIVIDAD=2; // Tiempo máximo permitido antes de cerrar sesión por inactividad

    // Función para generar una página de error
    function error_page($title, $body){
        // Se construye un HTML básico con un título y un contenido de cuerpo
        $html='<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html.='<title>'.$title.'</title></head>'; // Añade el título en la cabecera
        $html.='<body>'.$body.'</body></html>';   // Añade el contenido del cuerpo
        return $html; // Devuelve el HTML generado
    }

    // Función para verificar si un valor está repetido en una columna de una tabla
    function repetido($conexion, $tabla, $columna, $valor){
        try{
            // Se construye una consulta SQL para buscar el valor en la columna especificada
            $consulta="select ".$columna." from ".$tabla." where ".$columna."='".$valor."'";
            $result_consulta=mysqli_query($conexion, $consulta); // Se ejecuta la consulta
            $respuesta=mysqli_num_rows($result_consulta)>0; // Verifica si hay al menos un resultado
            mysqli_free_result($result_consulta); // Libera los recursos de la consulta
        }catch(Exception $e){
            $respuesta=$e->getMessage(); // Si ocurre un error, devuelve el mensaje de error
        }

        return $respuesta; // Devuelve si el valor está repetido o un mensaje de error
    }

    // Función para obtener la extensión de un archivo
    function extension($name){
        $array_trozos=explode(".", $name); // Divide el nombre del archivo en partes separadas por "."
        if(count($array_trozos)>1)
            $respuesta=end($array_trozos); // Si hay más de una parte, toma la última como extensión
        else{
            $respuesta=false; // Si no hay ".", devuelve false
        }
        return $respuesta; // Devuelve la extensión del archivo o false
    }
?>
