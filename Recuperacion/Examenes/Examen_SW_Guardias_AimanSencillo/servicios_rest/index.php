<?php
require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES.php";

$app = new \Slim\App;

$app->get('/logueado', function () {
    $test = validateToken();
    if (is_array($test)) {
        echo json_encode($test);
    } else {
        echo json_encode(array("no-auth" => "No tienes permiso para usar el servicio"));
    }
});

$app->post('/login', function ($request) {
    $datos_login[] = $request->getParam("usuario");
    $datos_login[] = $request->getParam("clave");

    echo json_encode(login($datos_login));
});

$app->get('/usuario/{id_usuario}', function ($request) {
    $test = validateToken();
        $id_usuario = $request->getAttribute('id_usuario');

        echo json_encode(usuario($id_usuario)); 

});


$app->get('/usuariosGuardia/{dia}/{hora}', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            $dia = $request->getAttribute('dia');
            $hora = $request->getAttribute('hora');

            echo json_encode(usuariosGuardia($dia, $hora));
        } else {
            json_encode($test);
        }
    } else {
        echo json_encode(array("no-auth" => "No tienes permiso para usar el servicio"));
    }
});
$app->run();
