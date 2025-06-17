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

$app->get('/horarioProfesor/{id_usuario}',function($request){
    $test=validateToken();

    if(is_array($test)){
        if(isset($test["usuario"])){
            if($test["usuario"]["tipo"]=="normal"){
                echo json_encode(obtener_profesores_guardias($request->getAttribute("id_usuario")));
            }else{
                echo json_encode(array("no-auth"=>"No tienes permiso para usar este servicio"));
            }
        }else{
            echo json_encode($test);
        }
    }else{
        echo json_encode(array("no-auth"=>"No tienes permiso para usar este servicio"));
    }
});

$app->get('/obtenerGrupos/',function($request){
    $test=validateToken();
    if(is_array($test)){
        if(isset($test["usuario"])){
            if($test["usuario"]["tipo"]=="admin"){
                echo json_encode(obtenerGrupos());
            }else{
                echo json_encode(array("no-auth"=>"No tienes permiso para usar este servicio"));
            }
        }else{
            echo json_encode($test);
        }
    }else{
        echo json_encode(array("no-auth"=>"No tienes permiso para usar este servicio"));
    }
});


$app->run();

?>