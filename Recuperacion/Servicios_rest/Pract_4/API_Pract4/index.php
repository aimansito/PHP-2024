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


$app->post('/logueado',function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    echo json_encode(login($usuario,$clave));

});

$app->get('/repetido_insert/{tabla}/{columna}',function($request){
    $tabla=$request->getAttribute("tabla");
    $columna=$request->getAttribute("columna");
    $valor=$request->getParam("valor");
    echo json_encode(repetido_insert($tabla,$columna,$valor));

});

$app->post('/insertar_usuario',function($request){
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("clave");
    $datos[]=$request->getParam("dni");
    $datos[]=$request->getParam("sexo");
    $datos[]=$request->getParam("subscripcion");

    echo json_encode(insertar_usuario($datos));

});

$app->put('/actualizar_foto/{id_usuario}',function($request){
    $id_usuario=$request->getAttribute("id_usuario");
    $foto=$request->getParam("foto");
  
    echo json_encode(actualizar_foto($id_usuario,$foto));

});


//usuario,nombre,clave,dni,sexo,subscripcion


// Una vez creado servicios los pongo a disposición
$app->run();
?>