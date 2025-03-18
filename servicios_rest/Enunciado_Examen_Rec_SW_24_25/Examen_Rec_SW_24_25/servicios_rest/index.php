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
    
    $datos_login[]=$request->getParam("usuario");
    $datos_login[]=$request->getParam("clave");


    echo json_encode(login($datos_login));
});

$app->get('/obtener_usuarios', function($request){
    $datos_login[]=$request->getParam(); 
    echo json_encode(obtener_usuarios());
});

$app->post('/insertar_tablas',function($request){
    $datos_login[]=$request->getParam($cod);
    $datos_login[]=$request->getParam($usuario);
    $datos_login[]=$request->getParam($dia);
    $datos_login[]=$request->getParam($hora);

    echo json_encode(insertar_tablas($cod,$usuario,$dia,$hora));
});




$app->run();

?>