<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES.php";

$app= new \Slim\App;

$app->get('/logueado',function(){

    $test=validateToken();
    if(is_array($test))
    {
        echo json_encode($test);
    }
    else
        echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio"));  
});


$app->post('/login',function($request){
    
    $datos_login[]=$request->getParam("lector");
    $datos_login[]=$request->getParam("clave");


    echo json_encode(login($datos_login));
});

$app->post('/insertar_libros',function($request){
    $datos[]=$request->getParam("id_usuario");
    $datos[]=$request->getParam("lector");
    $datos[]=$request->getParam("clave");
    $datos[]=$request->getParam("tipo");

    echo json_decode(insertar_libros($datos));
});


$app->run();

?>