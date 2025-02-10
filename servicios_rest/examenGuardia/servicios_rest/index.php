<?php
require "src/funciones_ctes.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->get('/conexion_PDO',function($request){
    echo json_encode( conexion_pdo(), JSON_FORCE_OBJECT);
});

$app->get('/conexion_MYSQLI',function($request){
    echo json_encode( conexion_mysqli(), JSON_FORCE_OBJECT);
});

$app->post('/login',function($request){
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode( login($datos), JSON_FORCE_OBJECT);
});
?>
