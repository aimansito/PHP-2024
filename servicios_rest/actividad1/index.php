<?php
    require __DIR__ . '/Slim/autoload.php';
    require "src/funciones_ctes.php";

    $app= new \Slim\App;
    $app->get('/productos',function(){
        echo json_encode(obtener_productos());
    });

    $app->get('/producto/{codigo}',function($request){
        $cod=$request->getAttribute("codigo");
        echo json_encode(obtener_producto($cod));
    });


    $app->run();

?>