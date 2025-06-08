<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



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

$app->get('/grupos',function(){
    
    echo json_encode( obtener_grupos(), JSON_FORCE_OBJECT);
});

$app->get('/horario/{id_grupo}',function($request){
    
    $datos[] = $request->getAttribute("id_grupo");

    echo json_encode( obtener_horario_grupo($datos), JSON_FORCE_OBJECT);
});

$app->get('/profesoresLibres/{dia}/{hora}/{id_grupo}',function($request){
    
    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_grupo");

    echo json_encode( obtener_profesores_libres($datos), JSON_FORCE_OBJECT);
});

$app->get('/aulas',function(){
    
    echo json_encode( obtener_aulas(), JSON_FORCE_OBJECT);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
