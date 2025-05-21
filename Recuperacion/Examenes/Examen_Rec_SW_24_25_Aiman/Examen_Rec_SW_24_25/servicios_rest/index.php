<?php

// Carga automática de clases de Slim Framework
require __DIR__ . '/Slim/autoload.php';

// Importamos el archivo donde están definidas las funciones y constantes
require "src/funciones_CTES.php";

// Creamos una nueva aplicación Slim
$app = new \Slim\App;

//--------------------------------------------------------------
// ENDPOINT: GET /logueado
// Verifica si el token es válido. Renueva token si lo es.
//--------------------------------------------------------------
$app->get('/logueado', function () {
    $test = validateToken(); // Intenta validar el JWT

    if (is_array($test)) {
        // Si es un array, todo está correcto → se devuelve el usuario y el nuevo token
        echo json_encode($test);
    } else {
        // Si no es un array (es false), el token es inválido
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

//--------------------------------------------------------------
// ENDPOINT: POST /login
// Recibe usuario y clave, devuelve token si son válidos
//--------------------------------------------------------------
$app->post('/login', function ($request) {
    // Extrae los parámetros del cuerpo del POST
    $datos_login[] = $request->getParam("usuario");
    $datos_login[] = $request->getParam("clave");

    // Llama a la función login() y devuelve el resultado como JSON
    echo json_encode(login($datos_login));
});

//--------------------------------------------------------------
// ENDPOINT: GET /usuario/{id_usuario}
// Devuelve los datos del usuario si el token es válido
//--------------------------------------------------------------
$app->get('/usuario/{id_usuario}', function ($request) {
    $test = validateToken(); // Validamos el token

    if (is_array($test)) {
        // Si está autenticado y contiene datos del usuario...
        if (isset($test["usuario"])) {
            // Se devuelve la info del usuario con ID dado en la URL
            echo json_encode(obtener_datos_usuario($request->getAttribute("id_usuario")));
        } else {
            // Token válido, pero usuario no encontrado
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no-auth" => "No tienes permiso para usar el servicio"));
    }
});

//--------------------------------------------------------------
// ENDPOINT: GET /usuarioGuardia/{dia}/{hora}
// Devuelve todos los profesores de guardia en un día y hora concretos
//--------------------------------------------------------------
$app->get('/usuarioGuardia/{dia}/{hora}', function ($request) {
    $test = validateToken(); // Validamos el token

    if (is_array($test)) {
        if (isset($test["usuario"])) {
            // Llamamos a la función que consulta la guardia según día y hora
            echo json_encode(obtener_usuarios_guardia(
                $request->getAttribute("dia"),
                $request->getAttribute("hora")
            ));
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no-auth" => "No tienes permiso para usar el servicio"));
    }
});

//--------------------------------------------------------------
// ENDPOINT: GET /deGuardia/{id_usuario}
// Devuelve los días y horas en los que un profesor tiene guardia
//--------------------------------------------------------------
$app->get('/deGuardia/{id_usuario}', function ($request) {
    $test = validateToken(); // Validamos el token

    if (is_array($test)) {
        if (isset($test["usuario"])) {
            // Devuelve las guardias del usuario con ID especificado
            echo json_encode(obtener_guardias_profesor($request->getAttribute("id_usuario")));
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no-auth" => "No tienes permiso para usar el servicio"));
    }
});

//--------------------------------------------------------------
// Ejecuta la aplicación Slim y pone el servidor en marcha
//--------------------------------------------------------------
$app->run();

?>
