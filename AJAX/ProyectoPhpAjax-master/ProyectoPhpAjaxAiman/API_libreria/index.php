<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES.php";

$app = new \Slim\App;

$app->get('/logueado', function () {

    $test = validateToken();
    if (is_array($test)) {
        echo json_encode($test);
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});

$app->post('/login', function ($request) {

    $datos_login[] = $request->getParam("lector");
    $datos_login[] = $request->getParam("clave");


    echo json_encode(login($datos_login));
});

$app->get('/obtenerLibros', function () {

    echo json_encode(obtener_libros());
});

$app->get('/obtenerLibro/{referencia}', function ($request) {

    $test = validateToken();

    if (is_array(($test))) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] === "admin") {
                $respuesta = obtener_libro($request->getAttribute("referencia"));
                $respuesta["token"] = $test["token"];
                echo json_encode($respuesta);
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode(($test));
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->delete('/borrarLibro/{referencia}', function ($request) {

    $test = validateToken();

    if (is_array(($test))) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] === "admin") {
                $respuesta = borrar_libro($request->getAttribute("referencia"));
                $respuesta["token"] = $test["token"];
                echo json_encode($respuesta);
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode(($test));
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->put('/actualizarLibro/{referencia}', function ($request) {

    $test = validateToken();

    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {
                $datos_actualizar[] = $request->getParam("titulo");
                $datos_actualizar[] = $request->getParam("autor");
                $datos_actualizar[] = $request->getParam("descripcion");
                $datos_actualizar[] = $request->getParam("precio");
                $datos_actualizar[] = $request->getParam("portada");
                $datos_actualizar[] = $request->getAttribute("referencia");

                $respuesta = actualizar_libro($datos_actualizar);
                $respuesta["token"] = $test["token"];

                echo json_encode($respuesta);
            } else
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
        } else {
            echo json_encode($test);
        }
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});

$app->post('/insertarLibro', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {
                $datos_insert[] = $request->getParam("referencia");
                $datos_insert[] = $request->getParam("titulo");
                $datos_insert[] = $request->getParam("autor");
                $datos_insert[] = $request->getParam("descripcion");
                $datos_insert[] = $request->getParam("precio");
                $datos_insert[] = $request->getParam("portada");

                $respuesta = insertar_libro($datos_insert);
                $respuesta["token"] = $test["token"];

                echo json_encode($respuesta);
            } else
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
        } else {
            echo json_encode($test);
        }
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});

$app->get('/repetido/{referencia}', function ($request) {

    $test = validateToken();

    if (is_array(($test))) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] === "admin") {
                $respuesta = repetido($request->getAttribute("referencia"));
                $respuesta["token"] = $test["token"];
                echo json_encode($respuesta);
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode(($test));
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});
$app->run();
