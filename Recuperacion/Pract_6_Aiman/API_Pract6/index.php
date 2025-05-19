<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_ctes.php";

$app= new \Slim\App;

//A partir de aquí se crean los métodos de la API



$app->post('/login',function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    echo json_encode(login($usuario,$clave));

});


$app->get('/logueado',function(){
    $test=validateToken();
    if(is_array($test))
        echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>