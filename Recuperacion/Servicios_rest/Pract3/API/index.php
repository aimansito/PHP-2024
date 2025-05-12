<?php

require __DIR__ . '/Slim/autoload.php';
require __DIR__ . 'src/funciones_ctes';

$app= new \Slim\App;

$app->post('/login',function($request){

    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    echo json_encode(login($usuario,$clave));
});



$app->run();

?>