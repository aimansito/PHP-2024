<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/saludo',function(){

    $respuesta["mensaje"]="Hola que tal?";
    echo json_encode($respuesta);
});

$app->get('/saludo/{nombre}',function($request){
    $name=$request->getAttribute("nombre");
    $respuesta["mensaje"]="Hola que tal, ".$name."?";
    echo json_encode($respuesta);
});

$app->post('/saludo',function($request){

    $nombre=$request->getParam("name");
    $respuesta["mensaje"]="Hola que tal, ".$nombre."?";
    echo json_encode($respuesta);

});

$app->delete('/borrar_saludo/{id}',function($request){
    $id=$request->getAttribute("id");
    $respuesta["mensaje"]="Mensaje con id: ".$id." borrado correctamente";
    echo json_encode($respuesta);
});

$app->put('/actualizar_saludo/{id}',function($request){
    $id=$request->getAttribute("id");
    $nombre_nuevo=$request->getParam("name");
    $respuesta["mensaje"]="Mensaje con id: ".$id." actualizado correctamente al valor: ".$nombre_nuevo;
    echo json_encode($respuesta);
});

$app->run();

?>