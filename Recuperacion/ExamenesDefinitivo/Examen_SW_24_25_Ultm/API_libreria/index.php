<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES.php";

$app = new \Slim\App;

$app->get('/logueado', function () {

    $test = validateToken();
    if (is_array($test)) {
        echo json_encode($test);
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});


$app->post('/login', function ($request) {

    $datos_login[] = $request->getParam("lector");
    $datos_login[] = $request->getParam("clave");

    echo json_encode(login($datos_login));
});

$app->get('/obtenerLibros', function () {

    echo json_encode(obtenerLibros());
});

$app->post('/crearLibro', function ($request) {

    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {
                $datos_libro[] = $request->getParam("referencia");
                $datos_libro[] = $request->getParam("titulo");
                $datos_libro[] = $request->getParam("autor");
                $datos_libro[] = $request->getParam("descripcion");
                $datos_libro[] = $request->getParam("precio");

                echo json_encode(crearLibro($datos_libro));
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode($test);
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
                $datos_libro[] = $request->getParam("titulo");
                $datos_libro[] = $request->getParam("autor");
                $datos_libro[] = $request->getParam("descripcion");
                $datos_libro[] = $request->getParam("precio");
                $datos_libro[] = $request->getAttribute("referencia");

                echo json_encode(actualizarLibro($datos_libro));
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->delete('/borrarLibro/{referencia}', function ($request) {

    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {

                $ref = $request->getAttribute("referencia");

                echo json_encode(borrarLibro($ref));
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {

    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {

                $tabla = $request->getAttribute("tabla");
                $columna = $request->getAttribute("columna");
                $valor = $request->getAttribute("valor");

                echo json_encode(repetido($tabla, $columna, $valor));
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->get('/obtenerLibro/{referencia}', function ($request) {

    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {

                $ref = $request->getAttribute("referencia");

                echo json_encode(obtenerLibro($ref));
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->run();
