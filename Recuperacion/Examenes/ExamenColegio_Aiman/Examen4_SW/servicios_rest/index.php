<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_servicios.php";

$app = new \Slim\App;

// B
$app->get('/logueado', function () {
    $test = validateToken();
    if (is_array($test)) {
        echo json_encode($test);
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->post('/login', function ($request) {
    $datos_login[] = $request->getParam("usuario");
    $datos_login[] = $request->getParam("clave");
    echo json_encode(login($datos_login));
});

/*
E) Mediante una petición GET, obtener todas las asignaturas evaluadas junto a su nota de un
alumno. Para ello aportaremos la clave de sesión mediante un array asociativo con índice
“api_session”. En caso de error por la BD el JSON devuelto será: {“error” : “Error….”}, en otro
caso el JSON será: { “notas” : [{“cod_asig” : “valor1”, “denominacion” : “valor2”, “nota” : ”valor3”},…,
{“cod_asig” : “valorN1”, “denominacion” : “valorN2”, “nota” : ”valorN3”}]}
URL de la petición:
http://localhost/Proyectos/Examen4_SW/servicios_rest/notasAlumno/{cod_alu}, dónde
cod_alu es un atributo pasado por la url para indicar el alumno en cuestión. */

$app->get('/notasAlumno/{cod_alu}', function ($request) {
    $cod_alu = $request->getAttribute('cod_alu');
    echo json_encode(obtenerNotas($cod_alu));
    /* $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "alumno") {
                $cod_alu = $request->getAttribute('cod_alu');
                echo json_encode(obtenerNotas($cod_alu));
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
        */
});
$app->run();
